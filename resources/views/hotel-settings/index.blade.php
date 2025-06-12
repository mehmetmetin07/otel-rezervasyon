<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Otel Ayarları') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3" style="width: 50px; height: 50px;">
                                    <i class='bx bxs-hotel text-primary fs-4'></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-semibold">Otel Ayarları</h5>
                                    <small class="text-muted">Otel bilgileri ve email şablon metinlerini yönetin</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    <i class='bx bx-arrow-back me-1'></i> Gösterge Paneli
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <i class='bx bx-check-circle fs-4 me-2'></i>
                                        <div>
                                            <strong>Başarılı!</strong> {{ session('success') }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('hotel-settings.update') }}">
                                @csrf
                                @method('PATCH')

                                <!-- Temel Bilgiler -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3">
                                            <i class='bx bxs-info-circle text-info fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Temel Bilgiler</h6>
                                            <small class="text-muted">Otel detayları ve iletişim bilgileri</small>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="hotel_name" class="form-label">Otel Adı <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class='bx bxs-hotel'></i></span>
                                                <input type="text" class="form-control @error('hotel_name') is-invalid @enderror"
                                                    id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $settings->hotel_name ?? '') }}"
                                                    placeholder="Otel adınızı girin" required>
                                                @error('hotel_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                                                                <div class="col-md-6">
                                            <label for="hotel_website" class="form-label">Otel Web Sitesi</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class='bx bx-globe'></i></span>
                                                <input type="url" class="form-control @error('hotel_website') is-invalid @enderror"
                                                    id="hotel_website" name="hotel_website" value="{{ old('hotel_website', $settings->hotel_website ?? '') }}"
                                                    placeholder="https://yourhotel.com">
                                                @error('hotel_website')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Opsiyonel. Boş bırakabilirsiniz veya https:// ile başlayan geçerli bir URL girin.</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Telefon Numarası</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class='bx bx-phone'></i></span>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                    id="phone" name="phone" value="{{ old('phone', $settings->phone ?? '') }}"
                                                    placeholder="+90 xxx xxx xxxx">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">E-posta Adresi</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ old('email', $settings->email ?? '') }}"
                                                    placeholder="info@yourhotel.com">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="address" class="form-label">Adres</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class='bx bx-map'></i></span>
                                                <textarea class="form-control @error('address') is-invalid @enderror"
                                                    id="address" name="address" rows="3"
                                                    placeholder="Otel adresinizi girin">{{ old('address', $settings->address ?? '') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Şablon İçerikleri -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                            <i class='bx bxs-message-dots text-success fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Email Şablon İçerikleri</h6>
                                            <small class="text-muted">Check-in ve check-out email metinleri</small>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="welcome_description" class="form-label">
                                                <i class='bx bxs-log-in-circle text-success me-1'></i>
                                                Hoş Geldin Mesajı
                                            </label>
                                            <textarea class="form-control @error('welcome_description') is-invalid @enderror"
                                                id="welcome_description" name="welcome_description" rows="4"
                                                placeholder="Check-in emaillerinde gösterilecek mesaj...">{{ old('welcome_description', $settings->welcome_description ?? '') }}</textarea>
                                            @error('welcome_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Bu mesaj müşteriler check-in yaptığında gönderilir</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="goodbye_description" class="form-label">
                                                <i class='bx bxs-log-out-circle text-warning me-1'></i>
                                                Güle Güle Mesajı
                                            </label>
                                            <textarea class="form-control @error('goodbye_description') is-invalid @enderror"
                                                id="goodbye_description" name="goodbye_description" rows="4"
                                                placeholder="Check-out emaillerinde gösterilecek mesaj...">{{ old('goodbye_description', $settings->goodbye_description ?? '') }}</textarea>
                                            @error('goodbye_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Bu mesaj müşteriler check-out yaptığında gönderilir</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Gönderim Ayarları -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                            <i class='bx bxs-cog text-warning fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Email Gönderim Ayarları</h6>
                                            <small class="text-muted">Otomatik email gönderim seçenekleri</small>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="card border-success border-opacity-25">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <i class='bx bxs-log-in-circle text-success me-2'></i>
                                                                Check-in Email Gönderimi
                                                            </h6>
                                                            <p class="text-muted small mb-0">Müşteri check-in yaptığında otomatik email gönder</p>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="auto_send_welcome_email" value="1"
                                                                {{ old('auto_send_welcome_email', $settings->auto_send_welcome_email ?? false) ? 'checked' : '' }}
                                                                id="auto_send_welcome_email">
                                                            <label class="form-check-label" for="auto_send_welcome_email"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card border-warning border-opacity-25">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <i class='bx bxs-log-out-circle text-warning me-2'></i>
                                                                Check-out Email Gönderimi
                                                            </h6>
                                                            <p class="text-muted small mb-0">Müşteri check-out yaptığında otomatik email gönder</p>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="auto_send_goodbye_email" value="1"
                                                                {{ old('auto_send_goodbye_email', $settings->auto_send_goodbye_email ?? false) ? 'checked' : '' }}
                                                                id="auto_send_goodbye_email">
                                                            <label class="form-check-label" for="auto_send_goodbye_email"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Durum -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class='bx bxs-toggle-right text-primary fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Sistem Durumu</h6>
                                            <small class="text-muted">Ayarların aktif durumu</small>
                                        </div>
                                    </div>

                                    <div class="card border-primary border-opacity-25">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class='bx bxs-check-circle text-primary me-2'></i>
                                                        Ayarları Aktif Et
                                                    </h6>
                                                    <p class="text-muted small mb-0">Bu ayarların sistem genelinde kullanılmasını sağlar</p>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                                        {{ old('is_active', $settings->is_active ?? true) ? 'checked' : '' }}
                                                        id="is_active">
                                                    <label class="form-check-label" for="is_active"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                        <i class='bx bx-x me-1'></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class='bx bx-save me-1'></i> Ayarları Kaydet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hotelWebsiteInput = document.getElementById('hotel_website');

        if (hotelWebsiteInput) {
            hotelWebsiteInput.addEventListener('blur', function() {
                const value = this.value.trim();

                // Eğer boşsa sorun yok
                if (value === '') {
                    this.classList.remove('is-invalid');
                    return;
                }

                // URL validation
                const urlPattern = /^https?:\/\/.+\..+/;
                if (!urlPattern.test(value)) {
                    this.classList.add('is-invalid');

                    // Custom error message ekle
                    let feedback = this.parentNode.querySelector('.invalid-feedback');
                    if (!feedback) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        this.parentNode.appendChild(feedback);
                    }
                    feedback.textContent = 'Geçerli bir URL girin (örn: https://example.com)';
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            // Form submit validation
            hotelWebsiteInput.closest('form').addEventListener('submit', function(e) {
                const value = hotelWebsiteInput.value.trim();

                if (value !== '') {
                    const urlPattern = /^https?:\/\/.+\..+/;
                    if (!urlPattern.test(value)) {
                        e.preventDefault();
                        hotelWebsiteInput.focus();
                        hotelWebsiteInput.classList.add('is-invalid');

                        let feedback = hotelWebsiteInput.parentNode.querySelector('.invalid-feedback');
                        if (!feedback) {
                            feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            hotelWebsiteInput.parentNode.appendChild(feedback);
                        }
                        feedback.textContent = 'Lütfen geçerli bir URL girin veya alanı boş bırakın';

                        // Alert ile de uyar
                        alert('Web site adresi geçerli bir URL olmalıdır (örn: https://example.com) veya boş bırakılmalıdır.');
                    }
                }
            });
        }
    });
    </script>
</x-app-layout>
