<x-guest-layout>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-sm-5">
            <!-- Logo ve Başlık -->
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class='bx bxs-hotel text-primary' style="font-size: 3rem;"></i>
                </div>
                <h4 class="mb-1 fw-bold">Otel Rezervasyon Sistemi</h4>
                <p class="text-muted">Hesabınıza giriş yapın</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('E-posta Adresi') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="ornek@mail.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">{{ __('Şifre') }}</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                {{ __('Şifremi unuttum') }}
                            </a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class='bx bx-show'></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember_me">
                        {{ __('Beni hatırla') }}
                    </label>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class='bx bx-log-in-circle me-1'></i> {{ __('Giriş Yap') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Şifre göster/gizle için JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function() {
                // Şifre alanının tipini değiştir
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // İkonu değiştir
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });
        });
    </script>
</x-guest-layout>
