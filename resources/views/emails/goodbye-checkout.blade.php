<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görüşmek Üzere - {{ $hotelSettings->hotel_name ?? config('app.name') }}</title>
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
            background: linear-gradient(135deg, #FF6B6B 0%, #ee5a5a 100%);
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
        .goodbye-message {
            text-align: center;
            margin: 30px 0;
        }
        .guest-name {
            font-size: 24px;
            color: #FF6B6B;
            font-weight: 600;
            margin: 0 0 15px;
        }
        .goodbye-text {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
        .stay-summary {
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
        .feedback-section {
            background: linear-gradient(135deg, #FFA726 0%, #FF9800 100%);
            color: white;
            padding: 30px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: center;
        }
        .feedback-title {
            margin: 0 0 15px;
            font-size: 18px;
            font-weight: 600;
        }
        .feedback-text {
            margin: 0 0 25px;
            opacity: 0.9;
            line-height: 1.5;
        }
        .review-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .review-link {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .review-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }
        .review-link img {
            width: 20px;
            height: 20px;
            border-radius: 3px;
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
        .return-invitation {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: center;
        }
        .return-title {
            font-size: 18px;
            font-weight: 600;
            color: #495057;
            margin: 0 0 15px;
        }
        .return-text {
            color: #666;
            line-height: 1.6;
            margin: 0 0 20px;
        }
        .contact-info {
            background-color: #f1f3f4;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
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
            .header, .content, .feedback-section, .social-section, .return-invitation, .footer {
                padding: 20px;
            }
            .social-links, .review-links {
                gap: 10px;
            }
            .social-link {
                width: 45px;
                height: 45px;
            }
            .review-link {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🙏 Görüşmek Üzere!</h1>
            <p class="hotel-name">{{ $hotelSettings->hotel_name ?? config('app.name') }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Goodbye Message -->
            <div class="goodbye-message">
                <h2 class="guest-name">Sayın {{ $customerName }}</h2>
                <p class="goodbye-text">
                    {{ $hotelSettings->goodbye_description ?? 'Otelimiizden ayrıldığınız için teşekkürler. Tekrar görüşmek üzere!' }}
                </p>
            </div>

            <!-- Stay Summary -->
            <div class="stay-summary">
                <h3 style="margin: 0 0 20px; color: #495057; text-align: center;">📊 Konaklama Özetiniz</h3>

                <div class="detail-row">
                    <span class="detail-label">🛏️ Oda Numarası:</span>
                    <span class="detail-value">{{ $reservation->room->room_number ?? '-' }}</span>
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

            <!-- Feedback Section -->
            @if(isset($emailTemplateSettings) && $emailTemplateSettings)
            @php
                $allLinks = $emailTemplateSettings->getGoodbyeLinks();
                $reviewLinks = collect($allLinks)->filter(function($link, $key) {
                    return str_contains($key, 'review');
                });
            @endphp
            @if($reviewLinks->isNotEmpty())
            <div class="feedback-section">
                <h3 class="feedback-title">⭐ Deneyiminizi Paylaşın</h3>
                <p class="feedback-text">
                    Konaklama deneyiminiz hakkındaki görüşleriniz bizim için çok değerli.
                    Lütfen birkaç dakikanızı ayırarak görüşlerinizi paylaşın!
                </p>

                <div class="review-links">
                    @foreach($reviewLinks as $key => $link)
                    <a href="{{ $link['url'] }}" class="review-link" target="_blank">
                        <img src="{{ $link['icon'] }}" alt="{{ $link['name'] }}">
                        <span>{{ $link['name'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @endif

            <!-- Social Media Section -->
            @if(isset($emailTemplateSettings) && $emailTemplateSettings)
            @php
                $socialLinks = collect($allLinks)->filter(function($link, $key) {
                    return !str_contains($key, 'review');
                });
            @endphp
            @if($socialLinks->isNotEmpty())
            <div class="social-section">
                <h3 class="social-title">🔗 Bizi Takip Etmeyi Unutmayın</h3>
                <p style="margin: 0 0 25px; opacity: 0.9;">Özel fırsatlardan ve yeniliklerden haberdar olun!</p>

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

            <!-- Return Invitation -->
            <div class="return-invitation">
                <h3 class="return-title">🏨 Tekrar Bekleriz</h3>
                <p class="return-text">
                    Sizleri tekrar ağırlamaktan büyük mutluluk duyarız. Bir sonraki seyahatinizde
                    de bizi tercih ettiğiniz için şimdiden teşekkür ederiz.
                </p>

                <div class="contact-info">
                    <h4 class="contact-title">📞 Rezervasyon İçin İletişim</h4>

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

                    @if($hotelSettings && $hotelSettings->hotel_website)
                    <div class="contact-item">
                        <span class="contact-icon">🌐</span>
                        <a href="{{ $hotelSettings->hotel_website }}" style="color: #666; text-decoration: none;">{{ $hotelSettings->hotel_website }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="color: #666; font-style: italic;">
                    Güvenli yolculuklar diler, bir sonraki görüşmemizi sabırsızlıkla bekleriz. 🛫
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
