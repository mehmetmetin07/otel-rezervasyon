<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\ActivityLog;
use App\Models\MailSetting;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

        /**
     * SMTP ayarlarını güncelle
     */
    public function updateSmtp(Request $request): RedirectResponse
    {
        $request->validate([
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl,',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        // Mevcut aktif ayarları pasif yap
        MailSetting::where('is_active', true)->update(['is_active' => false]);

        // Yeni mail ayarlarını veritabanına kaydet
        $mailSetting = MailSetting::create([
            'mail_mailer' => 'smtp',
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
            'is_active' => true,
        ]);

        // Yeni ayarları config'e uygula
        $mailSetting->applyToConfig();

        // Aktivite logu oluştur
        try {
            $log = new \App\Models\ActivityLog();
            $log->user_id = auth()->id();
            $log->action = 'SMTP Ayarları Güncellendi';
            $log->model_type = 'MailSetting';
            $log->model_id = $mailSetting->id;
            $log->description = 'SMTP mail ayarları veritabanında güncellendi';
            $log->ip_address = $request->ip();
            $log->user_agent = $request->userAgent();
            $log->save();
        } catch (\Exception $e) {
            // Log kaydı oluşturulurken hata oluştu
            report($e);
        }

        return Redirect::route('profile.edit')->with('status', 'smtp-updated');
    }

        /**
     * Test e-postası gönder
     */
    public function sendTestEmail(Request $request)
    {
        try {
            $request->validate([
                'test_email' => 'required|email',
                'customer_name' => 'nullable|string|max:255',
            ]);

            // Aktif mail ayarlarını yükle
            MailSetting::loadConfig();

            // Test e-postası gönder (kişi adıyla birlikte)
            $customerName = $request->customer_name ?: 'Test Kullanıcısı';
            Mail::to($request->test_email)->send(new TestMail($customerName));

            // Aktivite logu oluştur
            try {
                $log = new \App\Models\ActivityLog();
                $log->user_id = auth()->id();
                $log->action = 'Test E-postası Gönderildi';
                $log->model_type = 'Mail';
                $log->model_id = 0;
                $log->description = 'Test e-postası gönderildi: ' . $request->test_email . ' (Kişi: ' . $customerName . ')';
                $log->ip_address = $request->ip();
                $log->user_agent = $request->userAgent();
                $log->save();
            } catch (\Exception $e) {
                report($e);
            }

                        return response()->json([
                'success' => true,
                'message' => 'Test e-postası başarıyla gönderildi!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation hatası: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'E-posta gönderilemedi: ' . $e->getMessage()
            ], 500);
        }
    }


}
