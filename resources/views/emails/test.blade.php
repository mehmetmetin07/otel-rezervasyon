<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test E-postası - {{ $hotelSettings->hotel_name ?? config('app.name') }}</title>
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
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .success-icon {
            color: #28a745;
            text-align: center;
            margin: 0 auto 20px;
            font-size: 48px;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-muted {
            color: #6c757d;
            font-size: 14px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .social-links {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        .social-link {
            display: inline-block;
            margin: 0 5px;
            padding: 8px;
            text-decoration: none;
            border-radius: 50%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .social-link:hover {
            transform: translateY(-2px);
        }
        .social-link img {
            width: 24px;
            height: 24px;
            display: block;
        }
        .personalized-greeting {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Test E-postası Başarılı!</h1>
            <p style="margin: 10px 0 0;">{{ $hotelSettings->hotel_name ?? config('app.name') }}</p>
        </div>

        <div class="content">
            <div class="text-center">
                <div class="success-icon">
                    ✓
                </div>

                @if(isset($customerName))
                <div class="personalized-greeting">
                    <h2 style="margin: 0 0 10px;">Sayın {{ $customerName }}</h2>
                    <p style="margin: 0;">{{ $hotelSettings->welcome_description ?? 'Otelimiize hoş geldiniz! Konforlu konaklamanız için buradayız.' }}</p>
                </div>
                @endif

                <h2>Tebrikler!</h2>
                <p>SMTP ayarlarınız doğru şekilde yapılandırılmış ve çalışıyor.</p>
                <p class="text-muted">Bu e-posta, otel rezervasyon sisteminizin mail gönderme özelliğinin test edilmesi için gönderilmiştir.</p>
            </div>

            <hr style="margin: 30px 0; border: none; border-top: 1px solid #dee2e6;">

            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h4 style="margin-top: 0; color: #495057;">📧 Test Detayları</h4>
                <ul style="color: #6c757d; margin: 0; padding-left: 20px;">
                    <li>Gönderilme Zamanı: {{ now()->format('d.m.Y H:i:s') }}</li>
                    <li>Sistem: {{ $hotelSettings->hotel_name ?? 'Otel Rezervasyon Sistemi' }}</li>
                    <li>Durum: Mail ayarları başarıyla çalışıyor</li>
                    @if($hotelSettings && $hotelSettings->email)
                    <li>İletişim: {{ $hotelSettings->email }}</li>
                    @endif
                </ul>
            </div>

            @if(isset($emailTemplateSettings) && $emailTemplateSettings)
            @php
                $socialLinks = $emailTemplateSettings->getWelcomeSocialLinks();
            @endphp
            @if(!empty($socialLinks))
            <div class="social-links">
                <h4 style="margin-top: 0; color: #495057;">🔗 Bizi Takip Edin</h4>
                <div>
                    @foreach($socialLinks as $key => $link)
                    <a href="{{ $link['url'] }}" class="social-link" title="{{ $link['name'] }}" target="_blank">
                        <img src="{{ $link['icon'] }}" alt="{{ $link['name'] }}">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @endif
        </div>

        <div class="footer">
            <p class="text-muted">
                Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayın.<br>
                <strong>{{ $hotelSettings->hotel_name ?? 'Otel Rezervasyon Sistemi' }}</strong>
                @if($hotelSettings && $hotelSettings->address)
                <br><small>{{ $hotelSettings->address }}</small>
                @endif
            </p>
        </div>
    </div>
</body>
</html>
