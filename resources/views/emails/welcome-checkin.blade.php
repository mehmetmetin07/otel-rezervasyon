<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoş Geldiniz - {{ $hotelSettings->hotel_name ?? config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px;
            font-size: 28px;
            font-weight: 300;
        }
        .header .hotel-name {
            font-size: 18px;
            opacity: 0.9;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-message {
            text-align: center;
            margin: 30px 0;
        }
        .guest-name {
            font-size: 24px;
            color: #4CAF50;
            font-weight: 600;
            margin: 0 0 15px;
        }
        .welcome-text {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
        .reservation-details {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #333;
        }
        .social-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: center;
        }
        .social-title {
            margin: 0 0 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .social-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .social-link {
            display: inline-block;
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .social-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px) scale(1.05);
        }
        .social-link img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .contact-title {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            margin: 0 0 15px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin: 8px 0;
            color: #666;
        }
        .contact-icon {
            margin-right: 10px;
            font-size: 18px;
        }
        .footer {
            background-color: #495057;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .footer-text {
            margin: 0;
            font-size: 14px;
            opacity: 0.8;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }
            .header, .content, .social-section, .contact-info, .footer {
                padding: 20px;
            }
            .social-links {
                gap: 10px;
            }
            .social-link {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏨 Hoş Geldiniz!</h1>
            <p class="hotel-name">{{ $hotelSettings->hotel_name ?? config('app.name') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <h2 class="guest-name">Sayın {{ $customerName }}</h2>
                <p class="welcome-text">
                    {{ $hotelSettings->welcome_description ?? 'Otelimiize hoş geldiniz! Konforlu konaklamanız için buradayız.' }}
                </p>
            </div>

            <!-- Reservation Details -->
            <div class="reservation-details">
                <h3 style="margin: 0 0 20px; color: #495057; text-align: center;">📋 Rezervasyon Bilgileriniz</h3>

                <div class="detail-row">
                    <span class="detail-label">🛏️ Oda Numarası:</span>
                    <span class="detail-value">{{ $reservation->room->room_number ?? 'Atanacak' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">📅 Giriş Tarihi:</span>
                    <span class="detail-value">{{ $reservation->check_in_date->format('d.m.Y') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">📅 Çıkış Tarihi:</span>
                    <span class="detail-value">{{ $reservation->check_out_date->format('d.m.Y') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">🌙 Toplam Gece:</span>
                    <span class="detail-value">{{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">👥 Kişi Sayısı:</span>
                    <span class="detail-value">{{ $reservation->num_of_guests }}</span>
                </div>
            </div>

            <!-- Social Media Section -->
            @if(isset($emailTemplateSettings) && $emailTemplateSettings)
            @php
                $socialLinks = $emailTemplateSettings->getWelcomeSocialLinks();
            @endphp
            @if(!empty($socialLinks))
            <div class="social-section">
                <h3 class="social-title">🔗 Bizi Sosyal Medyada Takip Edin</h3>
                <p style="margin: 0 0 25px; opacity: 0.9;">Güncel haberler ve özel fırsatlar için bizi takip etmeyi unutmayın!</p>

                <div class="social-links">
                    @foreach($socialLinks as $key => $link)
                    <a href="{{ $link['url'] }}" class="social-link" title="{{ $link['name'] }}" target="_blank">
                        <img src="{{ $link['icon'] }}" alt="{{ $link['name'] }}">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Contact Information -->
            <div class="contact-info">
                <h3 class="contact-title">📞 İletişim Bilgileri</h3>

                @if($hotelSettings && $hotelSettings->phone)
                <div class="contact-item">
                    <span class="contact-icon">📱</span>
                    <span>{{ $hotelSettings->phone }}</span>
                </div>
                @endif

                @if($hotelSettings && $hotelSettings->email)
                <div class="contact-item">
                    <span class="contact-icon">📧</span>
                    <span>{{ $hotelSettings->email }}</span>
                </div>
                @endif

                @if($hotelSettings && $hotelSettings->address)
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <span>{{ $hotelSettings->address }}</span>
                </div>
                @endif

                <div class="contact-item">
                    <span class="contact-icon">🕐</span>
                    <span>7/24 Resepsiyon Hizmeti</span>
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="color: #666; font-style: italic;">
                    Konaklamanızın keyifli geçmesi en büyük dileğimizdir. Herhangi bir ihtiyacınız olduğunda bizimle iletişime geçmekten çekinmeyin.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                © {{ date('Y') }} {{ $hotelSettings->hotel_name ?? config('app.name') }}<br>
                Bu e-posta otomatik olarak gönderilmiştir.
            </p>
        </div>
    </div>
</body>
</html>
