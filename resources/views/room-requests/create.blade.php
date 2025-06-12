@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold d-flex align-items-center">
                <i class='bx bx-plus-circle fs-1 me-2 text-primary'></i>
                Yeni İstek Oluştur
            </h1>
            <p class="text-muted">Odalar için yeni bir istek oluşturun.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('room-requests.index') }}" class="btn btn-outline-secondary">
                <i class='bx bx-arrow-back me-1'></i> İstek Listesine Dön
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-message-square-add me-2'></i>İstek Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('room-requests.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="room_id" class="form-label">Oda <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-hotel"></i></span>
                                    <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                        <option value="">Oda Seçin</option>
                                        @forelse($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id', $roomId) == $room->id ? 'selected' : '' }}>
                                                {{ $room->room_number }} - {{ $room->roomType->name }} ({{ $room->status }})
                                            </option>
                                        @empty
                                            <option value="" disabled>Oda bulunamadı</option>
                                        @endforelse
                                    </select>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                @if($rooms->isEmpty())
                                    <div class="alert alert-warning mt-2 d-flex align-items-center" role="alert">
                                        <i class='bx bx-info-circle me-2 fs-5'></i>
                                        <div>Şu anda kayıtlı oda bulunmamaktadır. Lütfen önce oda ekleyin.</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="request_content" class="form-label">İstek İçeriği <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-message-detail"></i></span>
                                    <textarea id="request_content" name="request_content" class="form-control @error('request_content') is-invalid @enderror" rows="4" required>{{ old('request_content') }}</textarea>
                                    @error('request_content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">İsteğin detaylarını açıkça belirtin.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="notes" class="form-label">Notlar</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-note"></i></span>
                                    <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">İsteğe ilişkin ek notlar (opsiyonel).</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('room-requests.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class='bx bx-x me-1'></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> İsteği Oluştur
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
                    <div class="alert alert-info mb-0" role="alert">
                        <h6 class="alert-heading fw-bold"><i class='bx bx-bulb me-1'></i> İstek Oluşturma Hakkında</h6>
                        <p>Odalar için istekler oluşturarak, temizlik, bakım veya diğer hizmetler için talep oluşturabilirsiniz.</p>
                        <hr>
                        <p class="mb-0">İstek durumları:</p>
                        <ul class="mb-0 ps-3">
                            <li><span class="badge bg-warning text-dark">Bekliyor</span> - Henüz işleme alınmamış</li>
                            <li><span class="badge bg-info text-dark">İşlemde</span> - Şu anda işleniyor</li>
                            <li><span class="badge bg-success">Tamamlandı</span> - İşlem tamamlandı</li>
                        </ul>
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
        // Form validation için örnek kod
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const roomId = document.getElementById('room_id').value;
            const requestContent = document.getElementById('request_content').value;
            
            if (!roomId || !requestContent) {
                event.preventDefault();
                alert('Lütfen gerekli alanları doldurun.');
            }
        });
    });
</script>
@endpush
