<?php

namespace App\Http\Controllers;

use App\Models\HotelSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class HotelSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = HotelSetting::getOrCreateDefault();
        return view('hotel-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'welcome_description' => 'nullable|string|max:1000',
            'goodbye_description' => 'nullable|string|max:1000',
            'hotel_website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'auto_send_welcome_email' => 'nullable|boolean',
            'auto_send_goodbye_email' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ], [
            'hotel_name.required' => 'Otel adı gereklidir.',
            'hotel_name.max' => 'Otel adı en fazla 255 karakter olabilir.',
            'hotel_website.url' => 'Otel web sitesi geçerli bir URL olmalıdır (örn: https://example.com).',
            'hotel_website.max' => 'Web site adresi en fazla 255 karakter olabilir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.max' => 'E-posta adresi en fazla 255 karakter olabilir.',
            'phone.max' => 'Telefon numarası en fazla 20 karakter olabilir.',
            'address.max' => 'Adres en fazla 500 karakter olabilir.',
            'welcome_description.max' => 'Hoş geldin mesajı en fazla 1000 karakter olabilir.',
            'goodbye_description.max' => 'Güle güle mesajı en fazla 1000 karakter olabilir.',
        ]);

        // Eğer website boşsa null yap
        if (empty($validatedData['hotel_website'])) {
            $validatedData['hotel_website'] = null;
        }

        // Mevcut aktif ayarları pasif yap
        HotelSetting::where('is_active', true)->update(['is_active' => false]);

        // Yeni ayarları oluştur
        $settings = HotelSetting::create(array_merge($validatedData, ['is_active' => true]));

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Hotel Ayarları Güncellendi';
            $log->model_type = 'HotelSetting';
            $log->model_id = $settings->id;
            $log->description = 'Hotel ayarları güncellendi';
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        return redirect()->back()->with('success', 'Hotel ayarları başarıyla güncellendi!');
    }
}
