<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * RoomController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $type = $request->get('type');
        $floor = $request->get('floor');
        $search = $request->get('search');

        $query = Room::with('roomType');

        // Durum filtreleme
        if ($status) {
            $query->where('status', $status);
        }

        // Oda tipi filtreleme
        if ($type) {
            $query->where('room_type_id', $type);
        }

        // Kat filtreleme
        if ($floor) {
            $query->where('floor', $floor);
        }

        // Arama sorgusu
        if ($search) {
            $query->where('room_number', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('roomType', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $rooms = $query->orderBy('room_number')->paginate(10);
        $roomTypes = RoomType::all();
        $floors = Room::select('floor')->distinct()->orderBy('floor')->pluck('floor')->toArray();

        return view('rooms.index', compact('rooms', 'roomTypes', 'floors', 'status', 'type', 'floor', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roomTypes = RoomType::all();
        $floors = Room::select('floor')->distinct()->orderBy('floor')->pluck('floor')->toArray();

        return view('rooms.create', compact('roomTypes', 'floors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'description' => 'nullable|string',
            'price_adjustment' => 'nullable|numeric',
            'status' => 'required|in:available,occupied,reserved,cleaning,maintenance',
            'floor' => 'required|integer|min:1',
        ]);

        $room = Room::create($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Oda başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room): View
    {
        $room->load(['roomType', 'reservations' => function ($query) {
            $query->where('status', '!=', 'cancelled')
                  ->orderByDesc('created_at');
        }, 'reservations.customer', 'cleaningTasks' => function ($query) {
            $query->orderByDesc('scheduled_at');
        }]);

        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room): View
    {
        $roomTypes = RoomType::all();
        $floors = Room::select('floor')->distinct()->orderBy('floor')->pluck('floor')->toArray();

        return view('rooms.edit', compact('room', 'roomTypes', 'floors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'description' => 'nullable|string',
            'price_adjustment' => 'nullable|numeric',
            'status' => 'required|in:available,occupied,reserved,cleaning,maintenance',
            'floor' => 'required|integer|min:1',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Oda bilgileri başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): RedirectResponse
    {
        // Rezervasyon veya temizlik görevi olan odalar silinemez
        if ($room->reservations()->where('status', '!=', 'cancelled')->exists()) {
            return back()->withErrors(['error' => 'Bu odaya ait aktif rezervasyonlar bulunduğu için silinemez.']);
        }

        if ($room->cleaningTasks()->where('status', '!=', 'cancelled')->exists()) {
            return back()->withErrors(['error' => 'Bu odaya ait aktif temizlik görevleri bulunduğu için silinemez.']);
        }

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Oda başarıyla silindi.');
    }

    /**
     * Odanın durumunu güncelle
     */
    public function updateStatus(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:available,occupied,reserved,cleaning,maintenance',
        ]);

        $room->updateStatus($validated['status']);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Oda durumu başarıyla güncellendi.');
    }

    /**
     * Oda doluluk takvimini göster
     */
    public function calendar(): View
    {
        // Admin ve resepsiyonist için yetkilendirme kontrolü
        if (!auth()->user()->isAdmin() && !auth()->user()->isReceptionist()) {
            abort(403, 'Bu sayfaya erişim yetkiniz bulunmamaktadır.');
        }
        
        $rooms = Room::with('roomType')->orderBy('room_number')->get();

        return view('rooms.calendar', compact('rooms'));
    }

    /**
     * Oda doluluk takvimi için rezervasyon verilerini getir (AJAX)
     */
    public function calendarData()
    {
        $reservations = \App\Models\Reservation::with(['room', 'customer'])
            ->where('status', '!=', 'cancelled')
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->room->room_number . ' - ' . $reservation->customer->full_name,
                    'start' => $reservation->check_in->format('Y-m-d'),
                    'end' => $reservation->check_out->format('Y-m-d'),
                    'resourceId' => $reservation->room_id,
                    'url' => route('reservations.show', $reservation),
                    'color' => $this->getStatusColor($reservation->status),
                ];
            });

        return response()->json($reservations);
    }

    /**
     * Rezervasyon durumuna göre renk kodu döndür
     */
    private function getStatusColor(string $status): string
    {
        return match($status) {
            'pending' => '#FFA500', // Turuncu
            'confirmed' => '#3788D8', // Mavi
            'checked_in' => '#28A745', // Yeşil
            'checked_out' => '#6C757D', // Gri
            default => '#3788D8', // Varsayılan mavi
        };
    }
}
