<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Kullanıcı Ekle') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-user-plus fs-3 me-2 text-primary'></i>
                                <h5 class="mb-0">Yeni Kullanıcı Bilgileri</h5>
                            </div>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class='bx bx-arrow-back me-1'></i> Kullanıcılara Dön
                            </a>
                        </div>
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <!-- Ad -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Ad Soyad <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Ad Soyad">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">E-posta <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="ornek@mail.com">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Şifre -->
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Şifre <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimum 8 karakter">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class='bx bx-show'></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Şifre Tekrar -->
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">Şifre Tekrar <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-lock'></i></span>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Şifreyi tekrar girin">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                                <i class='bx bx-show'></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Rol -->
                                    <div class="col-md-12">
                                        <label for="role" class="form-label">Kullanıcı Rolü <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user-circle'></i></span>
                                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                                <option value="">Rol seçin</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="receptionist" {{ old('role') == 'receptionist' ? 'selected' : '' }}>Resepsiyonist</option>
                                                <option value="cleaner" {{ old('role') == 'cleaner' ? 'selected' : '' }}>Temizlik Görevlisi</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4 gap-2">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class='bx bx-reset me-1'></i> Sıfırla
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-save me-1'></i> Kullanıcı Oluştur
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Şifre göster/gizle
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });

            // Şifre tekrar göster/gizle
            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const passwordConfirmation = document.querySelector('#password_confirmation');

            togglePasswordConfirmation.addEventListener('click', function() {
                const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmation.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });
        });
    </script>
    @endpush
</x-app-layout>
