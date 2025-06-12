<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Raporlar ve İstatistikler') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Hoş Geldiniz Kartı -->
            <div class="card border-0 bg-primary bg-opacity-10 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bx bx-bar-chart-alt-2 text-primary fs-1"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 text-primary">Otel Performans Analizi</h4>
                                <p class="mb-0 text-muted">Bu bölümde otelinizin performansını analiz edebilir, çeşitli raporları görüntüleyebilir ve işletmenizin gelişimini takip edebilirsiniz.</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('reports.performance') }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bx bx-analyse me-1"></i> Performans Analizini Görüntüle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Doluluk Raporu -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-building-house fs-3 text-primary'></i>
                            </div>
                            <h5 class="card-title mb-2">Doluluk Raporu</h5>
                            <p class="card-text text-muted mb-4">Belirli bir tarih aralığındaki oda doluluk oranlarını görüntüleyin.</p>
                            <a href="{{ route('reports.occupancy') }}" class="btn btn-primary w-100">
                                <i class='bx bx-line-chart me-1'></i> Doluluk Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gelir Raporu -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3 bg-success-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-money fs-3 text-success'></i>
                            </div>
                            <h5 class="card-title mb-2">Gelir Raporu</h5>
                            <p class="card-text text-muted mb-4">Belirli bir tarih aralığındaki toplam gelirleri ve gelir dağılımını görüntüleyin.</p>
                            <a href="{{ route('reports.revenue') }}" class="btn btn-success w-100">
                                <i class='bx bx-trending-up me-1'></i> Gelir Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Müşteri İstatistikleri -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3 bg-info-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-user-voice fs-3 text-info'></i>
                            </div>
                            <h5 class="card-title mb-2">Müşteri İstatistikleri</h5>
                            <p class="card-text text-muted mb-4">En sık konaklayan müşterilerinizi ve müşteri eğilimlerini görüntüleyin.</p>
                            <a href="{{ route('reports.customers') }}" class="btn btn-info w-100">
                                <i class='bx bx-group me-1'></i> Müşteri İstatistiklerini Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Temizlik Performansı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-md mx-auto mb-3 bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <i class='bx bx-broom fs-3 text-warning'></i>
                            </div>
                            <h5 class="card-title mb-2">Temizlik Performansı</h5>
                            <p class="card-text text-muted mb-4">Temizlik görevlilerinin performansını ve oda temizlik durumlarını görüntüleyin.</p>
                            <a href="{{ route('reports.cleaning') }}" class="btn btn-warning w-100">
                                <i class='bx bx-chart me-1'></i> Temizlik Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grafik Özeti -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Hızlı Özet</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Aylık Doluluk Oranı</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-bold">75%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Aylık Gelir Hedefi</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-bold">82%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Müşteri Memnuniyeti</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-bold">88%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 mb-4">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Temizlik Performansı</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="fw-bold">92%</span>
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
    </div>
</x-app-layout>
