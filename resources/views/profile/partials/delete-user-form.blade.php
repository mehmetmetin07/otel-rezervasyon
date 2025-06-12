<section>
    <div class="alert alert-danger">
        <div class="d-flex align-items-center">
            <i class='bx bx-error-circle fs-3 me-3'></i>
            <div>
                <h6 class="alert-heading mb-1 fw-bold">Tehlikeli Bölge</h6>
                <p class="mb-0">Hesabınızı sildiğinizde, tüm verileriniz ve kaynaklarınız kalıcı olarak silinecektir. Devam etmeden önce saklamak istediğiniz verileri yedeklediğinizden emin olun.</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class='bx bx-trash me-1'></i> Hesabı Sil
        </button>
    </div>

    <!-- Hesap Silme Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Hesabınızı Silmek İstediğinize Emin Misiniz?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg mx-auto mb-3 bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center">
                            <i class='bx bx-user-x fs-1 text-danger'></i>
                        </div>
                        <p>Hesabınızı sildiğinizde, tüm verileriniz ve kaynaklarınız kalıcı olarak silinecektir. Bu işlem geri alınamaz.</p>
                    </div>

                    <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">Onaylamak için şifrenizi girin</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Şifrenizi girin" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleDeletePassword">
                                    <i class='bx bx-show'></i>
                                </button>
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> İptal
                    </button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                        <i class='bx bx-trash me-1'></i> Hesabı Sil
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            deleteModal.show();
        });
    </script>
    @endif

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Şifre göster/gizle
            const toggleDeletePassword = document.querySelector('#toggleDeletePassword');
            const deletePassword = document.querySelector('#password');

            if (toggleDeletePassword && deletePassword) {
                toggleDeletePassword.addEventListener('click', function() {
                    const type = deletePassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    deletePassword.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('bx-show');
                    this.querySelector('i').classList.toggle('bx-hide');
                });
            }
        });
    </script>
    @endpush
</section>
