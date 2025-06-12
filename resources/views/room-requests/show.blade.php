@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold d-flex align-items-center">
                <i class='bx bxs-message-square-detail fs-1 me-2 text-primary'></i>
                İstek Detayı
                <span class="badge bg-primary ms-2 fs-6">#{{ $roomRequest->id }}</span>
            </h1>
            <p class="text-muted">Oda isteği detaylarını görüntüleyin ve yönetin.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('room-requests.index') }}" class="btn btn-outline-secondary me-2">
                <i class='bx bx-arrow-back me-1'></i> İstek Listesi
            </a>
            <a href="{{ route('room-requests.edit', $roomRequest->id) }}" class="btn btn-primary">
                <i class='bx bx-edit me-1'></i> Düzenle
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class='bx bx-check-circle me-1'></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class='bx bx-message-square-detail me-2'></i>İstek Bilgileri</h5>
                        <div>
                            @if($roomRequest->status == 'pending')
                            <span class="badge bg-warning text-dark">Bekliyor</span>
                            @elseif($roomRequest->status == 'in_progress')
                            <span class="badge bg-info text-dark">İşlemde</span>
                            @elseif($roomRequest->status == 'completed')
                            <span class="badge bg-success">Tamamlandı</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Oda Bilgisi</h6>
                            <div class="d-flex align-items-center">
                                <i class='bx bxs-hotel fs-4 me-2 text-primary'></i>
                                <div>
                                    <h5 class="mb-0">{{ $roomRequest->room->room_number }}</h5>
                                    <p class="mb-0 text-muted small">{{ $roomRequest->room->roomType->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Oluşturan</h6>
                            <div class="d-flex align-items-center">
                                <i class='bx bxs-user fs-4 me-2 text-primary'></i>
                                <div>
                                    <h5 class="mb-0">{{ $roomRequest->user ? $roomRequest->user->name : 'Bilinmiyor' }}</h5>
                                    <p class="mb-0 text-muted small">{{ $roomRequest->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">İstek İçeriği</h6>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $roomRequest->request_content }}</p>
                            </div>
                        </div>
                    </div>

                    @if($roomRequest->notes)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">Notlar</h6>
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $roomRequest->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">Durum Bilgisi</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    @if($roomRequest->status == 'pending')
                                    <i class='bx bx-time fs-4 me-2 text-warning'></i>
                                    <div>
                                        <h5 class="mb-0">Bekliyor</h5>
                                        <p class="mb-0 text-muted small">İstek henüz işleme alınmadı</p>
                                    </div>
                                    @elseif($roomRequest->status == 'in_progress')
                                    <i class='bx bx-loader-circle fs-4 me-2 text-info'></i>
                                    <div>
                                        <h5 class="mb-0">İşlemde</h5>
                                        <p class="mb-0 text-muted small">İstek şu anda işleniyor</p>
                                    </div>
                                    @elseif($roomRequest->status == 'completed')
                                    <i class='bx bx-check-circle fs-4 me-2 text-success'></i>
                                    <div>
                                        <h5 class="mb-0">Tamamlandı</h5>
                                        <p class="mb-0 text-muted small">
                                            {{ $roomRequest->completed_at ? $roomRequest->completed_at->format('d.m.Y H:i') : 'Tarih bilgisi yok' }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='bx bx-revision me-1'></i> Durumu Güncelle
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statusDropdown">
                                        <li>
                                            <button class="dropdown-item status-update" data-status="pending" data-request-id="{{ $roomRequest->id }}">
                                                <i class='bx bx-time me-1 text-warning'></i> Bekliyor
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item status-update" data-status="in_progress" data-request-id="{{ $roomRequest->id }}">
                                                <i class='bx bx-loader-circle me-1 text-info'></i> İşlemde
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item status-update" data-status="completed" data-request-id="{{ $roomRequest->id }}">
                                                <i class='bx bx-check-circle me-1 text-success'></i> Tamamlandı
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class='bx bx-trash me-1'></i> Sil
                        </button>
                        <a href="{{ route('room-requests.edit', $roomRequest->id) }}" class="btn btn-primary">
                            <i class='bx bx-edit me-1'></i> Düzenle
                        </a>
                    </div>
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
                            <h4 class="mb-0">{{ $roomRequest->room->room_number }}</h4>
                            <p class="mb-0 text-muted">{{ $roomRequest->room->roomType->name }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Durum:</span>
                            <span class="badge {{ $roomRequest->room->status == 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $roomRequest->room->status == 'available' ? 'Müsait' : $roomRequest->room->status }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Kat:</span>
                            <span>{{ $roomRequest->room->floor ?? 'Belirtilmemiş' }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Fiyat:</span>
                            <span>{{ number_format($roomRequest->room->roomType->base_price, 2) }} ₺</span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('rooms.show', $roomRequest->room_id) }}" class="btn btn-outline-primary">
                            <i class='bx bx-show me-1'></i> Oda Detaylarını Gör
                        </a>
                        <a href="{{ route('rooms.requests', $roomRequest->room_id) }}" class="btn btn-outline-secondary">
                            <i class='bx bx-list-ul me-1'></i> Odanın Tüm İstekleri
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-history me-2'></i>İşlem Geçmişi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="badge bg-primary rounded-pill me-2">Oluşturuldu</span>
                                <span class="text-muted small">{{ $roomRequest->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <span class="text-muted small">{{ $roomRequest->user ? $roomRequest->user->name : 'Bilinmiyor' }}</span>
                        </li>
                        
                        @if($roomRequest->updated_at->gt($roomRequest->created_at))
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="badge bg-info rounded-pill me-2">Güncellendi</span>
                                <span class="text-muted small">{{ $roomRequest->updated_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <span class="text-muted small">{{ $roomRequest->user ? $roomRequest->user->name : 'Bilinmiyor' }}</span>
                        </li>
                        @endif
                        
                        @if($roomRequest->completed_at)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <span class="badge bg-success rounded-pill me-2">Tamamlandı</span>
                                <span class="text-muted small">{{ $roomRequest->completed_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <span class="text-muted small">{{ $roomRequest->user ? $roomRequest->user->name : 'Bilinmiyor' }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="deleteModalLabel">İsteği Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class='bx bx-error-circle text-danger' style="font-size: 5rem;"></i>
                </div>
                <h5 class="mb-3">Bu isteği silmek istediğinize emin misiniz?</h5>
                <p class="text-muted">Bu işlem geri alınamaz ve tüm istek verileri silinecektir.</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class='bx bx-x me-1'></i> İptal
                </button>
                <form action="{{ route('room-requests.destroy', $roomRequest->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class='bx bx-trash me-1'></i> Evet, Sil
                    </button>
                </form>
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
