<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class='bx bx-category-alt me-2 text-primary'></i> {{ __('Oda Tipleri') }}
            </h2>
            <a href="{{ route('room-types.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                <i class='bx bx-plus me-1'></i> <span>{{ __('Yeni Oda Tipi') }}</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                <i class='bx bx-category fs-4 text-primary'></i>
                            </div>
                            <h5 class="mb-0 fw-semibold">Oda Tipleri Listesi</h5>
                        </div>
                        <a href="{{ route('room-types.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                            <i class='bx bx-plus me-1'></i> <span>{{ __('Ekle') }}</span>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 border-bottom">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-0 py-3 ps-4 fw-semibold text-dark">Oda Tipi</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Kapasite</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Temel Fiyat</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Toplam Oda</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Müsait Oda</th>
                                    <th class="border-0 py-3 pe-4 fw-semibold text-dark text-end">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomTypes as $roomType)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-category-alt text-primary'></i>
                                                </div>
                                                <div>
                                                    <span class="fw-medium">{{ $roomType->name }}</span>
                                                    @if($roomType->description)
                                                        <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $roomType->description }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                                <i class='bx bx-user me-1'></i> {{ $roomType->capacity }} Kişilik
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class='bx bx-lira me-1'></i> {{ number_format($roomType->base_price, 2) }} TL
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                <i class='bx bx-hotel me-1'></i> {{ $roomType->total_rooms }} Oda
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class='bx bx-check-circle me-1'></i> {{ $roomType->available_rooms }} Müsait
                                            </span>
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('room-types.show', $roomType) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                        <i class='bx bx-show'></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-sm btn-outline-secondary" title="Düzenle">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('rooms.create', ['room_type_id' => $roomType->id]) }}" class="btn btn-sm btn-outline-success" title="Oda Ekle">
                                                        <i class='bx bx-plus'></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('room-types.destroy', $roomType) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Sil" onclick="return confirm('Bu oda tipini silmek istediğinize emin misiniz?')">
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center py-5">
                                                <i class='bx bx-category fs-1 text-muted mb-3'></i>
                                                <h6 class="fw-normal text-muted">Henüz oda tipi bulunmuyor</h6>
                                                <p class="text-muted small">Yeni oda tipi eklemek için "Yeni Oda Tipi" butonuna tıklayın</p>
                                                <a href="{{ route('room-types.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class='bx bx-plus me-1'></i> Yeni Oda Tipi Ekle
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(isset($roomTypes) && $roomTypes->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $roomTypes->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
