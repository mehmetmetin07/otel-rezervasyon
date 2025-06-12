<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\Customer;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $export = $request->get('export');
        
        $query = Customer::query();
        
        if ($search) {
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
        }
        
        // CSV dışa aktarma
        if ($export === 'excel') {
            // Filtrelenmiş verileri al
            $customersData = $query->get();
            
            // CSV başlıkları
            $headers = [
                'ID',
                'Adı',
                'Soyadı',
                'E-posta',
                'Telefon',
                'Kimlik No',
                'Adres',
                'Doğum Tarihi',
                'Notlar',
                'Oluşturulma Tarihi'
            ];
            
            // CSV içeriğini oluştur
            $callback = function() use ($customersData, $headers) {
                $file = fopen('php://output', 'w');
                
                // UTF-8 BOM ekle (Excel'de Türkçe karakterleri düzgün göstermek için)
                fputs($file, "\xEF\xBB\xBF");
                
                // Başlıkları yaz
                fputcsv($file, $headers);
                
                // Verileri yaz
                foreach ($customersData as $customer) {
                    fputcsv($file, [
                        $customer->id,
                        $customer->first_name,
                        $customer->last_name,
                        $customer->email,
                        $customer->phone,
                        $customer->id_number,
                        $customer->address,
                        $customer->birth_date ? date('d.m.Y', strtotime($customer->birth_date)) : '',
                        $customer->notes,
                        $customer->created_at->format('d.m.Y H:i')
                    ]);
                }
                
                fclose($file);
            };
            
            // CSV dosyasını indir
            $filename = 'musteriler_' . date('Y-m-d') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            return response()->stream($callback, 200, $headers);
        }
        
        $customers = $query->orderBy('last_name')->paginate(10);
        
        return view('customers.index', compact('customers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:20|unique:customers',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        Customer::create($validated);
        
        return redirect()->route('customers.index')
            ->with('success', 'Müşteri başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): View
    {
        $reservations = Reservation::where('customer_id', $customer->id)
            ->with(['room', 'room.roomType'])
            ->orderByDesc('created_at')
            ->get();
            
        return view('customers.show', compact('customer', 'reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'id_number' => 'required|string|max:20|unique:customers,id_number,' . $customer->id,
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        $customer->update($validated);
        
        return redirect()->route('customers.index')
            ->with('success', 'Müşteri bilgileri başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        // Müşterinin rezervasyonları var mı kontrol et
        $hasReservations = Reservation::where('customer_id', $customer->id)->exists();
        
        if ($hasReservations) {
            return back()->with('error', 'Bu müşteriye ait rezervasyonlar olduğu için silinemez.');
        }
        
        $customer->delete();
        
        return redirect()->route('customers.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }
}
