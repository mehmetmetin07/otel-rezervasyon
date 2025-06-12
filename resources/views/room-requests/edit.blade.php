@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold d-flex align-items-center">
                <i class='bx bx-edit fs-1 me-2 text-primary'></i>
                İstek Düzenle
                <span class="badge bg-primary ms-2 fs-6">#{{ $roomRequest->id }}</span>
            </h1>
            <p class="text-muted">Oda isteği bilgilerini düzenleyin.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('room-requests.show', $roomRequest->id) }}" class="btn btn-outline-secondary">
                <i class='bx bx-arrow-back me-1'></i> İstek Detayına Dön
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-message-square-edit me-2'></i>İstek Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('room-requests.update', $roomRequest->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="room_id" class="form-label">Oda <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-hotel"></i></span>
                                    <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                        <option value="">Oda Seçin</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id', $roomRequest->room_id) == $room->id ? 'selected' : '' }}>
                                                {{ $room->room_number }} - {{ $room->roomType->name }} ({{ $room->status }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="request_content" class="form-label">İstek İçeriği <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-message-detail"></i></span>
                                    <textarea id="request_content" name="request_content" class="form-control @error('request_content') is-invalid @enderror" rows="4" required>{{ old('request_content', $roomRequest->request_content) }}</textarea>
                                    @error('request_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">İsteğin detaylarını açıkça belirtin.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $roomRequest->status) == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                        <option value="in_progress" {{ old('status', $roomRequest->status) == 'in_progress' ? 'selected' : '' }}>İşlemde</option>
                                        <option value="completed" {{ old('status', $roomRequest->status) == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">İsteğin mevcut durumunu seçin.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Notlar</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-note"></i></span>
                                    <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $roomRequest->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">İsteğe ilişkin ek notlar (opsiyonel).</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('room-requests.show', $roomRequest->id) }}" class="btn btn-outline-secondary me-md-2">
                                <i class='bx bx-x me-1'></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Değişiklikleri Kaydet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-info-circle me-2'></i>Bilgi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3" role="alert">
                        <h6 class="alert-heading fw-bold"><i class='bx bx-bulb me-1'></i> Durum Değiştirme</h6>
                        <p>İstek durumunu "Tamamlandı" olarak değiştirdiğinizde, tamamlanma tarihi otomatik olarak güncellenecektir.</p>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold">Mevcut Durum</h6>
                        <div class="d-flex align-items-center mt-2">
                            @if($roomRequest->status == 'pending')
                            <span class="badge bg-warning text-dark me-2">Bekliyor</span>
                            <span class="text-muted small">İstek henüz işleme alınmadı</span>
                            @elseif($roomRequest->status == 'in_progress')
                            <span class="badge bg-info text-dark me-2">İşlemde</span>
                            <span class="text-muted small">İstek şu anda işleniyor</span>
                            @elseif($roomRequest->status == 'completed')
                            <span class="badge bg-success me-2">Tamamlandı</span>
                            <span class="text-muted small">
                                {{ $roomRequest->completed_at ? $roomRequest->completed_at->format('d.m.Y H:i') : 'Tarih bilgisi yok' }}
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <h6 class="fw-bold">Oluşturulma Bilgisi</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class='bx bx-time-five me-2 text-muted'></i>
                            <span class="text-muted small">{{ $roomRequest->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <i class='bx bx-user me-2 text-muted'></i>
                            <span class="text-muted small">{{ $roomRequest->user ? $roomRequest->user->name : 'Bilinmiyor' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-link me-2'></i>Hızlı Bağlantılar</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('room-requests.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class='bx bx-list-ul me-2 text-primary'></i> İstek Listesine Git
                        </a>
                        <a href="{{ route('room-requests.show', $roomRequest->id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class='bx bx-show me-2 text-primary'></i> İstek Detayını Görüntüle
                        </a>
                        <a href="{{ route('rooms.show', $roomRequest->room_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class='bx bx-hotel me-2 text-primary'></i> Oda Detayını Görüntüle
                        </a>
                        <a href="{{ route('rooms.requests', $roomRequest->room_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class='bx bx-message-square-detail me-2 text-primary'></i> Odanın Tüm İstekleri
                        </a>
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
        // Status değişikliğini izle
        const statusSelect = document.getElementById('status');
        const originalStatus = "{{ $roomRequest->status }}";
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'completed' && originalStatus !== 'completed') {
                // Kullanıcıya tamamlandı durumuna geçiş hakkında bilgi ver
                if (confirm('İsteği "Tamamlandı" olarak işaretlemek istediğinizden emin misiniz? Bu işlem tamamlanma tarihini şu anki tarih olarak güncelleyecektir.')) {
                    // Kullanıcı onayladı, bir şey yapmaya gerek yok
                } else {
                    // Kullanıcı iptal etti, önceki değere geri dön
                    this.value = originalStatus;
                }
            }
        });
    });
</script>
@endpush
