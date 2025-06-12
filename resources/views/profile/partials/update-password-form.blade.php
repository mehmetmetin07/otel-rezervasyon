<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        @if (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class='bx bx-check-circle me-2'></i> Şifreniz başarıyla güncellendi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">
            <!-- Mevcut Şifre -->
            <div class="col-md-12">
                <label for="update_password_current_password" class="form-label">Mevcut Şifre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                    <input id="update_password_current_password" name="current_password" type="password" 
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                        autocomplete="current-password" placeholder="Mevcut şifrenizi girin">
                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                        <i class='bx bx-show'></i>
                    </button>
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Yeni Şifre -->
            <div class="col-md-6">
                <label for="update_password_password" class="form-label">Yeni Şifre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-lock'></i></span>
                    <input id="update_password_password" name="password" type="password" 
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                        autocomplete="new-password" placeholder="En az 8 karakter">
                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                        <i class='bx bx-show'></i>
                    </button>
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text mt-1">
                    <small><i class='bx bx-info-circle me-1'></i> Güçlü bir şifre için harf, rakam ve özel karakter kullanın.</small>
                </div>
            </div>

            <!-- Şifre Tekrar -->
            <div class="col-md-6">
                <label for="update_password_password_confirmation" class="form-label">Şifre Tekrar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bx-lock-open'></i></span>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                        class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                        autocomplete="new-password" placeholder="Yeni şifrenizi tekrar girin">
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                        <i class='bx bx-show'></i>
                    </button>
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-lock-alt me-1'></i> Şifreyi Güncelle
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mevcut şifre göster/gizle
            const toggleCurrentPassword = document.querySelector('#toggleCurrentPassword');
            const currentPassword = document.querySelector('#update_password_current_password');

            toggleCurrentPassword.addEventListener('click', function() {
                const type = currentPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                currentPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });

            // Yeni şifre göster/gizle
            const toggleNewPassword = document.querySelector('#toggleNewPassword');
            const newPassword = document.querySelector('#update_password_password');

            toggleNewPassword.addEventListener('click', function() {
                const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                newPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });

            // Şifre tekrar göster/gizle
            const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
            const confirmPassword = document.querySelector('#update_password_password_confirmation');

            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bx-show');
                this.querySelector('i').classList.toggle('bx-hide');
            });
        });
    </script>
    @endpush
</section>
