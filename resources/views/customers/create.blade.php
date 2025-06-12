<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Müşteri') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-user-plus fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Müşteri Bilgileri</h5>
                            </div>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bx bx-arrow-back me-1"></i> Müşteri Listesi
                            </a>
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

                            <form method="POST" action="{{ route('customers.store') }}">
                                @csrf
                                
                                <div class="row g-4 mb-4">
                                    <!-- Kişisel Bilgiler -->
                                    <div class="col-12 mb-2">
                                        <h6 class="fw-bold text-primary"><i class="bx bx-user me-1"></i> Kişisel Bilgiler</h6>
                                        <hr class="mt-1">
                                    </div>
                                    
                                    <!-- Adı -->
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">Adı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                                placeholder="Müşterinin adı" required autofocus>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Soyadı -->
                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Soyadı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                                id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                                placeholder="Müşterinin soyadı" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- T.C. Kimlik No / Pasaport No -->
                                    <div class="col-md-6">
                                        <label for="id_number" class="form-label">T.C. Kimlik No / Pasaport No <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" 
                                                id="id_number" name="id_number" value="{{ old('id_number') }}" 
                                                placeholder="11 haneli kimlik numarası veya pasaport no" required>
                                            @error('id_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- İletişim Bilgileri -->
                                    <div class="col-12 mt-4 mb-2">
                                        <h6 class="fw-bold text-primary"><i class="bx bx-phone me-1"></i> İletişim Bilgileri</h6>
                                        <hr class="mt-1">
                                    </div>
                                    
                                    <!-- Telefon -->
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Telefon <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                id="phone" name="phone" value="{{ old('phone') }}" 
                                                placeholder="05XX XXX XX XX" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- E-posta -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-posta</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                id="email" name="email" value="{{ old('email') }}" 
                                                placeholder="ornek@mail.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Adres -->
                                    <div class="col-12">
                                        <label for="address" class="form-label">Adres</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                id="address" name="address" rows="3" 
                                                placeholder="Müşterinin tam adresi">{{ old('address') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Notlar -->
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Notlar</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-note"></i></span>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                id="notes" name="notes" rows="3" 
                                                placeholder="Müşteri hakkında ekstra bilgiler">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="bx bx-x me-1"></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Müşteriyi Kaydet
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
