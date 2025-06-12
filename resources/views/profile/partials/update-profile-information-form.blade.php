<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class='bx bx-check-circle me-2'></i> Profil bilgileriniz başarıyla güncellendi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-4">
            <p class="text-muted">Hesap bilgilerinizi ve e-posta adresinizi güncelleyin.</p>
        </div>

        <div class="row g-3">
            <!-- İsim Alanı -->
            <div class="col-md-6">
                <label for="name" class="form-label">İsim</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', $user->name) }}" 
                        required autofocus autocomplete="name" placeholder="Adınız Soyadınız">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- E-posta Alanı -->
            <div class="col-md-6">
                <label for="email" class="form-label">E-posta</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                        id="email" name="email" value="{{ old('email', $user->email) }}" 
                        required autocomplete="username" placeholder="ornek@mail.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning mt-3 mb-4">
                <div class="d-flex align-items-center">
                    <i class='bx bx-error-circle me-2'></i>
                    <div>
                        <p class="mb-0">E-posta adresiniz doğrulanmamış.</p>
                        <button form="send-verification" class="btn btn-sm btn-link p-0 text-decoration-none">
                            Doğrulama e-postasını tekrar göndermek için tıklayın.
                        </button>
                    </div>
                </div>
                
                @if (session('status') === 'verification-link-sent')
                    <div class="mt-2 text-success">
                        <i class='bx bx-check-circle me-1'></i> Yeni bir doğrulama bağlantısı e-posta adresinize gönderildi.
                    </div>
                @endif
            </div>
        @endif

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-save me-1'></i> Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</section>
