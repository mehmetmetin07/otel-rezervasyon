<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-category-alt me-2 text-primary'></i> {{ __('Oda Tipi Detayları') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-edit me-1'></i> <span>{{ __('Düzenle') }}</span>
                </a>
                <a href="{{ route('room-types.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> <span>{{ __('Oda Tipleri') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <!-- Oda Tipi Detayları -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-info-circle fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Oda Tipi Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h3 class="fs-4 fw-bold text-primary mb-3 d-flex align-items-center">
                                        <i class='bx bx-category-alt me-2'></i> {{ $roomType->name }}
                                    </h3>
                                    
                                    @if($roomType->description)
                                    <div class="mb-4">
                                        <h6 class="text-muted mb-2">Açıklama</h6>
                                        <p class="mb-0">{{ $roomType->description }}</p>
                                    </div>
                                    @endif
                                    
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0 h-100">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class='bx bx-user fs-4 me-2 text-primary'></i>
                                                        <h6 class="mb-0 fw-semibold">Kapasite</h6>
                                                    </div>
                                                    <p class="mb-0 fs-5">{{ $roomType->capacity }} Kişilik</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0 h-100">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class='bx bx-lira fs-4 me-2 text-success'></i>
                                                        <h6 class="mb-0 fw-semibold">Temel Fiyat</h6>
                                                    </div>
                                                    <p class="mb-0 fs-5">{{ number_format($roomType->base_price, 2) }} TL</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light border-0 h-100">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class='bx bx-calendar fs-4 me-2 text-info'></i>
                                                        <h6 class="mb-0 fw-semibold">Oluşturulma</h6>
                                                    </div>
                                                    <p class="mb-0">{{ $roomType->created_at->format('d.m.Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sağ Taraf - İstatistikler ve Hızlı İşlemler -->
                <div class="col-md-4">
                    <!-- İstatistikler -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-bar-chart-alt-2 fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">İstatistikler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">Toplam Oda</h6>
                                            <p class="mb-0 text-muted small">Bu tipteki toplam oda sayısı</p>
                                        </div>
                                        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">{{ $roomType->rooms_count ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-3">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">Müsait Odalar</h6>
                                            <p class="mb-0 text-muted small">Şu an rezerve edilebilir</p>
                                        </div>
                                        <span class="badge bg-success rounded-pill fs-6 px-3 py-2">{{ $roomType->available_rooms_count ?? 0 }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">Doluluk Oranı</h6>
                                            <p class="mb-0 text-muted small">Mevcut doluluk yüzdesi</p>
                                        </div>
                                        @php
                                            $totalRooms = $roomType->rooms_count ?? 0;
                                            $availableRooms = $roomType->available_rooms_count ?? 0;
                                            $occupancyRate = $totalRooms > 0 ? round(100 - ($availableRooms / $totalRooms * 100)) : 0;
                                        @endphp
                                        <span class="badge {{ $occupancyRate > 70 ? 'bg-danger' : ($occupancyRate > 30 ? 'bg-warning' : 'bg-info') }} rounded-pill fs-6 px-3 py-2">{{ $occupancyRate }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hızlı İşlemler -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-list-ul fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Hızlı İşlemler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('rooms.create', ['room_type_id' => $roomType->id]) }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                                    <i class='bx bx-plus-circle me-2'></i> Bu Tipte Yeni Oda Ekle
                                </a>
                                <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                    <i class='bx bx-edit me-2'></i> Oda Tipini Düzenle
                                </a>
                                <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center" 
                                        data-bs-toggle="modal" data-bs-target="#deleteRoomTypeModal">
                                    <i class='bx bx-trash me-2'></i> Oda Tipini Sil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bu Tipteki Odalar -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class='bx bx-hotel fs-4 text-primary'></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Bu Tipteki Odalar</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-0 py-3 ps-4">Oda No</th>
                                    <th class="border-0 py-3">Durum</th>
                                    <th class="border-0 py-3">Kat</th>
                                    <th class="border-0 py-3">Özellikler</th>
                                    <th class="border-0 py-3 text-end pe-4">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomType->rooms ?? [] as $room)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class='bx bx-door-open text-primary'></i>
                                            </div>
                                            <span class="fw-medium">{{ $room->room_number }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($room->status == 'available')
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class='bx bx-check-circle me-1'></i> Müsait
                                            </span>
                                        @elseif($room->status == 'occupied')
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                <i class='bx bx-x-circle me-1'></i> Dolu
                                            </span>
                                        @elseif($room->status == 'cleaning')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                                <i class='bx bx-spray-can me-1'></i> Temizleniyor
                                            </span>
                                        @elseif($room->status == 'maintenance')
                                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                                <i class='bx bx-wrench me-1'></i> Bakımda
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $room->floor }}. Kat</td>
                                    <td>
                                        @if($room->has_balcony)
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 me-1">
                                                <i class='bx bx-landscape me-1'></i> Balkon
                                            </span>
                                        @endif
                                        @if($room->has_sea_view)
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 me-1">
                                                <i class='bx bx-water me-1'></i> Deniz Manzarası
                                            </span>
                                        @endif
                                        @if($room->has_air_conditioning)
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1 me-1">
                                                <i class='bx bx-wind me-1'></i> Klima
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                <i class='bx bx-show me-1'></i> Detay
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="py-5">
                                            <i class='bx bx-hotel fs-1 text-muted mb-3'></i>
                                            <h6 class="fw-normal text-muted">Bu tipte henüz oda bulunmuyor</h6>
                                            <a href="{{ route('rooms.create', ['room_type_id' => $roomType->id]) }}" class="btn btn-sm btn-primary mt-2">
                                                <i class='bx bx-plus me-1'></i> Yeni Oda Ekle
                                            </a>
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
    
    <!-- Silme Onay Modalı -->
    <div class="modal fade" id="deleteRoomTypeModal" tabindex="-1" aria-labelledby="deleteRoomTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="deleteRoomTypeModalLabel">Oda Tipini Sil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class='bx bx-error-circle text-danger' style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="mb-3">Bu oda tipini silmek istediğinize emin misiniz?</h5>
                    <p class="text-muted">Bu işlem geri alınamaz ve bu tipteki tüm odalar da silinecektir.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> İptal
                    </button>
                    <form action="{{ route('room-types.destroy', $roomType) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class='bx bx-trash me-1'></i> Evet, Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
