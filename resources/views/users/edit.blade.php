<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kullanıcı Düzenle') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                    <span class="fs-4 text-primary fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-semibold">{{ $user->name }}</h5>
                                    <small class="text-muted">Kullanıcı #{{ $user->id }} · {{ $user->role->name ?? 'Rol Atanmamış' }}</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class='bx bx-arrow-back me-1'></i> Kullanıcı Listesi
                                </a>
                                @if(Auth::id() != $user->id)
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 ms-2" 
                                   onclick="if(confirm('Kullanıcıyı silmek istediğinize emin misiniz?')) document.getElementById('delete-user-form').submit();">
                                    <i class='bx bx-trash me-1'></i> Kullanıcıyı Sil
                                </button>
                                <form id="delete-user-form" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <i class='bx bx-error-circle fs-4 me-2'></i>
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

                            <form method="POST" action="{{ route('users.update', $user) }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Ad Soyad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                id="name" name="name" value="{{ old('name', $user->name) }}" 
                                                placeholder="Kullanıcının adı soyadı" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-text">Kullanıcının tam adı</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-posta Adresi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                id="email" name="email" value="{{ old('email', $user->email) }}" 
                                                placeholder="ornek@mail.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-text">Giriş ve bildirimler için kullanılacak e-posta</div>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="role_id" class="form-label">Kullanıcı Rolü</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-shield-quarter'></i></span>
                                        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                            <option value="">Rol Seçin</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>
                                                    {{ $role->name }} - {{ $role->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Kullanıcının sistem içindeki yetkilerini belirler</div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-5">
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                        <i class='bx bx-x me-1'></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class='bx bx-save me-1'></i> Değişiklikleri Kaydet
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
