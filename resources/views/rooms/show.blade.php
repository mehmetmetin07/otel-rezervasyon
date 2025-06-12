<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Oda Detayları') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-hotel fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Oda {{ $room->room_number }}</h5>
                            </div>
                            <div>
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                    <i class="bx bx-edit me-1"></i> Düzenle
                                </a>
                                <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="bx bx-arrow-back me-1"></i> Listeye Dön
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Oda Bilgileri -->
                <div class="col-lg-8">
                    <div class="row g-4">
                        <!-- Temel Bilgiler -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-info-circle fs-4 me-2 text-primary"></i>
                                        <h5 class="mb-0">Temel Bilgiler</h5>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Oda Numarası</h6>
                                        <p class="mb-0 fs-5 fw-bold">{{ $room->room_number }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Kat</h6>
                                        <p class="mb-0 fs-5">{{ $room->floor }}. Kat</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Oda Tipi</h6>
                                        <p class="mb-0 fs-5">{{ $room->roomType->name }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Durum</h6>
                                        <p class="mb-0">
                                            @switch($room->status)
                                                @case('available')
                                                    <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i> Boş</span>
                                                    @break
                                                @case('occupied')
                                                    <span class="badge bg-danger"><i class="bx bx-user me-1"></i> Dolu</span>
                                                    @break
                                                @case('reserved')
                                                    <span class="badge bg-primary"><i class="bx bx-calendar-check me-1"></i> Rezerve</span>
                                                    @break
                                                @case('cleaning')
                                                    <span class="badge bg-warning text-dark"><i class="bx bx-broom me-1"></i> Temizleniyor</span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="badge bg-secondary"><i class="bx bx-wrench me-1"></i> Bakımda</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $room->status }}</span>
                                            @endswitch
                                        </p>
                                    </div>

                                    @if($room->description)
                                        <div class="mt-4">
                                            <h6 class="text-muted mb-2">Açıklama</h6>
                                            <p class="mb-0">{{ $room->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Fiyat Bilgileri -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-money fs-4 me-2 text-primary"></i>
                                        <h5 class="mb-0">Fiyat Bilgileri</h5>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Temel Fiyat</h6>
                                        <p class="mb-0 fs-5">{{ number_format($room->roomType->base_price, 2) }} <small class="text-muted">TL</small></p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Fiyat Ayarlaması</h6>
                                        <p class="mb-0 fs-5">
                                            @if($room->price_adjustment > 0)
                                                <span class="text-success">+{{ number_format($room->price_adjustment, 2) }} <small class="text-muted">TL</small></span>
                                            @elseif($room->price_adjustment < 0)
                                                <span class="text-danger">{{ number_format($room->price_adjustment, 2) }} <small class="text-muted">TL</small></span>
                                            @else
                                                <span>{{ number_format($room->price_adjustment, 2) }} <small class="text-muted">TL</small></span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Toplam Fiyat</h6>
                                        <p class="mb-0 fs-4 fw-bold text-primary">{{ number_format($room->total_price, 2) }} <small>TL</small></p>
                                    </div>

                                    <div class="alert alert-info mt-4 mb-0">
                                        <div class="d-flex">
                                            <i class="bx bx-info-circle fs-4 me-2"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1">Fiyat Bilgisi</h6>
                                                <p class="mb-0 small">Fiyatlar gecelik konaklama içindir ve KDV dahildir. Rezervasyon süresine göre toplam fiyat değişiklik gösterebilir.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Oda Özellikleri -->
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-list-check fs-4 me-2 text-primary"></i>
                                        <h5 class="mb-0">Oda Özellikleri</h5>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        @foreach(explode(',', $room->roomType->features) as $feature)
                                            @if(trim($feature))
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bx bx-check-circle text-success me-2"></i>
                                                        <span>{{ trim($feature) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İşlemler -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-cog fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Durum Yönetimi</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('rooms.update-status', $room) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label for="status" class="form-label">Yeni Durum</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Boş</option>
                                        <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Dolu</option>
                                        <option value="reserved" {{ $room->status == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                                        <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>Temizleniyor</option>
                                        <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                    </select>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-refresh me-2"></i> Durumu Güncelle
                                    </button>
                                </div>
                            </form>

                            <div class="d-grid gap-2 mt-4">
                                @if($room->status == 'available')
                                    <a href="{{ route('cleaning-tasks.create', ['room_id' => $room->id]) }}" class="btn btn-warning d-flex align-items-center justify-content-center">
                                        <i class="bx bx-broom me-2 fs-5"></i> Temizlik Görevi Oluştur
                                    </a>
                                @endif

                                <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn btn-success d-flex align-items-center justify-content-center">
                                    <i class="bx bx-calendar-plus me-2 fs-5"></i> Yeni Rezervasyon Oluştur
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-link fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Hızlı Bağlantılar</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('rooms.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bx bx-list-ul me-2 text-primary"></i> Tüm Odalar
                                </a>
                                <a href="{{ route('rooms.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bx bx-plus-circle me-2 text-success"></i> Yeni Oda Ekle
                                </a>
                                <a href="{{ route('rooms.calendar') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bx bx-calendar me-2 text-info"></i> Oda Takvimi
                                </a>
                                <a href="{{ route('room-types.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <i class="bx bx-category me-2 text-warning"></i> Oda Tipleri
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rezervasyonlar ve Temizlik Görevleri -->
            <div class="row g-4 mt-2">
                <!-- Rezervasyonlar -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-calendar-check fs-4 me-2 text-primary"></i>
                                    <h5 class="mb-0">Rezervasyonlar</h5>
                                </div>
                                <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bx bx-plus me-1"></i> Yeni Rezervasyon
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($room->reservations && $room->reservations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" class="border-0">ID</th>
                                                <th scope="col" class="border-0">Müşteri</th>
                                                <th scope="col" class="border-0">Giriş</th>
                                                <th scope="col" class="border-0">Çıkış</th>
                                                <th scope="col" class="border-0">Durum</th>
                                                <th scope="col" class="border-0">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($room->reservations as $reservation)
                                                <tr>
                                                    <td><span class="fw-medium">#{{ $reservation->id }}</span></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm me-2 bg-primary-subtle text-primary rounded-circle">
                                                                <i class="bx bx-user"></i>
                                                            </div>
                                                            <div>{{ $reservation->customer->full_name }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i class="bx bx-log-in-circle text-success me-1"></i>
                                                        {{ $reservation->check_in->format('d.m.Y') }}
                                                    </td>
                                                    <td>
                                                        <i class="bx bx-log-out-circle text-danger me-1"></i>
                                                        {{ $reservation->check_out->format('d.m.Y') }}
                                                    </td>
                                                    <td>
                                                        @switch($reservation->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i> Bekliyor</span>
                                                                @break
                                                            @case('confirmed')
                                                                <span class="badge bg-info"><i class="bx bx-check me-1"></i> Onaylandı</span>
                                                                @break
                                                            @case('checked_in')
                                                                <span class="badge bg-success"><i class="bx bx-log-in-circle me-1"></i> Giriş Yapıldı</span>
                                                                @break
                                                            @case('checked_out')
                                                                <span class="badge bg-secondary"><i class="bx bx-log-out-circle me-1"></i> Çıkış Yapıldı</span>
                                                                @break
                                                            @case('cancelled')
                                                                <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i> İptal Edildi</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="bx bx-show me-1"></i> Görüntüle
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bx bx-calendar-x text-secondary" style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="text-muted">Bu odaya ait rezervasyon bulunmuyor</h6>
                                    <a href="{{ route('reservations.create', ['room_id' => $room->id]) }}" class="btn btn-sm btn-primary mt-3">
                                        <i class="bx bx-plus me-1"></i> Yeni Rezervasyon Oluştur
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Temizlik Görevleri -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-broom fs-4 me-2 text-primary"></i>
                                        <h5 class="mb-0">Temizlik Görevleri</h5>
                                    </div>
                                    <a href="{{ route('cleaning-tasks.create', ['room_id' => $room->id]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                        <i class="bx bx-plus me-1"></i> Yeni Temizlik Görevi
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if($room->cleaningTasks && $room->cleaningTasks->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col" class="border-0">ID</th>
                                                    <th scope="col" class="border-0">Personel</th>
                                                    <th scope="col" class="border-0">Planlanan Zaman</th>
                                                    <th scope="col" class="border-0">Durum</th>
                                                    <th scope="col" class="border-0">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($room->cleaningTasks as $task)
                                                    <tr>
                                                        <td><span class="fw-medium">#{{ $task->id }}</span></td>
                                                        <td>
                                                            @if($task->user)
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2 bg-primary-subtle text-primary rounded-circle">
                                                                        <i class="bx bx-user"></i>
                                                                    </div>
                                                                    <div>{{ $task->user->name }}</div>
                                                                </div>
                                                            @else
                                                                <span class="text-muted"><i class="bx bx-user-x me-1"></i> Atanmadı</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <i class="bx bx-calendar me-1"></i>
                                                            {{ $task->scheduled_at->format('d.m.Y') }}
                                                            <i class="bx bx-time ms-2 me-1"></i>
                                                            {{ $task->scheduled_at->format('H:i') }}
                                                        </td>
                                                        <td>
                                                            @switch($task->status)
                                                                @case('pending')
                                                                    <span class="badge bg-warning text-dark"><i class="bx bx-time me-1"></i> Bekliyor</span>
                                                                    @break
                                                                @case('in_progress')
                                                                    <span class="badge bg-info"><i class="bx bx-loader-circle me-1"></i> Devam Ediyor</span>
                                                                    @break
                                                                @case('completed')
                                                                    <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i> Tamamlandı</span>
                                                                    @break
                                                                @case('cancelled')
                                                                    <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i> İptal Edildi</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-secondary">{{ $task->status }}</span>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bx bx-show me-1"></i> Görüntüle
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bx bx-broom text-secondary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h6 class="text-muted">Bu odaya ait temizlik görevi bulunmuyor</h6>
                                        <a href="{{ route('cleaning-tasks.create', ['room_id' => $room->id]) }}" class="btn btn-sm btn-warning mt-3">
                                            <i class="bx bx-plus me-1"></i> Yeni Temizlik Görevi Oluştur
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
