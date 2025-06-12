<?php
// Rapor sayfalarının ana dashboard sayfası
?>
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Raporlar ve İstatistikler') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row g-4">
                <!-- Doluluk Raporu Kartı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-lg bg-primary-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class='bx bx-bar-chart-alt-2 fs-2 text-primary'></i>
                            </div>
                            <h5 class="card-title">Doluluk Raporu</h5>
                            <p class="card-text text-muted">Belirli bir tarih aralığındaki oda doluluk oranlarını görüntüleyin.</p>
                            <a href="{{ route('reports.occupancy') }}" class="btn btn-primary mt-3 w-100">
                                <i class='bx bx-line-chart me-1'></i> Doluluk Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Gelir Raporu Kartı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-lg bg-success-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class='bx bx-money fs-2 text-success'></i>
                            </div>
                            <h5 class="card-title">Gelir Raporu</h5>
                            <p class="card-text text-muted">Belirli bir tarih aralığındaki toplam gelirleri ve gelir dağılımını görüntüleyin.</p>
                            <a href="{{ route('reports.revenue') }}" class="btn btn-success mt-3 w-100">
                                <i class='bx bx-trending-up me-1'></i> Gelir Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Müşteri İstatistikleri Kartı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-lg bg-info-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class='bx bx-user-voice fs-2 text-info'></i>
                            </div>
                            <h5 class="card-title">Müşteri İstatistikleri</h5>
                            <p class="card-text text-muted">En sık konaklayan müşterilerinizi ve müşteri eğilimlerini görüntüleyin.</p>
                            <a href="{{ route('reports.customers') }}" class="btn btn-info mt-3 w-100">
                                <i class='bx bx-group me-1'></i> Müşteri İstatistiklerini Görüntüle
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Temizlik Performansı Kartı -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="avatar avatar-lg bg-warning-subtle rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                                <i class='bx bx-broom fs-2 text-warning'></i>
                            </div>
                            <h5 class="card-title">Temizlik Performansı</h5>
                            <p class="card-text text-muted">Temizlik görevlilerinin performansını ve oda temizlik durumlarını görüntüleyin.</p>
                            <a href="{{ route('reports.cleaning') }}" class="btn btn-warning mt-3 w-100">
                                <i class='bx bx-check-square me-1'></i> Temizlik Raporunu Görüntüle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
