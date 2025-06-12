<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-edit me-2 text-primary'></i> {{ __('Oda Tipi Düzenle') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('room-types.show', $roomType) }}" class="btn btn-info btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-show me-1'></i> <span>{{ __('Detay') }}</span>
                </a>
                <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> <span>{{ __('Oda Tipleri') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-edit-alt fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Oda Tipi Bilgilerini Düzenle</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <i class="bx bx-error-circle fs-4 me-2"></i>
                                        <div>
                                            <strong>Hata!</strong> Lütfen aşağıdaki hataları düzeltin:
                                            <ul class="mb-0 mt-1 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('room-types.update', $roomType) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row g-4 mb-4">
                                    <!-- Oda Tipi Adı -->
                                    <div class="col-md-12">
                                        <label for="name" class="form-label fw-bold">Oda Tipi Adı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-category-alt"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                id="name" name="name" value="{{ old('name', $roomType->name) }}" 
                                                placeholder="Örn: Standart Oda, Deluxe Oda, Suite" required autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Kapasite -->
                                    <div class="col-md-6">
                                        <label for="capacity" class="form-label fw-bold">Kapasite <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                                id="capacity" name="capacity" value="{{ old('capacity', $roomType->capacity) }}" 
                                                min="1" max="10" required>
                                            @error('capacity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Odada kalabilecek maksimum kişi sayısı</small>
                                    </div>
                                    
                                    <!-- Temel Fiyat -->
                                    <div class="col-md-6">
                                        <label for="base_price" class="form-label fw-bold">Temel Fiyat (TL) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-lira"></i></span>
                                            <input type="number" class="form-control @error('base_price') is-invalid @enderror" 
                                                id="base_price" name="base_price" value="{{ old('base_price', $roomType->base_price) }}" 
                                                min="0" step="0.01" required>
                                            @error('base_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Oda tipinin gecelik temel fiyatı</small>
                                    </div>
                                    
                                    <!-- Açıklama -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label fw-bold">Açıklama</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-text"></i></span>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="4" 
                                                placeholder="Oda tipi hakkında detaylı bilgi">{{ old('description', $roomType->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('room-types.show', $roomType) }}" class="btn btn-outline-secondary me-2">
                                        <i class="bx bx-x me-1"></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Kaydet
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
