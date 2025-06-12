<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class='bx bx-edit-alt fs-3 me-2 text-primary'></i>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                    {{ __('Oda Düzenle') }} 
                    <span class="badge bg-primary rounded-pill ms-2">{{ $room->room_number }}</span>
                </h2>
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class='bx bx-arrow-back me-1'></i> Tüm Odalar
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-hotel fs-4 me-2 text-primary'></i>
                                <h5 class="mb-0">Oda Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('rooms.update', $room) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <!-- Temel Bilgiler -->
                                    <div class="col-md-6">
                                        <label for="room_number" class="form-label">Oda Numarası</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-hash'></i></span>
                                            <input id="room_number" class="form-control" type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required autofocus>
                                        </div>
                                        <x-input-error :messages="$errors->get('room_number')" class="mt-2" />
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="floor" class="form-label">Kat</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-buildings'></i></span>
                                            <select id="floor" name="floor" class="form-select" required>
                                                <option value="">Kat Seçin</option>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ (old('floor') ?? $room->floor) == $i ? 'selected' : '' }}>
                                                        {{ $i }}. Kat
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('floor')" class="mt-2" />
                                    </div>

                                    <!-- Oda Tipi ve Fiyat -->
                                    <div class="col-md-6">
                                        <label for="room_type_id" class="form-label">Oda Tipi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-category'></i></span>
                                            <select id="room_type_id" name="room_type_id" class="form-select" required>
                                                <option value="">Oda Tipi Seçin</option>
                                                @foreach($roomTypes as $type)
                                                    <option value="{{ $type->id }}" {{ (old('room_type_id') ?? $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }} ({{ number_format($type->base_price, 2) }} TL)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('room_type_id')" class="mt-2" />
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="price_adjustment" class="form-label">Fiyat Ayarlaması (TL)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-lira'></i></span>
                                            <input id="price_adjustment" class="form-control" type="number" name="price_adjustment" value="{{ old('price_adjustment', $room->price_adjustment) }}" step="0.01">
                                        </div>
                                        <div class="form-text">Odanın temel fiyatına ek olarak uygulanacak fiyat ayarlaması</div>
                                        <x-input-error :messages="$errors->get('price_adjustment')" class="mt-2" />
                                    </div>

                                    <!-- Durum -->
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">Durum</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                            <select id="status" name="status" class="form-select" required>
                                                <option value="available" {{ (old('status') ?? $room->status) == 'available' ? 'selected' : '' }}>Boş</option>
                                                <option value="occupied" {{ (old('status') ?? $room->status) == 'occupied' ? 'selected' : '' }}>Dolu</option>
                                                <option value="reserved" {{ (old('status') ?? $room->status) == 'reserved' ? 'selected' : '' }}>Rezerve</option>
                                                <option value="cleaning" {{ (old('status') ?? $room->status) == 'cleaning' ? 'selected' : '' }}>Temizleniyor</option>
                                                <option value="maintenance" {{ (old('status') ?? $room->status) == 'maintenance' ? 'selected' : '' }}>Bakımda</option>
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    </div>

                                    <!-- Açıklama -->
                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Açıklama</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-info-circle'></i></span>
                                            <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $room->description) }}</textarea>
                                        </div>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-secondary">
                                        <i class='bx bx-x me-1'></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-save me-1'></i> Güncelle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
