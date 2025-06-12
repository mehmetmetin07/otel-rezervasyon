<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Ayarları') }}
            </h2>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class='bx bx-arrow-back me-1'></i> Geri Dön
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 ms-2"
                        onclick="if(confirm('Hesabınızı silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')) document.getElementById('delete-user-profile-form').submit();">
                    <i class='bx bx-trash me-1'></i> Hesabı Sil
                </button>
                <form id="delete-user-profile-form" action="{{ route('profile.destroy') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-xl mx-auto mb-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <span class="fs-3 text-primary fw-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <p class="text-muted mb-3">{{ Auth::user()->email }}</p>

                            <div class="d-flex justify-content-center">
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-primary"><i class='bx bx-crown me-1'></i> Admin</span>
                                @elseif(Auth::user()->isReceptionist())
                                    <span class="badge bg-info"><i class='bx bx-id-card me-1'></i> Resepsiyonist</span>
                                @elseif(Auth::user()->isCleaner())
                                    <span class="badge bg-success"><i class='bx bx-broom me-1'></i> Temizlik Görevlisi</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white py-3">
                            <div class="text-center text-muted small">
                                <div>Kayıt Tarihi: {{ Auth::user()->created_at->format('d.m.Y') }}</div>
                                <div>Son Güncelleme: {{ Auth::user()->updated_at->format('d.m.Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-user-circle fs-3 me-2 text-primary'></i>
                                <h5 class="mb-0">Profil Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-lock-alt fs-3 me-2 text-primary'></i>
                                <h5 class="mb-0">Şifre Değiştir</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    @if(Auth::user()->isAdmin())
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-envelope fs-3 me-2 text-primary'></i>
                                <h5 class="mb-0">E-posta SMTP Ayarları</h5>
                            </div>
                            <span class="badge bg-warning text-dark">
                                <i class='bx bx-shield-alt-2 me-1'></i>
                                Sadece Admin
                            </span>
                        </div>
                        <div class="card-body p-4">
                            @if (session('status') === 'smtp-updated')
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-check-circle fs-4 me-2'></i>
                                        <div>SMTP ayarları başarıyla güncellendi!</div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @include('profile.partials.update-smtp-settings-form')
                        </div>
                    </div>
                    @endif

                    <div class="card shadow-sm border-danger-subtle">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-trash fs-3 me-2 text-danger'></i>
                                <h5 class="mb-0 text-danger">Hesabı Sil</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
