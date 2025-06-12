<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Otel Performans Analizi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Hoş Geldiniz Kartı -->
            <div class="card border-0 bg-primary bg-opacity-10 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bx bx-bar-chart-alt-2 text-primary fs-1"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 text-primary">Otel Performans Analizi</h4>
                            <p class="mb-0 text-muted">Bu bölümde otelinizin performansını analiz edebilir, çeşitli raporları görüntüleyebilir ve işletmenizin gelişimini takip edebilirsiniz.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rapor Kartları -->
            <div class="row g-4 mb-5">
                <!-- Doluluk Raporu -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-300">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-primary-subtle rounded-3 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-building-house text-primary fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Doluluk Raporu</h5>
                            </div>
                            <p class="card-text text-muted mb-4">Belirli bir tarih aralığındaki oda doluluk oranlarını görüntüleyin.</p>
                            <div class="d-grid">
                                <a href="{{ route('reports.occupancy') }}" class="btn btn-primary btn-sm rounded-pill">
                                    <i class="bx bx-show me-1"></i> Doluluk Raporunu Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gelir Raporu -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-300">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-success-subtle rounded-3 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-money text-success fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Gelir Raporu</h5>
                            </div>
                            <p class="card-text text-muted mb-4">Belirli bir tarih aralığındaki toplam gelirleri ve gelir dağılımını görüntüleyin.</p>
                            <div class="d-grid">
                                <a href="{{ route('reports.revenue') }}" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bx bx-show me-1"></i> Gelir Raporunu Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Müşteri İstatistikleri -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-300">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-info-subtle rounded-3 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-user-voice text-info fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Müşteri İstatistikleri</h5>
                            </div>
                            <p class="card-text text-muted mb-4">En sık konaklayan müşterilerinizi ve müşteri eğilimlerini görüntüleyin.</p>
                            <div class="d-grid">
                                <a href="{{ route('reports.customers') }}" class="btn btn-info btn-sm rounded-pill">
                                    <i class="bx bx-show me-1"></i> Müşteri İstatistiklerini Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Temizlik Performansı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-300">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-warning-subtle rounded-3 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-broom text-warning fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0">Temizlik Performansı</h5>
                            </div>
                            <p class="card-text text-muted mb-4">Temizlik görevlilerinin performansını ve oda temizlik durumlarını görüntüleyin.</p>
                            <div class="d-grid">
                                <a href="{{ route('reports.cleaning') }}" class="btn btn-warning btn-sm rounded-pill">
                                    <i class="bx bx-show me-1"></i> Temizlik Raporunu Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hızlı Özet -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-line-chart text-primary fs-4 me-2"></i>
                        <h5 class="mb-0">Hızlı Özet</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Aylık Doluluk Oranı -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">Aylık Doluluk Oranı</h6>
                                        <small class="text-muted">Son 30 günün ortalama doluluk oranı</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">75%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Aylık Gelir Hedefi -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">Aylık Gelir Hedefi</h6>
                                        <small class="text-muted">Bu ayki gelir hedefine ulaşma oranı</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6">82%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Müşteri Memnuniyeti -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">Müşteri Memnuniyeti</h6>
                                        <small class="text-muted">Son 30 günün ortalama müşteri puanı</small>
                                    </div>
                                    <span class="badge bg-info rounded-pill px-3 py-2 fs-6">88%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 88%;" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Temizlik Performansı -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">Temizlik Performansı</h6>
                                        <small class="text-muted">Zamanında tamamlanan temizlik görevleri</small>
                                    </div>
                                    <span class="badge bg-warning rounded-pill px-3 py-2 fs-6">92%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aylık Performans Grafiği -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-trending-up text-primary fs-4 me-2"></i>
                        <h5 class="mb-0">Aylık Performans Grafiği</h5>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active">Doluluk</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">Gelir</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">Memnuniyet</button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="performanceChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
        .transition-300 {
            transition: all 0.3s ease;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Performans grafiği
            const ctx = document.getElementById('performanceChart').getContext('2d');
            
            // Son 12 ayın etiketleri
            const months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
            const currentMonth = new Date().getMonth();
            const labels = [];
            
            for (let i = 11; i >= 0; i--) {
                const monthIndex = (currentMonth - i + 12) % 12;
                labels.push(months[monthIndex]);
            }
            
            // Örnek veri - gerçek projede veritabanından gelecek
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Doluluk Oranı (%)',
                    data: [65, 68, 70, 72, 75, 78, 80, 82, 85, 87, 85, 75],
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            };
            
            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            };
            
            new Chart(ctx, config);
        });
    </script>
    @endpush
</x-app-layout>
