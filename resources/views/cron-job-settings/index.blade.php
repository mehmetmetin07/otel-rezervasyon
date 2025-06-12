<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold d-flex align-items-center">
                <i class='bx bx-time-five me-2 text-primary'></i> {{ __('Otomatik Rezervasyon Kontrolü') }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cron Job Ayarları</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Status Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class='bx bx-check-circle me-2'></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class='bx bx-error-circle me-2'></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Info Card -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body text-white p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white bg-opacity-20 rounded-circle p-3 me-4">
                                            <i class='bx bx-cog fs-1'></i>
                                        </div>
                                        <div>
                                            <h3 class="mb-2 fw-bold">Otomatik Rezervasyon Kontrolü</h3>
                                            <p class="mb-0 opacity-90">Günlük otomatik check-in ve check-out işlemleri için cron job yapılandırması</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <div class="d-flex flex-column align-items-md-end">
                                        <span class="badge bg-white text-primary fs-6 px-3 py-2 mb-2">
                                            <i class='bx bx-time me-1'></i>Son Çalışma: {{ $settings->last_run_at ? $settings->last_run_at->format('d.m.Y H:i') : 'Henüz çalışmadı' }}
                                        </span>
                                        @if($settings->cron_job_id)
                                            <span class="badge bg-success text-white fs-6 px-3 py-2">
                                                <i class='bx bx-check-circle me-1'></i>Aktif (ID: {{ $settings->cron_job_id }})
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                <i class='bx bx-clock me-1'></i>Kurulum Bekleniyor
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- How It Works -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class='bx bx-info-circle me-2'></i>Sistem Nasıl Çalışır?
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3 flex-shrink-0">
                                            <i class='bx bx-log-in-circle text-success fs-4'></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-success mb-2">Otomatik Check-in</h6>
                                            <ul class="text-muted mb-0">
                                                <li>Check-in tarihi geçen "confirmed" rezervasyonları bulur</li>
                                                <li>Statüleri otomatik "checked_in" yapar</li>
                                                <li>Müşterilere hoşgeldin e-postası gönderir</li>
                                                <li>Aktivite loglarına kaydeder</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3 flex-shrink-0">
                                            <i class='bx bx-log-out-circle text-warning fs-4'></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-warning mb-2">Otomatik Check-out</h6>
                                            <ul class="text-muted mb-0">
                                                <li>Check-out tarihi geçen "checked_in" rezervasyonları bulur</li>
                                                <li>Statüleri otomatik "checked_out" yapar</li>
                                                <li>Müşterilere hoşçakal e-postası gönderir</li>
                                                <li>Aktivite loglarına kaydeder</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info d-flex align-items-start mt-4" role="alert">
                                <i class='bx bx-bulb me-2 fs-5'></i>
                                <div>
                                    <h6 class="fw-bold mb-2">Kurulum Adımları</h6>
                                    <ol class="mb-0">
                                        <li><a href="https://cron-job.org" target="_blank" class="text-decoration-none">cron-job.org</a> sitesinde ücretsiz hesap oluşturun</li>
                                        <li>Hesap ayarlarından API Key alın</li>
                                        <li>Aşağıdaki formu doldurun ve kaydedin</li>
                                        <li>"Cron Job Oluştur" butonuna tıklayın</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Configuration Form -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-2 me-3">
                                    <i class='bx bx-key text-white'></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">API Yapılandırması</h6>
                                    <small class="text-muted">cron-job.org hesap bilgileri</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('cron-job-settings.update') }}">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label for="api_email" class="form-label fw-semibold">
                                        <i class="bx bx-envelope me-1"></i>Hesap E-posta <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control @error('api_email') is-invalid @enderror"
                                           id="api_email" name="api_email"
                                           value="{{ old('api_email', $settings->api_email) }}"
                                           placeholder="hesabiniz@email.com" required>
                                    @error('api_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="api_key" class="form-label fw-semibold">
                                        <i class="bx bx-lock me-1"></i>API Key <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('api_key') is-invalid @enderror"
                                               id="api_key" name="api_key"
                                               value="{{ old('api_key', $settings->api_key) }}"
                                               placeholder="API anahtarınız" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('api_key')">
                                            <i class='bx bx-show' id="api_key_icon"></i>
                                        </button>
                                    </div>
                                    @error('api_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bx bx-info-circle me-1"></i>
                                        <a href="https://cron-job.org/en/members/settings/" target="_blank">Hesap ayarlarından</a> alabilirsiniz
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="checkout_time" class="form-label fw-semibold">
                                        <i class="bx bx-time-five me-1"></i>Günlük Kontrol Saati <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" class="form-control @error('checkout_time') is-invalid @enderror"
                                           id="checkout_time" name="checkout_time"
                                           value="{{ old('checkout_time', $settings->checkout_time) }}" required>
                                    @error('checkout_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Her gün bu saatte otomatik kontrol yapılacak</div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-save me-2'></i>Ayarları Kaydet
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-success bg-opacity-10 border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success rounded-circle p-2 me-3">
                                    <i class='bx bx-cog text-white'></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">İşlemler</h6>
                                    <small class="text-muted">Cron job yönetimi</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-3">
                                <button onclick="createJob()" class="btn btn-success btn-lg">
                                    <i class='bx bx-plus-circle me-2'></i>Cron Job Oluştur
                                </button>

                                <button onclick="testConnection()" class="btn btn-info">
                                    <i class='bx bx-wifi me-2'></i>Bağlantıyı Test Et
                                </button>

                                <button onclick="testDailyCheck()" class="btn btn-warning">
                                    <i class='bx bx-test-tube me-2'></i>Test Günlük Kontrol
                                </button>

                                @if($settings->cron_job_id)
                                    <button onclick="updateJob()" class="btn btn-primary">
                                        <i class='bx bx-edit me-2'></i>Job'u Güncelle
                                    </button>

                                    <button onclick="deleteJob()" class="btn btn-outline-danger">
                                        <i class='bx bx-trash me-2'></i>Job'u Sil
                                    </button>
                                @endif
                            </div>

                            <!-- Current Status -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold mb-2">Mevcut Durum</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <div class="fw-bold text-primary">{{ $settings->webhook_url ? 'Aktif' : 'Pasif' }}</div>
                                            <small class="text-muted">Webhook</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="fw-bold text-{{ $settings->cron_job_id ? 'success' : 'warning' }}">
                                            {{ $settings->cron_job_id ? 'Oluşturuldu' : 'Bekleniyor' }}
                                        </div>
                                        <small class="text-muted">Cron Job</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class='bx bx-bar-chart me-2'></i>Sistem Durumu
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4 text-center">
                                <div class="col-md-3">
                                    <div class="card bg-primary bg-opacity-10 border-0">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <i class='bx bx-calendar-check text-primary fs-1'></i>
                                            </div>
                                            <h4 class="fw-bold text-primary mb-1">{{ \App\Models\Reservation::where('status', 'confirmed')->count() }}</h4>
                                            <small class="text-muted">Onaylı Rezervasyon</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success bg-opacity-10 border-0">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <i class='bx bx-log-in-circle text-success fs-1'></i>
                                            </div>
                                            <h4 class="fw-bold text-success mb-1">{{ \App\Models\Reservation::where('status', 'checked_in')->count() }}</h4>
                                            <small class="text-muted">Check-in Yapıldı</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning bg-opacity-10 border-0">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <i class='bx bx-log-out-circle text-warning fs-1'></i>
                                            </div>
                                            <h4 class="fw-bold text-warning mb-1">{{ \App\Models\Reservation::where('status', 'checked_out')->count() }}</h4>
                                            <small class="text-muted">Check-out Yapıldı</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info bg-opacity-10 border-0">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <i class='bx bx-time text-info fs-1'></i>
                                            </div>
                                            <h4 class="fw-bold text-info mb-1">{{ $settings->last_run_at ? $settings->last_run_at->diffForHumans() : 'Hiç' }}</h4>
                                            <small class="text-muted">Son Çalışma</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bx bx-hide';
            } else {
                field.type = 'password';
                icon.className = 'bx bx-show';
            }
        }

        function createJob() {
            if (confirm('Yeni cron job oluşturmak istediğinize emin misiniz?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cron-job-settings.create-job") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function updateJob() {
            if (confirm('Mevcut cron job\'u güncellemek istediğinize emin misiniz?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cron-job-settings.update-job") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteJob() {
            if (confirm('Cron job\'u silmek istediğinize emin misiniz? Bu işlem geri alınamaz.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("cron-job-settings.delete-job") }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function testConnection() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cron-job-settings.test-connection") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }

        function testDailyCheck() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cron-job-settings.test-daily-check") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-app-layout>
