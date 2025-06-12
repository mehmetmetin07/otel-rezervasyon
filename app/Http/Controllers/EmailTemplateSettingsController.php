<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplateSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class EmailTemplateSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = EmailTemplateSetting::getOrCreateDefault();
        return view('email-template-settings.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'tripadvisor_url' => 'nullable|url|max:255',
            'booking_url' => 'nullable|url|max:255',
            'show_facebook' => 'boolean',
            'show_instagram' => 'boolean',
            'show_twitter' => 'boolean',
            'show_linkedin' => 'boolean',
            'show_youtube' => 'boolean',
            'show_website' => 'boolean',
            'show_tripadvisor' => 'boolean',
            'show_booking' => 'boolean',
        ]);

        // Mevcut aktif ayarları pasif yap
        EmailTemplateSetting::where('is_active', true)->update(['is_active' => false]);

        // Form field'larını model field'larına map et
        $mappedData = [
            'facebook_url' => $request->facebook_url,
            'instagram_url' => $request->instagram_url,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'youtube_url' => $request->youtube_url,
            'hotel_website_url' => $request->website_url,
            'review_site_1_url' => $request->tripadvisor_url,
            'review_site_1_name' => $request->tripadvisor_url ? 'TripAdvisor' : null,
            'review_site_2_url' => $request->booking_url,
            'review_site_2_name' => $request->booking_url ? 'Booking.com' : null,

            // Welcome email visibility (sadece sosyal medya)
            'show_facebook_welcome' => $request->has('show_facebook'),
            'show_instagram_welcome' => $request->has('show_instagram'),
            'show_twitter_welcome' => $request->has('show_twitter'),
            'show_linkedin_welcome' => $request->has('show_linkedin'),
            'show_youtube_welcome' => $request->has('show_youtube'),
            'show_website_welcome' => $request->has('show_website'),

            // Goodbye email visibility (hem sosyal medya hem review)
            'show_facebook_goodbye' => $request->has('show_facebook'),
            'show_instagram_goodbye' => $request->has('show_instagram'),
            'show_twitter_goodbye' => $request->has('show_twitter'),
            'show_linkedin_goodbye' => $request->has('show_linkedin'),
            'show_youtube_goodbye' => $request->has('show_youtube'),
            'show_website_goodbye' => $request->has('show_website'),
            'show_review_site_1_goodbye' => $request->has('show_tripadvisor'),
            'show_review_site_2_goodbye' => $request->has('show_booking'),

            'is_active' => true
        ];

        // Yeni ayarları oluştur
        $settings = EmailTemplateSetting::create($mappedData);

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = Auth::id();
            $log->action = 'Email Template Ayarları Güncellendi';
            $log->model_type = 'EmailTemplateSetting';
            $log->model_id = $settings->id;
            $log->description = 'Email template ayarları güncellendi';
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        return redirect()->back()->with('success', 'Email template ayarları başarıyla güncellendi!');
    }
}
