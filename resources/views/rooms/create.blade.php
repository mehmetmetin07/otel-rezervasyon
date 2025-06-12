<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Yeni Oda Ekle') }}
            </h2>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class='bx bx-arrow-back me-1'></i> Oda Listesi
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-plus-circle fs-3 me-2 text-primary'></i>
                                <h5 class="mb-0">Yeni Oda Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form method="POST" action="{{ route('rooms.store') }}">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="room_number" class="form-label fw-bold">Oda Numarası <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number') }}" required>
                                        @error('room_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="room_type_id" class="form-label fw-bold">Oda Tipi <span class="text-danger">*</span></label>
                                        <select class="form-select @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" required>
                                            <option value="">Oda Tipi Seçin</option>
                                            @foreach($roomTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }} ({{ number_format($type->base_price, 2) }} TL)
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('room_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="floor" class="form-label fw-bold">Kat</label>
                                        <input type="number" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor', 1) }}">
                                        @error('floor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="capacity" class="form-label fw-bold">Kapasite <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', 2) }}" required>
                                        @error('capacity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="description" class="form-label fw-bold">Açıklama</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="price_adjustment" class="form-label fw-bold">Fiyat Ayarlaması (TL)</label>
                                        <input type="number" class="form-control @error('price_adjustment') is-invalid @enderror" id="price_adjustment" name="price_adjustment" value="{{ old('price_adjustment', 0) }}" step="0.01">
                                        @error('price_adjustment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Odanın temel fiyatına ek olarak uygulanacak fiyat ayarlaması</small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="status" class="form-label fw-bold">Durum <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Boş</option>
                                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Dolu</option>
                                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                                            <option value="cleaning" {{ old('status') == 'cleaning' ? 'selected' : '' }}>Temizleniyor</option>
                                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_balcony" name="has_balcony" value="1" {{ old('has_balcony') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_balcony">Balkon</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_sea_view" name="has_sea_view" value="1" {{ old('has_sea_view') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_sea_view">Deniz Manzarası</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_air_condition" name="has_air_condition" value="1" {{ old('has_air_condition') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_air_condition">Klima</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_tv" name="has_tv" value="1" {{ old('has_tv') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_tv">Televizyon</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_minibar" name="has_minibar" value="1" {{ old('has_minibar') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_minibar">Mini Bar</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_safe" name="has_safe" value="1" {{ old('has_safe') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="has_safe">Kasa</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Aktif</label>
                                        </div>
                                        <small class="text-muted">Oda aktif değilse, rezervasyon için kullanılamaz.</small>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class='bx bx-x me-1'></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-save me-1'></i> Kaydet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
