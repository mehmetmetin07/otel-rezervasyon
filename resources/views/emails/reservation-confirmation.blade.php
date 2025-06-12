<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rezervasyon Onayı #{{ $reservation->id }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f7f7; color: #333333;">
  <table role="presentation" style="width: 100%; border-collapse: collapse;">
    <tr>
      <td style="padding: 20px 0;">
        <table role="presentation" style="width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
          <!-- Header -->
          <tr>
            <td style="padding: 30px 40px; border-bottom: 1px solid #eeeeee;">
              <table role="presentation" style="width: 100%; border-collapse: collapse;">
                <tr>
                  <td style="width: 50%;">
                    <h2 style="margin: 0; color: #4f46e5;">{{ config('app.name', 'Otel Rezervasyon') }}</h2>
                  </td>
                  <td style="width: 50%; text-align: right;">
                    <p style="margin: 0; font-size: 14px; color: #666666;">Rezervasyon #{{ $reservation->id }}</p>
                    <p style="margin: 5px 0 0; font-size: 14px; color: #666666;">{{ $reservation->created_at->format('d.m.Y') }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Confirmation Message -->
          <tr>
            <td style="padding: 40px 40px 30px;">
              <h1 style="margin: 0 0 20px; font-size: 24px; font-weight: 600; color: #333333;">Rezervasyonunuz Onaylandı!</h1>
              <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.5; color: #666666;">Sayın {{ $reservation->customer->name }},</p>
              <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.5; color: #666666;">Rezervasyonunuz başarıyla oluşturulmuştur. Rezervasyon detaylarınız aşağıda yer almaktadır.</p>
              <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 30px;">
                <tr>
                  <td style="padding: 0;">
                    <a href="{{ route('reservations.show', $reservation->id) }}" style="display: inline-block; background-color: #4CAF50; color: white; text-decoration: none; padding: 12px 30px; border-radius: 4px; font-weight: 600; font-size: 16px;">Rezervasyon Detaylarını Görüntüle</a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Reservation Summary -->
          <tr>
            <td style="padding: 0 40px 40px;">
              <h2 style="margin: 0 0 20px; font-size: 20px; color: #333333; padding-bottom: 10px; border-bottom: 1px solid #eeeeee;">Rezervasyon Özeti</h2>
              
              <!-- Room Details -->
              <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
                <tr>
                  <td style="width: 80px; padding: 0 15px 0 0;">
                    <div style="width: 80px; height: 80px; border-radius: 4px; border: 1px solid #eeeeee; background-color: #f9f9f9; display: flex; align-items: center; justify-content: center;">
                      <span style="font-size: 24px; color: #4f46e5;">{{ $reservation->room->number }}</span>
                    </div>
                  </td>
                  <td style="vertical-align: top; padding: 0;">
                    <h3 style="margin: 0 0 5px; font-size: 16px; font-weight: 600; color: #333333;">{{ $reservation->room->roomType->name }}</h3>
                    <p style="margin: 0 0 5px; font-size: 14px; color: #666666;">Oda Numarası: {{ $reservation->room->number }}</p>
                    <p style="margin: 0; font-size: 14px; color: #666666;">Kapasite: {{ $reservation->room->capacity }} Kişi</p>
                  </td>
                  <td style="vertical-align: top; text-align: right; padding: 0; width: 100px;">
                    <p style="margin: 0; font-size: 16px; font-weight: 600; color: #333333;">{{ number_format($reservation->total_price, 2) }} ₺</p>
                  </td>
                </tr>
              </table>
              
              <!-- Totals -->
              <table role="presentation" style="width: 100%; border-collapse: collapse; margin-top: 30px; border-top: 1px solid #eeeeee;">
                <tr>
                  <td style="padding: 15px 0 5px; text-align: right;">
                    <table role="presentation" style="width: 100%; max-width: 300px; margin-left: auto; border-collapse: collapse;">
                      <tr>
                        <td style="padding: 5px 0; font-size: 14px; color: #666666;">Giriş Tarihi:</td>
                        <td style="padding: 5px 0; font-size: 14px; color: #333333; text-align: right;">{{ $reservation->check_in_date->format('d.m.Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 5px 0; font-size: 14px; color: #666666;">Çıkış Tarihi:</td>
                        <td style="padding: 5px 0; font-size: 14px; color: #333333; text-align: right;">{{ $reservation->check_out_date->format('d.m.Y') }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 5px 0; font-size: 14px; color: #666666;">Toplam Gece:</td>
                        <td style="padding: 5px 0; font-size: 14px; color: #333333; text-align: right;">{{ $reservation->check_in_date->diffInDays($reservation->check_out_date) }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 5px 0; font-size: 14px; color: #666666;">Kişi Sayısı:</td>
                        <td style="padding: 5px 0; font-size: 14px; color: #333333; text-align: right;">{{ $reservation->num_of_guests }}</td>
                      </tr>
                      <tr>
                        <td style="padding: 15px 0 5px; font-size: 16px; font-weight: 600; color: #333333; border-top: 2px solid #eeeeee;">Toplam Tutar:</td>
                        <td style="padding: 15px 0 5px; font-size: 16px; font-weight: 600; color: #333333; text-align: right; border-top: 2px solid #eeeeee;">{{ number_format($reservation->total_price, 2) }} ₺</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Customer Information -->
          <tr>
            <td style="padding: 0 40px 40px;">
              <table role="presentation" style="width: 100%; border-collapse: collapse;">
                <tr>
                  <td style="width: 50%; vertical-align: top; padding: 0 10px 0 0;">
                    <h3 style="margin: 0 0 15px; font-size: 16px; color: #333333;">Müşteri Bilgileri</h3>
                    <p style="margin: 0 0 5px; font-size: 14px; line-height: 1.5; color: #666666;">{{ $reservation->customer->name }}</p>
                    <p style="margin: 0 0 5px; font-size: 14px; line-height: 1.5; color: #666666;">{{ $reservation->customer->email }}</p>
                    <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #666666;">{{ $reservation->customer->phone }}</p>
                  </td>
                  <td style="width: 50%; vertical-align: top; padding: 0 0 0 10px;">
                    <h3 style="margin: 0 0 15px; font-size: 16px; color: #333333;">Rezervasyon Durumu</h3>
                    <p style="margin: 0 0 5px; font-size: 14px; line-height: 1.5; color: #666666;">
                      <span style="display: inline-block; padding: 4px 8px; background-color: #4CAF50; color: white; border-radius: 4px; font-size: 12px;">{{ $reservation->status }}</span>
                    </p>
                    
                    <h3 style="margin: 25px 0 15px; font-size: 16px; color: #333333;">Ödeme Bilgisi</h3>
                    <p style="margin: 0 0 5px; font-size: 14px; line-height: 1.5; color: #666666;">Ödeme Durumu: {{ $reservation->payment_status ?? 'Bekliyor' }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          
          <!-- Hotel Info -->
          <tr>
            <td style="padding: 30px 40px; background-color: #f9f9f9; border-top: 1px solid #eeeeee;">
              <h3 style="margin: 0 0 15px; font-size: 16px; color: #333333;">Otel Bilgileri</h3>
              <p style="margin: 0 0 10px; font-size: 14px; line-height: 1.5; color: #666666;">Rezervasyonunuz ile ilgili sorularınız için lütfen bizimle iletişime geçin:</p>
              <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #666666;">
                <a href="mailto:{{ config('mail.from.address') }}" style="color: #4CAF50; text-decoration: none;">{{ config('mail.from.address') }}</a> | 
                <a href="tel:+905555555555" style="color: #4CAF50; text-decoration: none;">+90 555 555 55 55</a>
              </p>
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style="padding: 30px 40px; background-color: #333333; text-align: center;">
              <p style="margin: 0 0 15px; font-size: 14px; color: #ffffff;">© {{ date('Y') }} {{ config('app.name', 'Otel Rezervasyon') }}. Tüm hakları saklıdır.</p>
              <p style="margin: 0; font-size: 12px; color: #999999;">
                Bu e-posta, {{ config('app.name', 'Otel Rezervasyon') }} sisteminden otomatik olarak gönderilmiştir.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
