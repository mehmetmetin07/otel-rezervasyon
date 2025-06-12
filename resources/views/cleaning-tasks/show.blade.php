<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold d-flex align-items-center">
                <i class='bx bx-broom me-2 text-primary'></i> {{ __('Temizlik Görevi Detayları') }}
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill px-3">#{{ $task->id }}</span>
            </h2>
            <div class="d-flex gap-2">
                @if($task->status != 'completed' && $task->status != 'cancelled')
                    <a href="{{ route('cleaning-tasks.edit', $task) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                        <i class='bx bx-edit me-1'></i> {{ __('Düzenle') }}
                    </a>
                @endif
                <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Üst başlık kısmı header'a taşındı -->

            <div class="row g-4">
                <!-- Görev Bilgileri -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-info-circle fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Görev Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Görev Numarası</h6>
                                        <p class="mb-0 fs-5 fw-bold">#{{ $task->id }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Oda Bilgisi</h6>
                                        <p class="mb-0 fs-5 fw-bold">
                                            <span class="badge bg-primary me-2">{{ $task->room->room_number }}</span>
                                            {{ $task->room->roomType->name }}
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Personel</h6>
                                        <p class="mb-0 fs-5">
                                            @if($task->user)
                                                <i class="bx bx-user me-1"></i> {{ $task->user->name }}
                                            @else
                                                <span class="text-muted"><i class="bx bx-user-x me-1"></i> Atanmadı</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Durum</h6>
                                        <p class="mb-0">
                                            @switch($task->status)
                                                @case('pending')
                                                    <span class="badge bg-warning-subtle text-warning px-3 py-2"><i class="bx bx-time me-1"></i> Beklemede</span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info-subtle text-info px-3 py-2"><i class="bx bx-refresh me-1"></i> Devam Ediyor</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success-subtle text-success px-3 py-2"><i class="bx bx-check me-1"></i> Tamamlandı</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger-subtle text-danger px-3 py-2"><i class="bx bx-x me-1"></i> İptal Edildi</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2">{{ $task->status }}</span>
                                            @endswitch
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Planlanan Zaman</h6>
                                        <p class="mb-0 fs-5">
                                            <i class="bx bx-calendar me-1"></i> {{ $task->scheduled_at->format('d.m.Y') }}
                                            <i class="bx bx-time ms-2 me-1"></i> {{ $task->scheduled_at->format('H:i') }}
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <h6 class="text-muted mb-2">Oda Durumu</h6>
                                        <p class="mb-0">
                                            @switch($task->room->status)
                                                @case('available')
                                                    <span class="badge bg-success-subtle text-success px-3 py-2"><i class="bx bx-check-circle me-1"></i> Boş</span>
                                                    @break
                                                @case('occupied')
                                                    <span class="badge bg-danger-subtle text-danger px-3 py-2"><i class="bx bx-x-circle me-1"></i> Dolu</span>
                                                    @break
                                                @case('reserved')
                                                    <span class="badge bg-info-subtle text-info px-3 py-2"><i class="bx bx-calendar-check me-1"></i> Rezerve</span>
                                                    @break
                                                @case('cleaning')
                                                    <span class="badge bg-warning-subtle text-warning px-3 py-2"><i class="bx bx-broom me-1"></i> Temizleniyor</span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2"><i class="bx bx-wrench me-1"></i> Bakımda</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2">{{ $task->room->status }}</span>
                                            @endswitch
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="mb-3"><i class="bx bx-time-five me-1"></i> Zaman Bilgileri</h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm bg-primary-subtle text-primary rounded-circle">
                                                                <i class="bx bx-calendar-plus"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="text-muted mb-0">Oluşturulma</p>
                                                            <p class="mb-0">{{ $task->created_at->format('d.m.Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm {{ $task->started_at ? 'bg-info-subtle text-info' : 'bg-light text-muted' }} rounded-circle">
                                                                <i class="bx bx-play-circle"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="text-muted mb-0">Başlangıç</p>
                                                            <p class="mb-0">{{ $task->started_at ? (is_string($task->started_at) ? $task->started_at : $task->started_at->format('d.m.Y H:i')) : 'Belirtilmemiş' }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar avatar-sm {{ $task->completed_at ? 'bg-success-subtle text-success' : 'bg-light text-muted' }} rounded-circle">
                                                                <i class="bx bx-check-double"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <p class="text-muted mb-0">Tamamlanma</p>
                                                            <p class="mb-0">{{ $task->completed_at ? (is_string($task->completed_at) ? $task->completed_at : $task->completed_at->format('d.m.Y H:i')) : 'Belirtilmemiş' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($task->notes)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="mb-3"><i class="bx bx-detail me-1"></i> Notlar</h6>
                                        <div class="p-3 bg-light rounded">
                                            {{ $task->notes }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- İşlemler -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-cog fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">İşlemler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-3">
                                @if($task->status == 'pending')
                                    <form action="{{ route('cleaning-tasks.in-progress', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info w-100 d-flex align-items-center justify-content-center">
                                            <i class="bx bx-play-circle me-2 fs-5"></i> Görevi Başlat
                                        </button>
                                    </form>
                                @endif

                                @if($task->status == 'in_progress')
                                    <form action="{{ route('cleaning-tasks.complete', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                            <i class="bx bx-check-circle me-2 fs-5"></i> Görevi Tamamla
                                        </button>
                                    </form>
                                @endif

                                @if($task->status == 'completed' && Auth::user()->isAdmin())
                                    <form action="{{ route('cleaning-tasks.verify-room', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                            <i class="bx bx-check-shield me-2 fs-5"></i> Odayı Boş Olarak İşaretle
                                        </button>
                                    </form>
                                @endif

                                @if($task->status != 'completed' && $task->status != 'cancelled')
                                    <form action="{{ route('cleaning-tasks.destroy', $task) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" onclick="return confirm('Görevi iptal etmek istediğinize emin misiniz?')">
                                            <i class="bx bx-trash me-2 fs-5"></i> Görevi İptal Et
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('rooms.show', $task->room) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center mt-4">
                                    <i class="bx bx-hotel me-2 fs-5"></i> Oda Detaylarını Görüntüle
                                </a>
                            </div>

                            <div class="mt-4 pt-4 border-top">
                                <h6 class="mb-3 fw-semibold"><i class="bx bx-link me-1"></i> Hızlı Bağlantılar</h6>
                                <div class="list-group list-group-flush">
                                    <a href="{{ route('cleaning-tasks.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bx bx-list-ul me-2 text-primary"></i> Tüm Temizlik Görevleri
                                    </a>
                                    <a href="{{ route('cleaning-tasks.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bx bx-plus-circle me-2 text-success"></i> Yeni Temizlik Görevi Oluştur
                                    </a>
                                    <a href="{{ route('reports.cleaning') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                        <i class="bx bx-bar-chart-alt-2 me-2 text-info"></i> Temizlik Raporları
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
