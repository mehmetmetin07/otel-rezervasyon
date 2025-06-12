<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'hotel_website_url',
        'review_site_1_url',
        'review_site_1_name',
        'review_site_2_url',
        'review_site_2_name',
        'show_facebook_welcome',
        'show_instagram_welcome',
        'show_twitter_welcome',
        'show_linkedin_welcome',
        'show_youtube_welcome',
        'show_website_welcome',
        'show_facebook_goodbye',
        'show_instagram_goodbye',
        'show_twitter_goodbye',
        'show_linkedin_goodbye',
        'show_youtube_goodbye',
        'show_website_goodbye',
        'show_review_site_1_goodbye',
        'show_review_site_2_goodbye',
        'is_active'
    ];

    protected $casts = [
        'show_facebook_welcome' => 'boolean',
        'show_instagram_welcome' => 'boolean',
        'show_twitter_welcome' => 'boolean',
        'show_linkedin_welcome' => 'boolean',
        'show_youtube_welcome' => 'boolean',
        'show_website_welcome' => 'boolean',
        'show_facebook_goodbye' => 'boolean',
        'show_instagram_goodbye' => 'boolean',
        'show_twitter_goodbye' => 'boolean',
        'show_linkedin_goodbye' => 'boolean',
        'show_youtube_goodbye' => 'boolean',
        'show_website_goodbye' => 'boolean',
        'show_review_site_1_goodbye' => 'boolean',
        'show_review_site_2_goodbye' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Aktif email template ayarlarını getir
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Varsayılan email template ayarlarını getir veya oluştur
     */
    public static function getOrCreateDefault()
    {
        $setting = static::getActive();

        if (!$setting) {
            $setting = static::create([
                'is_active' => true
            ]);
        }

        return $setting;
    }

    /**
     * Sosyal medya linklerini hoşgeldin için getir
     */
    public function getWelcomeSocialLinks()
    {
        $links = [];

        if ($this->show_facebook_welcome && $this->facebook_url) {
            $links['facebook'] = [
                'url' => $this->facebook_url,
                'name' => 'Facebook',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124010.png'
            ];
        }

        if ($this->show_instagram_welcome && $this->instagram_url) {
            $links['instagram'] = [
                'url' => $this->instagram_url,
                'name' => 'Instagram',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124021.png'
            ];
        }

        if ($this->show_twitter_welcome && $this->twitter_url) {
            $links['twitter'] = [
                'url' => $this->twitter_url,
                'name' => 'Twitter',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124021.png'
            ];
        }

        if ($this->show_linkedin_welcome && $this->linkedin_url) {
            $links['linkedin'] = [
                'url' => $this->linkedin_url,
                'name' => 'LinkedIn',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124011.png'
            ];
        }

        if ($this->show_youtube_welcome && $this->youtube_url) {
            $links['youtube'] = [
                'url' => $this->youtube_url,
                'name' => 'YouTube',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124085.png'
            ];
        }

        if ($this->show_website_welcome && $this->hotel_website_url) {
            $links['website'] = [
                'url' => $this->hotel_website_url,
                'name' => 'Web Sitemiz',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/1006/1006771.png'
            ];
        }

        return $links;
    }

    /**
     * Hoşçakal için tüm linkleri getir (sosyal medya + yorum siteleri)
     */
    public function getGoodbyeLinks()
    {
        $links = [];

        // Sosyal medya linkleri
        if ($this->show_facebook_goodbye && $this->facebook_url) {
            $links['facebook'] = [
                'url' => $this->facebook_url,
                'name' => 'Facebook',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124010.png'
            ];
        }

        if ($this->show_instagram_goodbye && $this->instagram_url) {
            $links['instagram'] = [
                'url' => $this->instagram_url,
                'name' => 'Instagram',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124021.png'
            ];
        }

        if ($this->show_twitter_goodbye && $this->twitter_url) {
            $links['twitter'] = [
                'url' => $this->twitter_url,
                'name' => 'Twitter',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124021.png'
            ];
        }

        if ($this->show_linkedin_goodbye && $this->linkedin_url) {
            $links['linkedin'] = [
                'url' => $this->linkedin_url,
                'name' => 'LinkedIn',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124011.png'
            ];
        }

        if ($this->show_youtube_goodbye && $this->youtube_url) {
            $links['youtube'] = [
                'url' => $this->youtube_url,
                'name' => 'YouTube',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/124/124085.png'
            ];
        }

        if ($this->show_website_goodbye && $this->hotel_website_url) {
            $links['website'] = [
                'url' => $this->hotel_website_url,
                'name' => 'Web Sitemiz',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/1006/1006771.png'
            ];
        }

        // Yorum siteleri
        if ($this->show_review_site_1_goodbye && $this->review_site_1_url) {
            $links['review_1'] = [
                'url' => $this->review_site_1_url,
                'name' => $this->review_site_1_name ?: 'Yorum Sitesi',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/1828/1828884.png'
            ];
        }

        if ($this->show_review_site_2_goodbye && $this->review_site_2_url) {
            $links['review_2'] = [
                'url' => $this->review_site_2_url,
                'name' => $this->review_site_2_name ?: 'Yorum Sitesi',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/1828/1828884.png'
            ];
        }

        return $links;
    }
}
