<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Odalar') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-hotel fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Oda Yönetimi</h5>
                    </div>
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus me-1'></i> Yeni Oda Ekle
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form action="{{ route('rooms.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="status" class="form-label">Durum</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Tümü</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Boş</option>
                                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Dolu</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                                    <option value="cleaning" {{ request('status') == 'cleaning' ? 'selected' : '' }}>Temizleniyor</option>
                                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="type" class="form-label">Oda Tipi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-category'></i></span>
                                    <select id="type" name="type" class="form-select">
                                        <option value="">Tümü</option>
                                        @foreach($roomTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <label for="floor" class="form-label">Kat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-buildings'></i></span>
                                    <select id="floor" name="floor" class="form-select">
                                        <option value="">Tümü</option>
                                        @foreach($floors as $floor)
                                            <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }}>{{ $floor }}. Kat</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="search" class="form-label">Arama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-search'></i></span>
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Oda numarası, açıklama...">
                                </div>
                            </div>
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-filter me-1'></i> Filtrele
                                    </button>
                                    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                        <i class='bx bx-reset me-1'></i> Sıfırla
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sonuçlar -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Oda Listesi</h5>
                    <span class="badge bg-primary rounded-pill">{{ $rooms->total() }} Oda</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 border-bottom">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-0 py-3 ps-4 fw-semibold text-dark">Oda No</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Kat</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Oda Tipi</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Fiyat</th>
                                    <th class="border-0 py-3 fw-semibold text-dark">Durum</th>
                                    <th class="border-0 py-3 pe-4 fw-semibold text-dark text-end">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class='bx bx-hotel text-primary'></i>
                                                </div>
                                                <span class="fw-medium">{{ $room->room_number }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                <i class='bx bx-buildings me-1'></i> {{ $room->floor }}. Kat
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                    <i class='bx bx-category-alt me-1'></i> {{ $room->roomType->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class='bx bx-lira me-1'></i> {{ number_format($room->total_price, 2) }} TL
                                            </span>
                                        </td>
                                        <td>
                                            @switch($room->status)
                                                @case('available')
                                                    <span class="badge bg-success-subtle text-success">Boş</span>
                                                    @break
                                                @case('occupied')
                                                    <span class="badge bg-danger-subtle text-danger">Dolu</span>
                                                    @break
                                                @case('reserved')
                                                    <span class="badge bg-primary-subtle text-primary">Rezerve</span>
                                                    @break
                                                @case('cleaning')
                                                    <span class="badge bg-warning-subtle text-warning">Temizleniyor</span>
                                                    @break
                                                @case('maintenance')
                                                    <span class="badge bg-secondary-subtle text-secondary">Bakımda</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-light text-dark">{{ $room->status }}</span>
                                            @endswitch
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                        <i class='bx bx-show'></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-secondary" title="Düzenle">
                                                        <i class='bx bx-edit'></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Sil" onclick="return confirm('Odayı silmek istediğinize emin misiniz?')">
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
                                                <i class='bx bx-search-alt fs-1 text-muted mb-3'></i>
                                                <h6 class="fw-normal text-muted">Herhangi bir oda bulunamadı</h6>
                                                <p class="text-muted small">Filtreleri değiştirerek tekrar arayabilirsiniz</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
