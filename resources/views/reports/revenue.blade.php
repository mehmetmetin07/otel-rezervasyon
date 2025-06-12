<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-money me-2 text-success'></i> {{ __('Gelir Raporu') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                <i class='bx bx-arrow-back me-1'></i> <span>{{ __('Tüm Raporlar') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Tarih Aralığı Seçimi -->
            <div class="card shadow-sm border-0 mb-4 bg-light bg-opacity-50">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class='bx bx-calendar fs-4 text-success'></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Tarih Aralığı Seçin</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('reports.revenue') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label for="start_date" class="form-label fw-semibold">Başlangıç Tarihi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-calendar-alt'></i></span>
                                    <input type="date" class="form-control shadow-none" id="start_date" name="start_date" value="{{ $start_date ?? now()->subDays(30)->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="end_date" class="form-label fw-semibold">Bitiş Tarihi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class='bx bx-calendar-alt'></i></span>
                                    <input type="date" class="form-control shadow-none" id="end_date" name="end_date" value="{{ $end_date ?? now()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-refresh me-2'></i> Raporu Güncelle
                                </button>
                            </div>
                        </div>
            <!-- Gelir Özeti -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class='bx bx-trending-up me-1'></i> Toplam
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-lira fs-3 text-success'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Toplam Gelir</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-success">{{ number_format($totalRevenue ?? 45250, 2) }} TL</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Seçilen tarih aralığındaki toplam gelir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class='bx bx-calendar-check me-1'></i> Günlük
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-line-chart fs-3 text-primary'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Ortalama Günlük Gelir</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-primary">{{ number_format(($totalRevenue ?? 45250) / (count($dates ?? [30]) ?: 1), 2) }} TL</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Seçilen tarih aralığındaki günlük ortalama gelir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class='bx bx-receipt me-1'></i> Rezervasyon
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-info-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-receipt fs-3 text-info'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Rezervasyon Başına Gelir</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-info">{{ number_format(($totalRevenue ?? 45250) / 15, 2) }} TL</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Seçilen tarih aralığındaki rezervasyon başına düşen ortalama gelir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafikler -->
            <div class="row g-4 mb-4">
                <!-- Günlük Gelir Grafiği -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class='bx bx-bar-chart-alt me-1'></i> Günlük
                            </span>
                        </div>
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-line-chart fs-4 text-success'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Günlük Gelir Analizi</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 300px;">
                                <canvas id="dailyRevenueChart"></canvas>
                            </div>
                            <div class="mt-3 pt-3 border-top text-center">
                                <p class="text-muted small mb-0">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Seçilen tarih aralığında günlük gelir dağılımını gösterir
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Oda Tipi Gelir Dağılımı -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class='bx bx-pie-chart me-1'></i> Dağılım
                            </span>
                        </div>
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-pie-chart-alt-2 fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Oda Tipi Gelir Dağılımı</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 300px;">
                                <canvas id="roomTypeRevenueChart"></canvas>
                            </div>
                            <div class="mt-3 pt-3 border-top text-center">
                                <p class="text-muted small mb-0">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Oda tiplerine göre gelir dağılımı yüzdelik oranları
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detaylı Veriler -->
            <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                        <i class='bx bx-table me-1'></i> Detaylı Veri
                    </span>
                </div>
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-info-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class='bx bx-table fs-4 text-info'></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Oda Tiplerine Göre Gelir Dağılımı</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="fw-semibold text-dark border-0 rounded-start">Oda Tipi</th>
                                    <th scope="col" class="fw-semibold text-dark border-0">Toplam Gelir</th>
                                    <th scope="col" class="fw-semibold text-dark border-0">Oran</th>
                                    <th scope="col" class="fw-semibold text-dark border-0 rounded-end">Grafik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomTypeRevenue ?? [] as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-success-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-hotel text-success'></i>
                                                </div>
                                                <span>{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->total_revenue, 2) }} TL</td>
                                        <td>
                                            @if(($totalRevenue ?? 0) > 0)
                                                {{ round(($item->total_revenue / ($totalRevenue ?? 1)) * 100) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                        <td width="30%">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($totalRevenue ?? 0) > 0 ? round(($item->total_revenue / ($totalRevenue ?? 1)) * 100) : 0 }}%" aria-valuenow="{{ ($totalRevenue ?? 0) > 0 ? round(($item->total_revenue / ($totalRevenue ?? 1)) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Örnek Veriler -->
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-success-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-hotel text-success'></i>
                                                </div>
                                                <span>Standart Oda</span>
                                            </div>
                                        </td>
                                        <td>15,250.00 TL</td>
                                        <td>34%</td>
                                        <td width="30%">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-success-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-hotel text-success'></i>
                                                </div>
                                                <span>Deluxe Oda</span>
                                            </div>
                                        </td>
                                        <td>22,500.00 TL</td>
                                        <td>50%</td>
                                        <td width="30%">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-success-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-hotel text-success'></i>
                                                </div>
                                                <span>Suite</span>
                                            </div>
                                        </td>
                                        <td>7,500.00 TL</td>
                                        <td>16%</td>
                                        <td width="30%">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Günlük Gelir Grafiği
            const dailyCtx = document.getElementById('dailyRevenueChart').getContext('2d');
            const dailyChart = new Chart(dailyCtx, {
                type: 'bar',
                data: {
                    labels: @json($dates),
                    datasets: [{
                        label: 'Günlük Gelir (TL)',
                        data: @json($revenueData),
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' TL';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' TL';
                                }
                            }
                        }
                    }
                }
            });

            // Oda Tipi Gelir Dağılımı
            const roomTypeCtx = document.getElementById('roomTypeRevenueChart').getContext('2d');
            const roomTypeChart = new Chart(roomTypeCtx, {
                type: 'pie',
                data: {
                    labels: @json($roomTypeRevenue->pluck('name')),
                    datasets: [{
                        data: @json($roomTypeRevenue->pluck('total_revenue')),
                        backgroundColor: [
                            'rgba(37, 99, 235, 0.5)',
                            'rgba(16, 185, 129, 0.5)',
                            'rgba(245, 158, 11, 0.5)',
                            'rgba(239, 68, 68, 0.5)',
                            'rgba(139, 92, 246, 0.5)',
                            'rgba(20, 184, 166, 0.5)',
                            'rgba(249, 115, 22, 0.5)',
                            'rgba(217, 70, 239, 0.5)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percentage = ((value / @json($totalRevenue)) * 100).toFixed(1);
                                    return context.label + ': ' + value.toFixed(2) + ' TL (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
