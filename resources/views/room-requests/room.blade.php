@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold d-flex align-items-center">
                <i class='bx bxs-hotel fs-1 me-2 text-primary'></i>
                Oda İstekleri
                <span class="badge bg-info text-dark ms-2 fs-6">{{ $room->room_number }}</span>
            </h1>
            <p class="text-muted">{{ $room->roomType->name }} odasına ait tüm istekleri görüntüleyin.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-secondary me-2">
                <i class='bx bx-arrow-back me-1'></i> Oda Detayına Dön
            </a>
            <a href="{{ route('room-requests.create', ['room_id' => $room->id]) }}" class="btn btn-primary">
                <i class='bx bx-plus-circle me-1'></i> Yeni İstek
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0 fw-bold"><i class='bx bx-list-ul me-2'></i>Tüm İstekler</h5>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-filter me-1'></i> Filtrele
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item" href="{{ route('rooms.requests', ['room' => $room->id, 'status' => 'pending']) }}">Bekleyen İstekler</a></li>
                                    <li><a class="dropdown-item" href="{{ route('rooms.requests', ['room' => $room->id, 'status' => 'in_progress']) }}">İşlemdeki İstekler</a></li>
                                    <li><a class="dropdown-item" href="{{ route('rooms.requests', ['room' => $room->id, 'status' => 'completed']) }}">Tamamlanan İstekler</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('rooms.requests', $room->id) }}">Tümünü Göster</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($roomRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-3">ID</th>
                                    <th scope="col">İstek</th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">Oluşturulma</th>
                                    <th scope="col" class="text-end pe-3">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomRequests as $request)
                                <tr>
                                    <td class="ps-3 fw-bold">#{{ $request->id }}</td>
                                    <td>
                                        <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $request->request_content }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($request->status == 'pending')
                                        <span class="badge bg-warning text-dark">Bekliyor</span>
                                        @elseif($request->status == 'in_progress')
                                        <span class="badge bg-info text-dark">İşlemde</span>
                                        @elseif($request->status == 'completed')
                                        <span class="badge bg-success">Tamamlandı</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group">
                                            <a href="{{ route('room-requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class='bx bx-show'></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='bx bx-revision'></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="dropdown-item status-update" data-status="pending" data-request-id="{{ $request->id }}">
                                                        <i class='bx bx-time me-1 text-warning'></i> Bekliyor
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item status-update" data-status="in_progress" data-request-id="{{ $request->id }}">
                                                        <i class='bx bx-loader-circle me-1 text-info'></i> İşlemde
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item status-update" data-status="completed" data-request-id="{{ $request->id }}">
                                                        <i class='bx bx-check-circle me-1 text-success'></i> Tamamlandı
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No Requests" style="width: 120px; height: 120px; opacity: 0.5;">
                        <h4 class="mt-3">Bu Odaya Ait İstek Bulunmuyor</h4>
                        <p class="text-muted">Bu oda için henüz istek oluşturulmamış.</p>
                        <a href="{{ route('room-requests.create', ['room_id' => $room->id]) }}" class="btn btn-primary mt-2">
                            <i class='bx bx-plus-circle me-1'></i> Yeni İstek Oluştur
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-info-circle me-2'></i>Oda Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class='bx bxs-door-open fs-1 me-3 text-primary'></i>
                        <div>
                            <h4 class="mb-0">{{ $room->room_number }}</h4>
                            <p class="mb-0 text-muted">{{ $room->roomType->name }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Durum:</span>
                            <span class="badge {{ $room->status == 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $room->status == 'available' ? 'Müsait' : $room->status }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kat:</span>
                            <span>{{ $room->floor ?? 'Belirtilmemiş' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Fiyat:</span>
                            <span>{{ number_format($room->roomType->base_price, 2) }} ₺</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-outline-primary">
                            <i class='bx bx-show me-1'></i> Oda Detaylarını Gör
                        </a>
                        <a href="{{ route('room-requests.create', ['room_id' => $room->id]) }}" class="btn btn-primary">
                            <i class='bx bx-plus-circle me-1'></i> Yeni İstek Oluştur
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-stats me-2'></i>İstek İstatistikleri</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="card bg-light border-0 h-100 text-center">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-center mb-2">
                                        <span class="badge bg-warning text-dark fs-6">{{ $roomRequests->where('status', 'pending')->count() }}</span>
                                    </div>
                                    <h6 class="card-title mb-0 small">Bekleyen</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-light border-0 h-100 text-center">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-center mb-2">
                                        <span class="badge bg-info text-dark fs-6">{{ $roomRequests->where('status', 'in_progress')->count() }}</span>
                                    </div>
                                    <h6 class="card-title mb-0 small">İşlemde</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-light border-0 h-100 text-center">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-center mb-2">
                                        <span class="badge bg-success fs-6">{{ $roomRequests->where('status', 'completed')->count() }}</span>
                                    </div>
                                    <h6 class="card-title mb-0 small">Tamamlanan</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Toplam İstek:</span>
                            <span class="fw-bold">{{ $roomRequests->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Son İstek:</span>
                            <span>{{ $roomRequests->count() > 0 ? $roomRequests->sortByDesc('created_at')->first()->created_at->format('d.m.Y') : 'Yok' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tamamlanma Oranı:</span>
                            <span>
                                @if($roomRequests->count() > 0)
                                    {{ round(($roomRequests->where('status', 'completed')->count() / $roomRequests->count()) * 100) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Durum güncelleme için AJAX
        const statusButtons = document.querySelectorAll('.status-update');
        
        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const status = this.dataset.status;
                const requestId = this.dataset.requestId;
                
                // CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // AJAX isteği
                fetch(`/room-requests/${requestId}/update-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Başarılı olursa sayfayı yenile
                        location.reload();
                    } else {
                        alert('Durum güncellenirken bir hata oluştu.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Durum güncellenirken bir hata oluştu.');
                });
            });
        });
    });
</script>
@endpush
