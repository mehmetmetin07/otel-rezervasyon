<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-user-voice me-2 text-primary'></i> {{ __('Müşteri İstatistikleri') }}
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
                <!-- Toplam Müşteri -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class='bx bx-group me-1'></i> Toplam
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-user-circle fs-3 text-primary'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Toplam Müşteri Sayısı</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-primary">{{ $totalCustomers }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Sistemde kayıtlı toplam müşteri sayısı
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Aylık Yeni Müşteri -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class='bx bx-user-plus me-1'></i> Yeni
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-user-plus fs-3 text-success'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">Bu Ay Yeni Müşteriler</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-success">{{ end($newCustomerData) }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    İçinde bulunduğumuz ayda kaydolan yeni müşteri sayısı
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- En Çok Rezervasyon -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                <i class='bx bx-medal me-1'></i> En Çok
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-info-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-star fs-3 text-info'></i>
                                </div>
                                <div>
                                    <h6 class="card-subtitle text-muted mb-1">En Çok Rezervasyon</h6>
                                    <h2 class="display-6 fw-bold mb-0 text-info">{{ $topCustomers->first()->reservations_count ?? 0 }}</h2>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-top">
                                <p class="card-text text-muted mb-0 d-flex align-items-center">
                                    <i class='bx bx-info-circle me-1'></i>
                                    En çok rezervasyon yapan müşterinin rezervasyon sayısı
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafikler -->
            <div class="row g-4 mb-4">
                <!-- Yeni Müşteri Grafiği -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class='bx bx-line-chart me-1'></i> Aylık Trend
                            </span>
                        </div>
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-line-chart fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Son 12 Ayda Yeni Müşteriler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 300px;">
                                <canvas id="newCustomersChart"></canvas>
                            </div>
                            <div class="mt-3 pt-3 border-top text-center">
                                <p class="text-muted small mb-0">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Son 12 ayda sisteme kaydolan yeni müşteri sayıları
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Müşteriler -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                <i class='bx bx-bar-chart me-1'></i> Sıralama
                            </span>
                        </div>
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-success-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-bar-chart-alt-2 fs-4 text-success'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">En Çok Rezervasyon Yapan Müşteriler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="height: 300px;">
                                <canvas id="topCustomersChart"></canvas>
                            </div>
                            <div class="mt-3 pt-3 border-top text-center">
                                <p class="text-muted small mb-0">
                                    <i class='bx bx-info-circle me-1'></i>
                                    Rezervasyon sayısına göre en çok konaklayan müşteriler
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
                        <i class='bx bx-table me-1'></i> Detaylı Liste
                    </span>
                </div>
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-info-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class='bx bx-list-ul fs-4 text-info'></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">En Çok Konaklayan Müşteriler</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="fw-semibold text-dark border-0 rounded-start">Müşteri</th>
                                    <th scope="col" class="fw-semibold text-dark border-0">İletişim</th>
                                    <th scope="col" class="fw-semibold text-dark border-0">Rezervasyon Sayısı</th>
                                    <th scope="col" class="fw-semibold text-dark border-0 rounded-end">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-user text-primary'></i>
                                                </div>
                                                <span>{{ $customer->full_name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                {{ $customer->reservations_count }} Rezervasyon
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class='bx bx-show me-1'></i> Görüntüle
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
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
            // Yeni Müşteri Grafiği
            const newCustomersCtx = document.getElementById('newCustomersChart').getContext('2d');
            const newCustomersChart = new Chart(newCustomersCtx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Yeni Müşteri Sayısı',
                        data: @json($newCustomerData),
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
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
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Top Müşteriler Grafiği
            const topCustomersCtx = document.getElementById('topCustomersChart').getContext('2d');
            const topCustomersChart = new Chart(topCustomersCtx, {
                type: 'bar',
                data: {
                    labels: @json($topCustomers->pluck('full_name')),
                    datasets: [{
                        label: 'Rezervasyon Sayısı',
                        data: @json($topCustomers->pluck('reservations_count')),
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderColor: 'rgba(245, 158, 11, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
