<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-bar-chart-alt-2 me-2 text-primary'></i> {{ __('Doluluk Raporu') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class='bx bx-arrow-back me-1'></i> {{ __('Tüm Raporlar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Tarih Aralığı Seçimi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-calendar fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Tarih Aralığı Seçin</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('reports.occupancy') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label fw-bold">Başlangıç Tarihi</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $start_date ?? now()->subDays(30)->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label fw-bold">Bitiş Tarihi</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $end_date ?? now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class='bx bx-refresh me-1'></i> Raporu Güncelle
                                </button>
                            </div>
                        </div>
            <!-- Özet Bilgiler -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-line-chart fs-4 text-primary'></i>
                                </div>
                                <h6 class="card-subtitle text-muted mb-0">Ortalama Doluluk</h6>
                            </div>
                            <h2 class="display-6 fw-bold mb-0 text-primary">{{ $avgOccupancy ?? '65' }}%</h2>
                            <p class="card-text text-muted mt-2 small">Seçilen tarih aralığındaki ortalama doluluk oranı</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-trending-up fs-4 text-success'></i>
                                </div>
                                <h6 class="card-subtitle text-muted mb-0">En Yüksek Doluluk</h6>
                            </div>
                            <h2 class="display-6 fw-bold mb-0 text-success">{{ $maxOccupancy ?? '95' }}%</h2>
                            <p class="card-text text-muted mt-2 small">Seçilen tarih aralığındaki en yüksek doluluk oranı</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-md bg-danger-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-trending-down fs-4 text-danger'></i>
                                </div>
                                <h6 class="card-subtitle text-muted mb-0">En Düşük Doluluk</h6>
                            </div>
                            <h2 class="display-6 fw-bold mb-0 text-danger">{{ $minOccupancy ?? '35' }}%</h2>
                            <p class="card-text text-muted mt-2 small">Seçilen tarih aralığındaki en düşük doluluk oranı</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-line-chart fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Doluluk Oranı Grafiği</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 400px;">
                        <canvas id="occupancyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('occupancyChart').getContext('2d');

            // Varsayılan veriler (API'den veri gelmediğinde)
            const defaultDates = ['1 May', '2 May', '3 May', '4 May', '5 May', '6 May', '7 May', '8 May', '9 May', '10 May', '11 May', '12 May', '13 May', '14 May'];
            const defaultData = [45, 52, 68, 74, 83, 95, 92, 86, 75, 71, 68, 55, 61, 58];
            
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($dates ?? $defaultDates),
                    datasets: [{
                        label: 'Doluluk Oranı (%)',
                        data: @json($occupancyData ?? $defaultData),
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + '%';
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
