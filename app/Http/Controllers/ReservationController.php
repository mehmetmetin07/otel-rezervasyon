<?php

namespace App\Http\Controllers;

use App\Exports\ReservationsExport;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\ActivityLog;
use App\Mail\ReservationConfirmation;
use App\Mail\WelcomeCheckin;
use App\Mail\GoodbyeCheckout;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    /**
     * ReservationController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Reservation::class, 'reservation');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $date = $request->get('date');
        $search = $request->get('search');
        $export = $request->get('export');

        $query = Reservation::with(['customer', 'room', 'room.roomType', 'user']);

        // Durum filtreleme
        if ($status) {
            $query->where('status', $status);
        }

        // Tarih filtreleme
        if ($date) {
            $date = Carbon::parse($date);
            $query->where(function ($q) use ($date) {
                $q->whereDate('check_in', '<=', $date)
                  ->whereDate('check_out', '>=', $date);
            });
        }

        // Arama sorgusu
        if ($search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })
            ->orWhereHas('room', function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%");
            });
        }

        // CSV dışa aktarma
        if ($export === 'excel') {
            // Filtrelenmiş verileri al
            $reservationsData = $query->get();

            // CSV başlıkları
            $headers = [
                'ID',
                'Müşteri Adı',
                'Müşteri Soyadı',
                'Oda Numarası',
                'Oda Tipi',
                'Giriş Tarihi',
                'Çıkış Tarihi',
                'Toplam Fiyat',
                'Durum',
                'Oluşturulma Tarihi'
            ];

            // CSV içeriğini oluştur
            $callback = function() use ($reservationsData, $headers) {
                $file = fopen('php://output', 'w');

                // UTF-8 BOM ekle (Excel'de Türkçe karakterleri düzgün göstermek için)
                fputs($file, "\xEF\xBB\xBF");

                // Başlıkları yaz
                fputcsv($file, $headers);

                // Verileri yaz
                foreach ($reservationsData as $reservation) {
                    fputcsv($file, [
                        $reservation->id,
                        $reservation->customer->first_name,
                        $reservation->customer->last_name,
                        $reservation->room->room_number,
                        $reservation->room->roomType->name,
                        $reservation->check_in->format('d.m.Y'),
                        $reservation->check_out->format('d.m.Y'),
                        number_format($reservation->total_price, 2),
                        $this->getStatusText($reservation->status),
                        $reservation->created_at->format('d.m.Y H:i')
                    ]);
                }

                fclose($file);
            };

            // CSV dosyasını indir
            $filename = 'rezervasyonlar_' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            return response()->stream($callback, 200, $headers);
        }

        $reservations = $query->orderByDesc('created_at')->paginate(10);

        return view('reservations.index', compact('reservations', 'status', 'date', 'search'));
    }

    /**
     * Rezervasyon durumunun Türkçe karşılığını döndürür
     */
    private function getStatusText($status)
    {
        $statusMap = [
            'pending' => 'Onay Bekliyor',
            'confirmed' => 'Onaylandı',
            'checked_in' => 'Check-in Yapıldı',
            'checked_out' => 'Check-out Yapıldı',
            'cancelled' => 'İptal Edildi'
        ];

        return $statusMap[$status] ?? $status;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $customers = Customer::orderBy('last_name')->get();
        $rooms = Room::where('status', 'available')->with('roomType')->get();

        return view('reservations.create', compact('customers', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Eğer yeni müşteri oluşturuluyorsa
        if (empty($request->customer_id) && $request->has('first_name') && $request->has('last_name')) {
            // Yeni müşteri için validasyon
            $customerData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'identity_number' => 'required|string|max:20',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:100',
                'country' => 'nullable|string|max:100',
                'notes' => 'nullable|string',
            ]);

            // identity_number'dan id_number'a dönüştürme
            $customerData['id_number'] = $customerData['identity_number'];
            unset($customerData['identity_number']);

            // E-posta adresi varsa ve daha önce kullanılmışsa mevcut müşteriyi bul
            if (!empty($customerData['email'])) {
                $existingCustomer = Customer::where('email', $customerData['email'])->first();
                if ($existingCustomer) {
                    // Mevcut müşteriyi kullan
                    $customer = $existingCustomer;
                    // Oluşturulan müşterinin ID'sini request'e ekle
                    $request->merge(['customer_id' => $customer->id]);
                } else {
                    // Yeni müşteri oluştur
                    $customer = new Customer($customerData);
                    $customer->save();

                    // Oluşturulan müşterinin ID'sini request'e ekle
                    $request->merge(['customer_id' => $customer->id]);

                    // Aktivite logu oluştur (sadece yeni müşteri için)
                    try {
                        $log = new \App\Models\ActivityLog();
                        $log->user_id = Auth::id();
                        $log->action = 'Müşteri Oluşturuldu';
                        $log->model_type = 'Customer';
                        $log->model_id = $customer->id;
                        $log->description = $customer->first_name . ' ' . $customer->last_name . ' adlı yeni müşteri oluşturuldu.';
                        $log->ip_address = $request->ip();
                        $log->user_agent = $request->userAgent();
                        $log->save();
                    } catch (\Exception $e) {
                        report($e);
                    }
                }
            } else {
                // E-posta yoksa yeni müşteri oluştur
                $customer = new Customer($customerData);
                $customer->save();

                // Oluşturulan müşterinin ID'sini request'e ekle
                $request->merge(['customer_id' => $customer->id]);

                // Aktivite logu oluştur
                try {
                    $log = new \App\Models\ActivityLog();
                    $log->user_id = Auth::id();
                    $log->action = 'Müşteri Oluşturuldu';
                    $log->model_type = 'Customer';
                    $log->model_id = $customer->id;
                    $log->description = $customer->first_name . ' ' . $customer->last_name . ' adlı yeni müşteri oluşturuldu.';
                    $log->ip_address = $request->ip();
                    $log->user_agent = $request->userAgent();
                    $log->save();
                } catch (\Exception $e) {
                    report($e);
                }
                        }
        }

        // Rezervasyon için validasyon
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Oda müsait mi kontrol et
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailable()) {
            return back()->withErrors(['room_id' => 'Seçilen oda müsait değil.'])->withInput();
        }

        // Oda kapasitesi kontrolü
        $totalGuests = $validated['adults'] + ($validated['children'] ?? 0);
        if ($totalGuests > $room->roomType->capacity) {
            return back()->withErrors([
                'adults' => "Bu oda maksimum {$room->roomType->capacity} kişilik kapasiteye sahiptir. Toplam misafir sayısı: {$totalGuests}"
            ])->withInput();
        }

        // Tarihler arasında rezervasyon var mı kontrol et
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        $conflictingReservation = Reservation::where('room_id', $validated['room_id'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($conflictingReservation) {
            $roomNumber = $room->room_number ?? $room->number;
            $conflictDates = $conflictingReservation->check_in->format('d.m.Y') . ' - ' . $conflictingReservation->check_out->format('d.m.Y');
            return back()->withErrors([
                'check_in' => "Oda {$roomNumber} için belirtilen tarihlerde başka bir rezervasyon bulunuyor. (Çakışan rezervasyon: {$conflictDates})"
            ])->withInput();
        }

        // Toplam fiyat hesapla
        $days = $checkIn->diffInDays($checkOut);
        $pricePerDay = $room->roomType->base_price + $room->price_adjustment;
        $totalPrice = $pricePerDay * $days;

        // Rezervasyon oluştur
        $reservation = new Reservation([
            'customer_id' => $validated['customer_id'],
            'room_id' => $validated['room_id'],
            'user_id' => Auth::id(),
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $reservation->save();

        // Oda durumunu güncelle
        $room->updateStatus('reserved');

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Rezervasyon Oluşturuldu';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = $room->number . ' numaralı oda için ' . $reservation->customer->name . ' adına yeni rezervasyon oluşturuldu.';
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // SMTP ayarları aktifse e-posta gönder
        try {
            $customer = Customer::find($validated['customer_id']);
            if ($customer && $customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($customer->email)->send(new ReservationConfirmation($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Rezervasyon başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation): View
    {
        $reservation->load(['customer', 'room', 'room.roomType', 'user', 'minibarConsumptions', 'laundryServices', 'orders']);

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation): View
    {
        $customers = Customer::orderBy('last_name')->get();

        // Seçilebilir odalar (mevcut oda + müsait odalar)
        $availableRooms = Room::where('status', 'available')->with('roomType')->get();
        $currentRoom = Room::findOrFail($reservation->room_id);

        $rooms = $availableRooms->push($currentRoom)->unique('id');

        return view('reservations.edit', compact('reservation', 'customers', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        // Kapasite kontrolü (hem oda değiştirilirken hem de kişi sayısı değiştirilirken)
        $room = Room::findOrFail($validated['room_id']);
        $totalGuests = $validated['adults'] + ($validated['children'] ?? 0);
        if ($totalGuests > $room->roomType->capacity) {
            return back()->withErrors([
                'adults' => "Bu oda maksimum {$room->roomType->capacity} kişilik kapasiteye sahiptir. Toplam misafir sayısı: {$totalGuests}"
            ])->withInput();
        }

        // Oda değiştiriliyorsa, yeni oda müsait mi kontrol et
        if ($validated['room_id'] != $reservation->room_id) {
            $newRoom = Room::findOrFail($validated['room_id']);
            if (!$newRoom->isAvailable()) {
                return back()->withErrors(['room_id' => 'Seçilen oda müsait değil.'])->withInput();
            }

            // Eski odanın durumunu güncelle
            $oldRoom = Room::findOrFail($reservation->room_id);
            $oldRoom->updateStatus('available');

            // Yeni odanın durumunu güncelle
            $newRoom->updateStatus('reserved');
        }

        // Tarihler değiştiriliyorsa, çakışma kontrolü yap
        $currentCheckIn = $reservation->check_in ? $reservation->check_in->format('Y-m-d') : null;
        $currentCheckOut = $reservation->check_out ? $reservation->check_out->format('Y-m-d') : null;

        if ($validated['check_in'] != $currentCheckIn || $validated['check_out'] != $currentCheckOut) {

            $checkIn = Carbon::parse($validated['check_in']);
            $checkOut = Carbon::parse($validated['check_out']);

            $conflictingReservation = Reservation::where('room_id', $validated['room_id'])
                ->where('id', '!=', $reservation->id)
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->whereBetween('check_in', [$checkIn, $checkOut])
                        ->orWhereBetween('check_out', [$checkIn, $checkOut])
                        ->orWhere(function ($q) use ($checkIn, $checkOut) {
                            $q->where('check_in', '<=', $checkIn)
                              ->where('check_out', '>=', $checkOut);
                        });
                })
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($conflictingReservation) {
                $roomNumber = $room->room_number ?? $room->number;
                $conflictDates = $conflictingReservation->check_in->format('d.m.Y') . ' - ' . $conflictingReservation->check_out->format('d.m.Y');
                return back()->withErrors([
                    'check_in' => "Oda {$roomNumber} için belirtilen tarihlerde başka bir rezervasyon bulunuyor. (Çakışan rezervasyon: {$conflictDates})"
                ])->withInput();
            }

            // Toplam fiyat güncelle
            $days = $checkIn->diffInDays($checkOut);
            $room = Room::findOrFail($validated['room_id']);
            $pricePerDay = $room->roomType->base_price + $room->price_adjustment;
            $totalPrice = $pricePerDay * $days;

            $validated['total_price'] = $totalPrice;
        }

        // Debug: Güncelleme öncesi ve sonrası veriler
        \Log::info('Rezervasyon güncelleme - Öncesi:', $reservation->toArray());
        \Log::info('Rezervasyon güncelleme - Validated data:', $validated);

        $reservation->update($validated);

        \Log::info('Rezervasyon güncelleme - Sonrası:', $reservation->fresh()->toArray());

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'updated';
            $log->model_type = 'App\Models\Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' güncellendi. Güncellenen alanlar: ' . implode(', ', array_keys($validated));
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // SMTP ayarları aktifse e-posta gönder
        try {
            $customer = Customer::find($validated['customer_id']);
            if ($customer && $customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($customer->email)->send(new ReservationConfirmation($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Rezervasyon başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        // Rezervasyonu iptal et
        $reservation->updateStatus('cancelled');

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Rezervasyon İptal Edildi';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' iptal edildi.';
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // SMTP ayarları aktifse e-posta gönder
        try {
            if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($reservation->customer->email)->send(new ReservationConfirmation($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return redirect()->route('reservations.index')
            ->with('success', 'Rezervasyon başarıyla iptal edildi.');
    }

    /**
     * Rezervasyonu onayla
     */
    public function confirm(Reservation $reservation): RedirectResponse
    {
        $this->authorize('confirm', $reservation);

        $reservation->updateStatus('confirmed');

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Rezervasyon Onaylandı';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' onaylandı.';
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // SMTP ayarları aktifse e-posta gönder
        try {
            if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($reservation->customer->email)->send(new ReservationConfirmation($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Rezervasyon başarıyla onaylandı.');
    }

    /**
     * Check-in yap (Manuel)
     */
    public function checkIn(Reservation $reservation): RedirectResponse
    {
        $this->authorize('checkIn', $reservation);

        $reservation->updateStatus('checked_in');

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Manuel Check-in Yapıldı';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' için manuel check-in yapıldı.';
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // Manuel check-in'de e-posta gönderilmez
        // Sadece otomatik check-in'de e-posta gönderilir

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Manuel check-in işlemi başarıyla tamamlandı. (E-posta gönderilmedi)');
    }

    /**
     * Check-out yap
     */
    public function checkOut(Reservation $reservation): RedirectResponse
    {
        $this->authorize('checkOut', $reservation);

        $reservation->updateStatus('checked_out');

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Check-out Yapıldı';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' için check-out yapıldı.';
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        // Hoşçakal e-postası gönder
        try {
            if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($reservation->customer->email)->send(new GoodbyeCheckout($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Check-out işlemi başarıyla tamamlandı.');
    }

    /**
     * Rezervasyonun faturasını oluştur
     */
    public function generateInvoice(Reservation $reservation)
    {
        $reservation->load(['customer', 'room', 'room.roomType', 'minibarConsumptions', 'laundryServices', 'orders']);

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Fatura Oluşturuldu';
            $log->model_type = 'Reservation';
            $log->model_id = $reservation->id;
            $log->description = 'Rezervasyon #' . $reservation->id . ' için fatura oluşturuldu.';
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        $pdf = \PDF::loadView('reservations.invoice', compact('reservation'));

        // SMTP ayarları aktifse e-posta gönder
        try {
            if ($reservation->customer && $reservation->customer->email && config('mail.mailers.smtp.host')) {
                Mail::to($reservation->customer->email)
                    ->send(new ReservationConfirmation($reservation));
            }
        } catch (\Exception $e) {
            // E-posta gönderimi başarısız olsa bile işleme devam et
            report($e);
        }

        return $pdf->download('Invoice-' . $reservation->id . '.pdf');
    }
}
