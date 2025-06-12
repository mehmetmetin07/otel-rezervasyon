<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight d-flex align-items-center">
                <i class='bx bx-edit me-2 text-primary'></i> {{ __('Müşteri Düzenle') }}
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill px-3">#{{ $customer->id }}</span>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <form method="POST" action="{{ route('customers.update', $customer) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <i class='bx bx-user-circle fs-4 text-primary'></i>
                                    </div>
                                    <h5 class="mb-0 fw-semibold">Müşteri Bilgileri</h5>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <!-- Kişisel Bilgiler -->
                                <h6 class="fw-semibold mb-3 d-flex align-items-center">
                                    <i class='bx bx-user me-2 text-primary'></i> Kişisel Bilgiler
                                </h6>
                                
                                <div class="row mb-4">
                                    <!-- Adı -->
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label fw-medium">Adı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <input id="first_name" class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required autofocus />
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Soyadı -->
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label fw-medium">Soyadı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <input id="last_name" class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required />
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- T.C. Kimlik No / Pasaport No -->
                                    <div class="col-md-6 mb-3">
                                        <label for="identity_number" class="form-label fw-medium">T.C. Kimlik / Pasaport No <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-id-card'></i></span>
                                            <input id="identity_number" class="form-control @error('identity_number') is-invalid @enderror" type="text" name="identity_number" value="{{ old('identity_number', $customer->identity_number) }}" required />
                                            @error('identity_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- İletişim Bilgileri -->
                                <h6 class="fw-semibold mb-3 d-flex align-items-center border-top pt-4">
                                    <i class='bx bx-phone me-2 text-primary'></i> İletişim Bilgileri
                                </h6>
                                
                                <div class="row mb-4">
                                    <!-- Telefon -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label fw-medium">Telefon <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                            <input id="phone" class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required />
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- E-posta -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-medium">E-posta</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $customer->email) }}" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Adres -->
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label fw-medium">Adres</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-map'></i></span>
                                            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $customer->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ek Bilgiler -->
                                <h6 class="fw-semibold mb-3 d-flex align-items-center border-top pt-4">
                                    <i class='bx bx-note me-2 text-primary'></i> Ek Bilgiler
                                </h6>
                                
                                <div class="row">
                                    <!-- Notlar -->
                                    <div class="col-md-12 mb-3">
                                        <label for="notes" class="form-label fw-medium">Notlar</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-message-detail'></i></span>
                                            <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $customer->notes) }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between p-3">
                                <div>
                                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                                        <i class='bx bx-list-ul'></i> {{ __('Tüm Müşteriler') }}
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                                        <i class='bx bx-x'></i> {{ __('İptal') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class='bx bx-save'></i> {{ __('Güncelle') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
