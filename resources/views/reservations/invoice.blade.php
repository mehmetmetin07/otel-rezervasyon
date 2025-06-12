<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #3b82f6;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details .left, .invoice-details .right {
            width: 48%;
        }
        .invoice-details h3 {
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #3b82f6;
            font-size: 16px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-items th, .invoice-items td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .invoice-items th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #3b82f6;
        }
        .invoice-items tr:last-child td {
            border-bottom: none;
        }
        .invoice-total {
            text-align: right;
            margin-top: 20px;
        }
        .invoice-total table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .invoice-total table th, .invoice-total table td {
            padding: 8px;
            text-align: right;
            border-bottom: 1px solid #eee;
        }
        .invoice-total table tr:last-child th, .invoice-total table tr:last-child td {
            border-bottom: none;
            font-weight: bold;
            font-size: 14px;
            color: #3b82f6;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 2px solid #f0f0f0;
            padding-top: 15px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #047857;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .badge-info {
            background-color: #e0f2fe;
            color: #0369a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Otel Rezervasyon Sistemi</h1>
            <p>Fatura #{{ $reservation->id }}</p>
            <p>Tarih: {{ now()->format('d.m.Y') }}</p>
        </div>

        <div class="invoice-details">
            <div class="left">
                <h3>Müşteri Bilgileri</h3>
                <p><strong>Ad Soyad:</strong> {{ $reservation->customer->full_name }}</p>
                <p><strong>TC/Pasaport No:</strong> {{ $reservation->customer->id_number }}</p>
                <p><strong>Telefon:</strong> {{ $reservation->customer->phone }}</p>
                <p><strong>E-posta:</strong> {{ $reservation->customer->email ?? 'Belirtilmemiş' }}</p>
                @if($reservation->customer->address)
                <p><strong>Adres:</strong> {{ $reservation->customer->address }}</p>
                @endif
            </div>
            <div class="right">
                <h3>Rezervasyon Detayları</h3>
                <p><strong>Rezervasyon No:</strong> #{{ $reservation->id }}</p>
                <p><strong>Durum:</strong> 
                    @if($reservation->status == 'pending')
                        <span class="badge badge-warning">Onay Bekliyor</span>
                    @elseif($reservation->status == 'confirmed')
                        <span class="badge badge-info">Onaylandı</span>
                    @elseif($reservation->status == 'checked_in')
                        <span class="badge badge-success">Check-in Yapıldı</span>
                    @elseif($reservation->status == 'checked_out')
                        <span class="badge badge-success">Check-out Yapıldı</span>
                    @elseif($reservation->status == 'cancelled')
                        <span class="badge badge-danger">İptal Edildi</span>
                    @endif
                </p>
                <p><strong>Giriş Tarihi:</strong> {{ $reservation->check_in->format('d.m.Y') }}</p>
                <p><strong>Çıkış Tarihi:</strong> {{ $reservation->check_out->format('d.m.Y') }}</p>
                <p><strong>Konaklama Süresi:</strong> {{ $reservation->check_in->diffInDays($reservation->check_out) }} gece</p>
                <p><strong>Kişi Sayısı:</strong> {{ $reservation->adults }} yetişkin, {{ $reservation->children }} çocuk</p>
            </div>
        </div>

        <table class="invoice-items">
            <thead>
                <tr>
                    <th>Açıklama</th>
                    <th>Miktar</th>
                    <th>Birim Fiyat</th>
                    <th>Tutar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $reservation->room->roomType->name }} - Oda No: {{ $reservation->room->room_number }}</td>
                    <td>{{ $reservation->check_in->diffInDays($reservation->check_out) }} gece</td>
                    <td>{{ number_format($reservation->room->roomType->base_price, 2) }} TL</td>
                    <td>{{ number_format($reservation->room->roomType->base_price * $reservation->check_in->diffInDays($reservation->check_out), 2) }} TL</td>
                </tr>
                
                @php
                    $totalExtras = 0;
                @endphp
                
                @if($reservation->minibarConsumptions->count() > 0)
                    @foreach($reservation->minibarConsumptions as $consumption)
                        <tr>
                            <td>Minibar - {{ $consumption->product_name }}</td>
                            <td>{{ $consumption->quantity }}</td>
                            <td>{{ number_format($consumption->price, 2) }} TL</td>
                            <td>{{ number_format($consumption->quantity * $consumption->price, 2) }} TL</td>
                        </tr>
                        @php
                            $totalExtras += $consumption->quantity * $consumption->price;
                        @endphp
                    @endforeach
                @endif
                
                @if($reservation->laundryServices->count() > 0)
                    @foreach($reservation->laundryServices as $service)
                        <tr>
                            <td>Çamaşırhane - {{ $service->service_name }}</td>
                            <td>{{ $service->quantity }}</td>
                            <td>{{ number_format($service->price, 2) }} TL</td>
                            <td>{{ number_format($service->quantity * $service->price, 2) }} TL</td>
                        </tr>
                        @php
                            $totalExtras += $service->quantity * $service->price;
                        @endphp
                    @endforeach
                @endif
                
                @if($reservation->orders->count() > 0)
                    @foreach($reservation->orders as $order)
                        <tr>
                            <td>Oda Servisi - {{ $order->order_details }}</td>
                            <td>1</td>
                            <td>{{ number_format($order->total_amount, 2) }} TL</td>
                            <td>{{ number_format($order->total_amount, 2) }} TL</td>
                        </tr>
                        @php
                            $totalExtras += $order->total_amount;
                        @endphp
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="invoice-total">
            <table>
                <tr>
                    <th>Konaklama Tutarı:</th>
                    <td>{{ number_format($reservation->room->roomType->base_price * $reservation->check_in->diffInDays($reservation->check_out), 2) }} TL</td>
                </tr>
                <tr>
                    <th>Ekstra Hizmetler:</th>
                    <td>{{ number_format($totalExtras, 2) }} TL</td>
                </tr>
                <!-- KDV satırı kaldırıldı -->
                <tr>
                    <th>Toplam Tutar:</th>
                    <td>{{ number_format(($reservation->room->roomType->base_price * $reservation->check_in->diffInDays($reservation->check_out) + $totalExtras), 2) }} TL</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Bu fatura elektronik olarak oluşturulmuştur.</p>
            <p>Otel Rezervasyon Sistemi &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
