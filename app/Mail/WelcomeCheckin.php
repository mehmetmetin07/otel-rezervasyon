<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\HotelSetting;
use App\Models\EmailTemplateSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeCheckin extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $customerName;
    public $hotelSettings;
    public $emailTemplateSettings;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->customerName = $reservation->customer->name;
        $this->hotelSettings = HotelSetting::getOrCreateDefault();
        $this->emailTemplateSettings = EmailTemplateSetting::getOrCreateDefault();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $hotelName = $this->hotelSettings->hotel_name ?? config('app.name');

        return new Envelope(
            subject: "🏨 Hoş Geldiniz - {$hotelName}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-checkin',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
