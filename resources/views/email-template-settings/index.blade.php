<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Şablon Ayarları') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3" style="width: 50px; height: 50px;">
                                    <i class='bx bxs-envelope text-success fs-4'></i>
                                </div>
                                <div>
                                    <h5 class="mb-0 fw-semibold">Email Şablon Ayarları</h5>
                                    <small class="text-muted">Sosyal medya linkleri ve yorum sitesi ayarlarını yapılandırın</small>
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

                            <form method="POST" action="{{ route('email-template-settings.update') }}">
                                @csrf
                                @method('PATCH')

                                <!-- Sosyal Medya Platformları -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class='bx bxl-meta text-primary fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Sosyal Medya Platformları</h6>
                                            <small class="text-muted">Hoş geldin emaillerinde gösterilecek sosyal medya linkleri</small>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <!-- Facebook -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxl-facebook-circle text-primary me-2 fs-4'></i>
                                                            <span class="fw-semibold">Facebook</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_facebook" value="1"
                                                                {{ old('show_facebook', $settings->show_facebook_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_facebook">
                                                            <label class="form-check-label" for="show_facebook"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="facebook_url"
                                                        value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"
                                                        placeholder="https://facebook.com/yourpage">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Instagram -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxl-instagram text-danger me-2 fs-4'></i>
                                                            <span class="fw-semibold">Instagram</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_instagram" value="1"
                                                                {{ old('show_instagram', $settings->show_instagram_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_instagram">
                                                            <label class="form-check-label" for="show_instagram"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="instagram_url"
                                                        value="{{ old('instagram_url', $settings->instagram_url ?? '') }}"
                                                        placeholder="https://instagram.com/yourpage">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Twitter -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxl-twitter text-info me-2 fs-4'></i>
                                                            <span class="fw-semibold">Twitter</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_twitter" value="1"
                                                                {{ old('show_twitter', $settings->show_twitter_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_twitter">
                                                            <label class="form-check-label" for="show_twitter"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="twitter_url"
                                                        value="{{ old('twitter_url', $settings->twitter_url ?? '') }}"
                                                        placeholder="https://twitter.com/yourpage">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- LinkedIn -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxl-linkedin text-primary me-2 fs-4'></i>
                                                            <span class="fw-semibold">LinkedIn</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_linkedin" value="1"
                                                                {{ old('show_linkedin', $settings->show_linkedin_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_linkedin">
                                                            <label class="form-check-label" for="show_linkedin"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="linkedin_url"
                                                        value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}"
                                                        placeholder="https://linkedin.com/company/yourcompany">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- YouTube -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxl-youtube text-danger me-2 fs-4'></i>
                                                            <span class="fw-semibold">YouTube</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_youtube" value="1"
                                                                {{ old('show_youtube', $settings->show_youtube_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_youtube">
                                                            <label class="form-check-label" for="show_youtube"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="youtube_url"
                                                        value="{{ old('youtube_url', $settings->youtube_url ?? '') }}"
                                                        placeholder="https://youtube.com/c/yourchannel">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Website -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bx-globe text-success me-2 fs-4'></i>
                                                            <span class="fw-semibold">Web Sitesi</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_website" value="1"
                                                                {{ old('show_website', $settings->show_website_welcome ?? false) ? 'checked' : '' }}
                                                                id="show_website">
                                                            <label class="form-check-label" for="show_website"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="website_url"
                                                        value="{{ old('website_url', $settings->hotel_website_url ?? '') }}"
                                                        placeholder="https://yourhotel.com">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Yorum & Rezervasyon Siteleri -->
                                <div class="mb-5">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                            <i class='bx bxs-star text-warning fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Yorum & Rezervasyon Siteleri</h6>
                                            <small class="text-muted">Güle güle emaillerinde gösterilecek yorum sitesi linkleri</small>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <!-- TripAdvisor -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxs-plane-alt text-success me-2 fs-4'></i>
                                                            <span class="fw-semibold">TripAdvisor</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_tripadvisor" value="1"
                                                                {{ old('show_tripadvisor', $settings->show_review_site_1_goodbye ?? false) ? 'checked' : '' }}
                                                                id="show_tripadvisor">
                                                            <label class="form-check-label" for="show_tripadvisor"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="tripadvisor_url"
                                                        value="{{ old('tripadvisor_url', $settings->review_site_1_url ?? '') }}"
                                                        placeholder="https://tripadvisor.com/hotel/your-hotel">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Booking.com -->
                                        <div class="col-md-6">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bxs-bed text-primary me-2 fs-4'></i>
                                                            <span class="fw-semibold">Booking.com</span>
                                                        </div>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="show_booking" value="1"
                                                                {{ old('show_booking', $settings->show_review_site_2_goodbye ?? false) ? 'checked' : '' }}
                                                                id="show_booking">
                                                            <label class="form-check-label" for="show_booking"></label>
                                                        </div>
                                                    </div>
                                                    <input type="url" class="form-control" name="booking_url"
                                                        value="{{ old('booking_url', $settings->review_site_2_url ?? '') }}"
                                                        placeholder="https://booking.com/hotel/your-hotel">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Daha fazla yorum sitesi eklemek isterseniz database'i güncelleyin -->
                                        <div class="col-md-6"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                        <i class='bx bx-x me-1'></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-success px-4">
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
</x-app-layout>
