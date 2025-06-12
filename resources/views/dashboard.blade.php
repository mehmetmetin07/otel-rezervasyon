<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gösterge Paneli') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isReceptionist()))
                <!-- Sistem Ayarları -->
                @if(Auth::user()->isAdmin())
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary"><i class='bx bxs-cog me-1'></i> Sistem Ayarları</h5>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                                    <i class='bx bxs-hotel text-primary fs-3'></i>
                                </div>
                                <h6 class="mb-2">Otel Ayarları</h6>
                                <p class="text-muted small mb-3">Otel bilgileri ve tanıtım metinleri</p>
                                <a href="{{ route('hotel-settings.index') }}" class="btn btn-primary btn-sm">
                                    <i class='bx bx-edit me-1'></i> Düzenle
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                                    <i class='bx bxs-envelope text-success fs-3'></i>
                                </div>
                                <h6 class="mb-2">Email Ayarları</h6>
                                <p class="text-muted small mb-3">Sosyal medya ve yorum sitesi linkleri</p>
                                <a href="{{ route('email-template-settings.index') }}" class="btn btn-success btn-sm">
                                    <i class='bx bx-edit me-1'></i> Düzenle
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                                    <i class='bx bxs-server text-info fs-3'></i>
                                </div>
                                <h6 class="mb-2">SMTP Ayarları</h6>
                                <p class="text-muted small mb-3">Mail sunucusu ve test ayarları</p>
                                <a href="{{ route('profile.edit') }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-edit me-1'></i> Düzenle
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3 mx-auto mb-3" style="width: 60px; height: 60px;">
                                    <i class='bx bxs-user-account text-warning fs-3'></i>
                                </div>
                                <h6 class="mb-2">Kullanıcılar</h6>
                                <p class="text-muted small mb-3">Sistem kullanıcıları yönetimi</p>
                                <a href="{{ route('users.index') }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit me-1'></i> Yönet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Oda Durumu Kartları -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary"><i class='bx bxs-dashboard me-1'></i> Otel Durumu</h5>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-building-house text-primary fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $totalRooms }}</h3>
                                    <p class="text-muted mb-0">Toplam Oda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-door-open text-success fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $availableRooms }}</h3>
                                    <p class="text-muted mb-0">Boş Oda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-hotel text-danger fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $occupiedRooms }}</h3>
                                    <p class="text-muted mb-0">Dolu Oda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-calendar-check text-warning fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $reservedRooms }}</h3>
                                    <p class="text-muted mb-0">Rezerve Oda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-spray-can text-info fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ $cleaningRooms }}</h3>
                                    <p class="text-muted mb-0">Temizlikte</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class='bx bxs-pie-chart-alt-2 text-primary fs-3'></i>
                                </div>
                                <div>
                                    <h3 class="mb-0 fw-bold">{{ number_format($occupancyRate, 1) }}%</h3>
                                    <p class="text-muted mb-0">Doluluk Oranı</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doluluk Oranı ve İstatistikler -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary"><i class='bx bxs-bar-chart-alt-2 me-1'></i> Doluluk ve İstatistikler</h5>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Aylık Doluluk Oranı</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartOptions" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartOptions">
                                        <li><a class="dropdown-item" href="#">Bu Ay</a></li>
                                        <li><a class="dropdown-item" href="#">Son 3 Ay</a></li>
                                        <li><a class="dropdown-item" href="#">Yıllık</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body" style="max-height: 300px; overflow: hidden;">
                                <canvas id="occupancyChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Bugünkü Durum</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <p class="mb-1 d-flex justify-content-between">
                                        <span class="text-muted">Doluluk Oranı</span>
                                        <span class="fw-bold">{{ number_format($occupancyRate, 1) }}%</span>
                                    </p>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $occupancyRate }}%" aria-valuenow="{{ $occupancyRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="mb-1 d-flex justify-content-between">
                                        <span class="text-muted">Bugünkü Check-in</span>
                                        <span class="fw-bold">{{ $checkInsToday->count() }}</span>
                                    </p>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($checkInsToday->count() * 10, 100) }}%" aria-valuenow="{{ $checkInsToday->count() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="mb-1 d-flex justify-content-between">
                                        <span class="text-muted">Bugünkü Check-out</span>
                                        <span class="fw-bold">{{ $checkOutsToday->count() }}</span>
                                    </p>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ min($checkOutsToday->count() * 10, 100) }}%" aria-valuenow="{{ $checkOutsToday->count() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div>
                                    <p class="mb-1 d-flex justify-content-between">
                                        <span class="text-muted">Temizlik Bekleyen</span>
                                        <span class="fw-bold">{{ $cleaningRooms }}</span>
                                    </p>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ min($cleaningRooms * 10, 100) }}%" aria-valuenow="{{ $cleaningRooms }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Günlük Check-in/Check-out -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary"><i class='bx bxs-calendar-check me-1'></i> Bugünkü İşlemler</h5>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <!-- Check-in -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class='bx bxs-log-in-circle text-success me-1'></i> Bugünkü Check-in
                                    <span class="badge bg-success ms-2">{{ $checkInsToday->count() }}</span>
                                </h5>
                                <a href="{{ route('reservations.index') }}?date={{ date('Y-m-d') }}&status=confirmed" class="btn btn-sm btn-outline-success">
                                    Tümünü Gör
                                </a>
                            </div>
                            <div class="card-body p-0">
                                @if($checkInsToday->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Oda</th>
                                                    <th>Müşteri</th>
                                                    <th>Durum</th>
                                                    <th class="text-end">İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($checkInsToday as $reservation)
                                                    <tr>
                                                        <td>
                                                            <span class="fw-bold">{{ $reservation->room->room_number }}</span>
                                                            <small class="d-block text-muted">{{ $reservation->room->roomType->name }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                    <i class='bx bxs-user text-primary'></i>
                                                                </div>
                                                                <div>
                                                                    {{ $reservation->customer->full_name }}
                                                                    <small class="d-block text-muted">{{ $reservation->customer->phone }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($reservation->status == 'pending')
                                                                <span class="badge bg-warning">Onay Bekliyor</span>
                                                            @elseif($reservation->status == 'confirmed')
                                                                <span class="badge bg-info">Onaylandı</span>
                                                            @elseif($reservation->status == 'checked_in')
                                                                <span class="badge bg-success">Check-in Yapıldı</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                                    <i class='bx bx-show'></i>
                                                                </a>

                                                                                                                @if($reservation->status == 'confirmed')
                                                    @php
                                                        $canCheckinToday = now()->startOfDay()->greaterThanOrEqualTo($reservation->check_in->startOfDay());
                                                    @endphp

                                                    @if($canCheckinToday)
                                                        <form action="{{ route('reservations.check-in', $reservation) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Manuel Check-in Yap">
                                                                <i class='bx bx-log-in'></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="btn btn-sm btn-outline-secondary disabled"
                                                              title="Check-in tarihi: {{ $reservation->check_in->format('d.m.Y') }} - Henüz gelmedi">
                                                            <i class="bx bx-clock"></i>
                                                        </span>
                                                    @endif
                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No Check-ins" class="img-fluid mb-3" style="max-width: 120px; opacity: 0.5;">
                                        <p class="text-muted">Bugün için check-in işlemi bulunmuyor.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Check-out -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class='bx bxs-log-out-circle text-warning me-1'></i> Bugünkü Check-out
                                    <span class="badge bg-warning ms-2">{{ $checkOutsToday->count() }}</span>
                                </h5>
                                <a href="{{ route('reservations.index') }}?date={{ date('Y-m-d') }}&status=checked_in" class="btn btn-sm btn-outline-warning">
                                    Tümünü Gör
                                </a>
                            </div>
                            <div class="card-body p-0">
                                @if($checkOutsToday->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Oda</th>
                                                    <th>Müşteri</th>
                                                    <th>Durum</th>
                                                    <th class="text-end">İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($checkOutsToday as $reservation)
                                                    <tr>
                                                        <td>
                                                            <span class="fw-bold">{{ $reservation->room->room_number }}</span>
                                                            <small class="d-block text-muted">{{ $reservation->room->roomType->name }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm bg-warning bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                    <i class='bx bxs-user text-warning'></i>
                                                                </div>
                                                                <div>
                                                                    {{ $reservation->customer->full_name }}
                                                                    <small class="d-block text-muted">{{ $reservation->customer->phone }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($reservation->status == 'checked_in')
                                                                <span class="badge bg-success">Check-in Yapıldı</span>
                                                            @elseif($reservation->status == 'checked_out')
                                                                <span class="badge bg-secondary">Check-out Yapıldı</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                                    <i class='bx bx-show'></i>
                                                                </a>

                                                                @if($reservation->status == 'checked_in')
                                                                <form action="{{ route('reservations.check-out', $reservation) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Check-out Yap">
                                                                        <i class='bx bx-log-out'></i>
                                                                    </button>
                                                                </form>
                                                                @endif
                                                                <a href="{{ route('reservations.invoice', $reservation) }}" class="btn btn-sm btn-outline-info" title="Fatura Oluştur">
                                                                    <i class='bx bx-receipt'></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134150.png" alt="No Check-outs" class="img-fluid mb-3" style="max-width: 120px; opacity: 0.5;">
                                        <p class="text-muted">Bugün için check-out işlemi bulunmuyor.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Temizlik Görevleri ve Yaklaşan Rezervasyonlar -->
                <div class="row g-3 mb-4">
                    <!-- Temizlik Görevleri -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class='bx bxs-spray-can text-success me-1'></i> Bugünkü Temizlik Görevleri
                                    <span class="badge bg-success ms-2">{{ $cleaningTasksToday->count() }}</span>
                                </h5>
                                <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-sm btn-outline-success">
                                    Tüm Görevler
                                </a>
                            </div>
                            <div class="card-body p-0">
                                @if($cleaningTasksToday->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Oda</th>
                                                    <th>Personel</th>
                                                    <th>Durum</th>
                                                    <th class="text-end">İşlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cleaningTasksToday as $task)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                    <i class='bx bxs-door text-primary'></i>
                                                                </div>
                                                                <div>
                                                                    <span class="fw-bold">{{ $task->room->room_number }}</span>
                                                                    <small class="d-block text-muted">{{ $task->room->roomType->name ?? 'Standart' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($task->user)
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm bg-info bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                        <i class='bx bxs-user text-info'></i>
                                                                    </div>
                                                                    <span>{{ $task->user->name }}</span>
                                                                </div>
                                                            @else
                                                                <span class="badge bg-secondary">Atanmadı</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($task->status == 'pending')
                                                                <span class="badge bg-warning">Bekliyor</span>
                                                            @elseif($task->status == 'in_progress')
                                                                <span class="badge bg-info">Devam Ediyor</span>
                                                            @elseif($task->status == 'completed')
                                                                <span class="badge bg-success">Tamamlandı</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                                    <i class='bx bx-show'></i>
                                                                </a>

                                                                @if($task->status == 'pending')
                                                                <form action="{{ route('cleaning-tasks.start', $task) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Başlat">
                                                                        <i class='bx bx-play'></i>
                                                                    </button>
                                                                </form>
                                                                @endif

                                                                @if($task->status == 'in_progress')
                                                                <form action="{{ route('cleaning-tasks.complete', $task) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Tamamla">
                                                                        <i class='bx bx-check'></i>
                                                                    </button>
                                                                </form>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="text-center p-4">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3588/3588614.png" alt="No Cleaning Tasks" class="img-fluid mb-3" style="max-width: 120px; opacity: 0.5;">
                                    <p class="text-muted">Bugün için temizlik görevi bulunmuyor.</p>
                                    <a href="{{ route('cleaning-tasks.create') }}" class="btn btn-sm btn-success mt-2">
                                        <i class='bx bx-plus me-1'></i> Yeni Görev Oluştur
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Yaklaşan Rezervasyonlar -->
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class='bx bxs-calendar-event text-primary me-1'></i> Yaklaşan Rezervasyonlar
                            </h5>
                            <a href="{{ route('reservations.index') }}?status=confirmed" class="btn btn-sm btn-outline-primary">
                                Tüm Rezervasyonlar
                            </a>
                        </div>
                        <div class="card-body p-0">
                            @if(isset($upcomingReservations) && $upcomingReservations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tarih</th>
                                                <th>Oda</th>
                                                <th>Müşteri</th>
                                                <th class="text-end">İşlem</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($upcomingReservations as $reservation)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold">{{ $reservation->check_in->format('d.m.Y') }}</span>
                                                            <small class="text-muted">{{ $reservation->check_in->diffForHumans() }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm bg-primary bg-opacity-10 rounded me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                <i class='bx bxs-hotel text-primary'></i>
                                                            </div>
                                                            <div>
                                                                <span class="fw-bold">{{ $reservation->room->room_number }}</span>
                                                                <small class="d-block text-muted">{{ $reservation->room->roomType->name ?? 'Standart' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm bg-info bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                <i class='bx bxs-user text-info'></i>
                                                            </div>
                                                            <div>
                                                                {{ $reservation->customer->full_name }}
                                                                <small class="d-block text-muted">{{ $reservation->customer->phone ?? 'Telefon yok' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex gap-1">
                                                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                                <i class='bx bx-show'></i>
                                                            </a>

                                                            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-outline-secondary" title="Düzenle">
                                                                <i class='bx bx-edit'></i>
                                                            </a>

                                                            @if($reservation->status == 'pending')
                                                            <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-outline-success" title="Onayla">
                                                                    <i class='bx bx-check'></i>
                                                                </button>
                                                            </form>
                                                            @endif

                                                                                                        @if($reservation->status == 'confirmed')
                                                @php
                                                    $canCheckinToday = now()->startOfDay()->greaterThanOrEqualTo($reservation->check_in->startOfDay());
                                                @endphp

                                                @if($canCheckinToday)
                                                    <form action="{{ route('reservations.check-in', $reservation) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-info" title="Manuel Check-in Yap">
                                                            <i class='bx bx-log-in'></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="btn btn-sm btn-outline-secondary disabled"
                                                          title="Check-in tarihi: {{ $reservation->check_in->format('d.m.Y') }} - Henüz gelmedi">
                                                        <i class="bx bx-clock"></i>
                                                    </span>
                                                @endif
                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center p-4">
                                    <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No Reservations" class="img-fluid mb-3" style="max-width: 120px; opacity: 0.5;">
                                    <p class="text-muted">Yaklaşan rezervasyon bulunmuyor.</p>
                                    <a href="{{ route('reservations.create') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class='bx bx-plus me-1'></i> Yeni Rezervasyon Oluştur
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->isCleaner())
                <!-- Temizlik Görevlisi Dashboard -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">
                            <i class='bx bx-user-circle me-1'></i> Hoş Geldiniz, {{ Auth::user()->name }}
                        </h5>
                        <p class="text-muted mb-4">Bugünkü temizlik görevlerinizi buradan takip edebilirsiniz.</p>
                    </div>
                </div>

                <!-- Görev İstatistikleri -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-warning bg-opacity-10 border-warning">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class='bx bx-time-five text-warning fs-1'></i>
                                </div>
                                <h4 class="fw-bold text-warning mb-1">{{ $pendingTasks->count() ?? 0 }}</h4>
                                <p class="text-muted mb-0 small">Bekleyen Görev</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class='bx bx-loader-alt text-info fs-1'></i>
                                </div>
                                <h4 class="fw-bold text-info mb-1">{{ $inProgressTasks->count() ?? 0 }}</h4>
                                <p class="text-muted mb-0 small">Devam Eden</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class='bx bx-check-circle text-success fs-1'></i>
                                </div>
                                <h4 class="fw-bold text-success mb-1">{{ $completedTasks->count() ?? 0 }}</h4>
                                <p class="text-muted mb-0 small">Tamamlanan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class='bx bx-calendar text-primary fs-1'></i>
                                </div>
                                <h4 class="fw-bold text-primary mb-1">{{ now()->format('d') }}</h4>
                                <p class="text-muted mb-0 small">{{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Bekleyen Görevler -->
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3">
                                            <i class='bx bx-time-five text-warning fs-4'></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-0">Bekleyen Görevlerim</h5>
                                            <small class="text-muted">Henüz başlamadığınız görevler</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning rounded-pill">{{ $pendingTasks->count() ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                            @if(isset($pendingTasks) && $pendingTasks->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($pendingTasks as $task)
                                            <div class="list-group-item border-0 px-4 py-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-light p-2 me-3">
                                                            <i class='bx bxs-door-open text-primary'></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Oda {{ $task->room->room_number }}</h6>
                                                            <small class="text-muted">
                                                                <i class='bx bx-time me-1'></i>
                                                                {{ $task->scheduled_at->format('d.m.Y H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-warning text-dark me-2">Bekliyor</span>
                                                        <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class='bx bx-show'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                            @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class='bx bx-check-circle text-success fs-1'></i>
                                        </div>
                                        <h6 class="text-muted">Bekleyen görev bulunmuyor</h6>
                                        <p class="text-muted small mb-0">Tüm görevlerinizi tamamladınız!</p>
                                    </div>
                                @endif
                            </div>
                            @if(isset($pendingTasks) && $pendingTasks->count() > 0)
                                <div class="card-footer bg-light border-top-0">
                                    <div class="text-center">
                                        <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-sm btn-warning">
                                            <i class='bx bx-list-ul me-1'></i> Tüm Bekleyen Görevleri Gör
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bugün Tamamlanan Görevler -->
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                            <i class='bx bx-check-circle text-success fs-4'></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-0">Bugün Tamamlanan Görevlerim</h5>
                                            <small class="text-muted">Bugün tamamladığınız görevler</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill">{{ $completedTasks->count() ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                            @if(isset($completedTasks) && $completedTasks->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($completedTasks as $task)
                                            <div class="list-group-item border-0 px-4 py-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3">
                                                            <i class='bx bx-check text-success'></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Oda {{ $task->room->room_number }}</h6>
                                                            <small class="text-muted">
                                                                <i class='bx bx-check me-1'></i>
                                                                {{ $task->completed_at ? $task->completed_at->format('d.m.Y H:i') : 'Tamamlandı' }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-success me-2">Tamamlandı</span>
                                                        <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-outline-success">
                                                            <i class='bx bx-show'></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                            @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class='bx bx-calendar-x text-muted fs-1'></i>
                                        </div>
                                        <h6 class="text-muted">Bugün tamamlanan görev bulunmuyor</h6>
                                        <p class="text-muted small mb-0">Henüz hiçbir görevi tamamlamadınız.</p>
                                    </div>
                                @endif
                            </div>
                            @if(isset($completedTasks) && $completedTasks->count() > 0)
                                <div class="card-footer bg-light border-top-0">
                                    <div class="text-center">
                                        <a href="{{ route('cleaning-tasks.index') }}?status=completed" class="btn btn-sm btn-success">
                                            <i class='bx bx-history me-1'></i> Tüm Tamamlanan Görevleri Gör
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif(Auth::check() && Auth::user()->isCleaner())
                <!-- Temizlik görevlisi dashboard içeriği -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Temizlik Görevleri</h5>
                    </div>
                    <div class="card-body">
                        <p>Temizlik görevlisi paneline hoş geldiniz.</p>
                        @if(isset($pendingTasks) && count($pendingTasks) > 0)
                            <h6 class="mb-3">Bekleyen Görevler</h6>
                            <ul class="list-group mb-4">
                                @foreach($pendingTasks as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Oda {{ $task->room->room_number }}
                                        <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-primary">Görüntüle</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Bekleyen temizlik göreviniz bulunmuyor.</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <h3 class="mb-4">{{ __("Otel Rezervasyon Sistemine Hoş Geldiniz!") }}</h3>
                        <p class="text-muted mb-4">Sisteme erişim için yetkilendirme gerekiyor. Lütfen sistem yöneticisiyle iletişime geçin.</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-secondary">
                                <i class='bx bx-log-out me-2'></i> {{ __('Çıkış Yap') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Doluluk oranı grafiği
            const ctx = document.getElementById('occupancyChart');
            if (!ctx) return; // Canvas bulunamazsa işlemi durdur

            // Canvas yüksekliğini sınırla
            ctx.parentElement.style.maxHeight = '300px';

            // Son 30 günün tarihlerini oluştur
            const labels = [];
            const currentDate = new Date();
            for (let i = 14; i >= 0; i--) { // 30 gün yerine 15 gün göster
                const date = new Date();
                date.setDate(currentDate.getDate() - i);
                labels.push(date.getDate() + '/' + (date.getMonth() + 1));
            }

            // Örnek veri - gerçek projede veritabanından gelecek
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Doluluk Oranı (%)',
                    data: [65, 68, 70, 72, 75, 78, 80, 82, 85, 87, 85, 83, 80, 78, 75],
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
                    maintainAspectRatio: false, // Grafiğin container'a göre boyutlanması için false yapıyoruz
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
