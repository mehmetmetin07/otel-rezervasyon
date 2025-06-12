<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Müşteri</th>
            <th>Oda</th>
            <th>Giriş Tarihi</th>
            <th>Çıkış Tarihi</th>
            <th>Kişi Sayısı</th>
            <th>Durum</th>
            <th>Toplam Fiyat</th>
            <th>Oluşturulma Tarihi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}</td>
                <td>{{ $reservation->room->room_number }} ({{ $reservation->room->roomType->name }})</td>
                <td>{{ $reservation->check_in_date->format('d.m.Y') }}</td>
                <td>{{ $reservation->check_out_date->format('d.m.Y') }}</td>
                <td>{{ $reservation->number_of_guests }}</td>
                <td>{{ $reservation->status }}</td>
                <td>{{ number_format($reservation->total_price, 2) }}</td>
                <td>{{ $reservation->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
