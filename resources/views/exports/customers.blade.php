<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Adı</th>
            <th>Soyadı</th>
            <th>Kimlik No</th>
            <th>E-posta</th>
            <th>Telefon</th>
            <th>Adres</th>
            <th>Ülke</th>
            <th>Şehir</th>
            <th>Kayıt Tarihi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->id }}</td>
                <td>{{ $customer->first_name }}</td>
                <td>{{ $customer->last_name }}</td>
                <td>{{ $customer->id_number }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->country }}</td>
                <td>{{ $customer->city }}</td>
                <td>{{ $customer->created_at->format('d.m.Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
