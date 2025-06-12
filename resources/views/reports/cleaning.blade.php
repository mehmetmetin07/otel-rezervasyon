<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-spray-can me-2 text-warning'></i> {{ __('Temizlik İstatistikleri') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                <i class='bx bx-arrow-back me-1'></i> <span>{{ __('Tüm Raporlar') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Özet Kartlar -->
            <div class="row g-4 mb-4">
                <!-- Temizlik Görevleri Durumu -->
                @php
                    $pendingTasks = $cleaningStats->where('status', 'pending')->first();
                    $inProgressTasks = $cleaningStats->where('status', 'in_progress')->first();
                    $completedTasks = $cleaningStats->where('status', 'completed')->first();
                    
                    $completedTasksAvg = $cleaningStats->where('status', 'completed')->first();
                    $avgMinutes = $completedTasksAvg ? round($completedTasksAvg->avg_duration) : 0;
                    $hours = floor($avgMinutes / 60);
                    $minutes = $avgMinutes % 60;
                @endphp
                
                <!-- Bekleyen Görevler -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                <i class='bx bx-time me-1'></i> Bekleyen
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-warning-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-time-five fs-3 text-warning'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Bekleyen Görevler</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-warning">{{ $pendingTasks ? $pendingTasks->total : 0 }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Son 30 gündeki bekleyen temizlik görevleri
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Devam Eden Görevler -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class='bx bx-loader-circle me-1'></i> Devam Eden
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-loader fs-3 text-primary'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Devam Eden Görevler</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-primary">{{ $inProgressTasks ? $inProgressTasks->total : 0 }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Son 30 gündeki devam eden temizlik görevleri
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tamamlanan Görevler -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class='bx bx-check-circle me-1'></i> Tamamlanan
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-check-double fs-3 text-success'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Tamamlanan Görevler</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-success">{{ $completedTasks ? $completedTasks->total : 0 }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Son 30 gündeki tamamlanan temizlik görevleri
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ortalama Temizlik Süresi -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class='bx bx-time-five me-1'></i> Ortalama
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-info-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-stopwatch fs-3 text-info'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Ortalama Temizlik Süresi</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-info">
                                        @if($hours > 0)
                                            {{ $hours }}s {{ $minutes }}dk
                                        @else
                                            {{ $minutes }}dk
                                        @endif
                                    </h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Tamamlanan görevlerin ortalama süresi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personel Performans -->
            <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 mt-2 me-2">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                        <i class='bx bx-bar-chart me-1'></i> Performans
                    </span>
                </div>
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class='bx bx-user-check fs-4 text-primary'></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Personel Performansı (Son 30 Gün)</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($cleanerPerformance->count() > 0)
                        <div style="height: 300px;" class="mb-4">
                            <canvas id="cleanerPerformanceChart"></canvas>
                        </div>
                        <div class="mt-3 pt-3 border-top text-center mb-4">
                            <p class="text-muted small mb-0">
                                <i class='bx bx-info-circle me-1'></i>
                                Personelin tamamladığı görev sayısı ve ortalama tamamlama süresi karşılaştırması
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="fw-semibold text-dark border-0 rounded-start">Personel</th>
                                        <th scope="col" class="fw-semibold text-dark border-0">Tamamlanan Görev</th>
                                        <th scope="col" class="fw-semibold text-dark border-0 rounded-end">Ortalama Süre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cleanerPerformance as $performance)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                        <i class='bx bx-user text-primary'></i>
                                                    </div>
                                                    <span>{{ $performance->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                    {{ $performance->tasks_completed }} Görev
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $avgMinutes = round($performance->avg_duration);
                                                    $hours = floor($avgMinutes / 60);
                                                    $minutes = $avgMinutes % 60;
                                                @endphp
                                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                                    @if($hours > 0)
                                                        {{ $hours }} saat {{ $minutes }} dakika
                                                    @else
                                                        {{ $minutes }} dakika
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-info-circle me-2 fs-4'></i>
                                <p class="mb-0">Henüz performans verisi bulunmuyor.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($cleanerPerformance->count() > 0)
                // Personel Performans Grafiği
                const cleanerCtx = document.getElementById('cleanerPerformanceChart').getContext('2d');
                const cleanerChart = new Chart(cleanerCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($cleanerPerformance->pluck('user.name')),
                        datasets: [
                            {
                                label: 'Tamamlanan Görev Sayısı',
                                data: @json($cleanerPerformance->pluck('tasks_completed')),
                                backgroundColor: 'rgba(13, 110, 253, 0.6)',
                                borderColor: 'rgba(13, 110, 253, 1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Ortalama Süre (Dakika)',
                                data: @json($cleanerPerformance->pluck('avg_duration')),
                                backgroundColor: 'rgba(25, 135, 84, 0.6)',
                                borderColor: 'rgba(25, 135, 84, 1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#212529',
                                bodyColor: '#212529',
                                borderColor: '#e9ecef',
                                borderWidth: 1,
                                padding: 12,
                                boxPadding: 6,
                                usePointStyle: true,
                                callbacks: {
                                    labelPointStyle: function(context) {
                                        return {
                                            pointStyle: 'rectRounded',
                                            rotation: 0
                                        };
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6c757d',
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Görev Sayısı',
                                    color: '#0d6efd',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                },
                                ticks: {
                                    precision: 0,
                                    color: '#6c757d',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    borderDash: [2, 2]
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                type: 'linear',
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Dakika',
                                    color: '#198754',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                },
                                ticks: {
                                    color: '#6c757d',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    drawOnChartArea: false,
                                    borderDash: [2, 2]
                                }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
    @endpush
</x-app-layout>
