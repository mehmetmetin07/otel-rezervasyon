<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight d-flex align-items-center">
                <i class='bx bx-edit me-2 text-primary'></i> {{ __('Rezervasyon Düzenle') }}
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill px-3">#{{ $reservation->id }}</span>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="py-4">
        <div class="container">
            <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                @csrf
                @method('PUT')

                <!-- Hidden customer_id field -->
                <input type="hidden" name="customer_id" value="{{ $reservation->customer_id }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <i class='bx bx-user-circle fs-4 text-primary'></i>
                                    </div>
                                    <h5 class="mb-0 fw-semibold">Müşteri Bilgileri</h5>
                                </div>
                            </div>
                            <div class="card-body p-4">

                                <!-- Müşteri Bilgisi (Değiştirilemez) -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="avatar avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <i class='bx bxs-user text-primary fs-4'></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $reservation->customer->full_name }}</h6>
                                        <p class="mb-0 text-muted small">{{ $reservation->customer->id_number }}</p>
                                    </div>
                                </div>

                                <div class="alert alert-info d-flex align-items-center" role="alert">
                                    <i class='bx bx-info-circle me-2 fs-5'></i>
                                    <div>
                                        Müşteri değiştirmek için rezervasyonu iptal edip yeniden oluşturun
                                    </div>
                                </div>

                                <!-- Müşteri Detayları -->
                                <div class="list-group list-group-flush mt-3">
                                    <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                                        <span class="text-muted">Telefon</span>
                                        <span class="fw-medium">{{ $reservation->customer->phone }}</span>
                                    </div>
                                    <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                                        <span class="text-muted">E-posta</span>
                                        <span class="fw-medium">{{ $reservation->customer->email ?? 'Belirtilmemiş' }}</span>
                                    </div>
                                    @if($reservation->customer->address)
                                    <div class="list-group-item px-0 py-2 border-0">
                                        <span class="text-muted">Adres</span>
                                        <p class="mb-0 mt-1 fw-medium">{{ $reservation->customer->address }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <i class='bx bx-calendar-edit fs-4 text-primary'></i>
                                    </div>
                                    <h5 class="mb-0 fw-semibold">Rezervasyon Detayları</h5>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <!-- Oda Seçimi -->
                                <div class="mb-4">
                                    <label for="room_id" class="form-label fw-bold">Oda <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-hotel"></i></span>
                                        <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                            <option value="{{ $reservation->room_id }}">
                                                {{ $reservation->room->room_number }} - {{ $reservation->room->roomType->name }} - {{ $reservation->room->roomType->capacity }} kişilik (Mevcut)
                                            </option>
                                            @foreach($rooms as $room)
                                                @if($room->id != $reservation->room_id)
                                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                        {{ $room->room_number }} - {{ $room->roomType->name }} - {{ $room->roomType->capacity }} kişilik ({{ number_format($room->roomType->base_price, 2) }} TL)
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('room_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tarih Bilgileri -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="check_in" class="form-label fw-bold">Giriş Tarihi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar-plus"></i></span>
                                            <input id="check_in" class="form-control @error('check_in') is-invalid @enderror" type="date" name="check_in" value="{{ old('check_in', $reservation->check_in->format('Y-m-d')) }}" required />
                                            @error('check_in')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="check_out" class="form-label fw-bold">Çıkış Tarihi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar-x"></i></span>
                                            <input id="check_out" class="form-control @error('check_out') is-invalid @enderror" type="date" name="check_out" value="{{ old('check_out', $reservation->check_out->format('Y-m-d')) }}" required />
                                            @error('check_out')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Kişi Sayısı -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="adults" class="form-label fw-bold">Yetişkin Sayısı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input id="adults" class="form-control @error('adults') is-invalid @enderror" type="number" name="adults" value="{{ old('adults', $reservation->adults) }}" min="1" required />
                                            @error('adults')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="children" class="form-label fw-bold">Çocuk Sayısı</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-child"></i></span>
                                            <input id="children" class="form-control @error('children') is-invalid @enderror" type="number" name="children" value="{{ old('children', $reservation->children) }}" min="0" />
                                            @error('children')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Özel İstekler -->
                                <div class="mb-4">
                                    <label for="special_requests" class="form-label fw-bold">Özel İstekler</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-list-plus"></i></span>
                                        <textarea id="special_requests" name="special_requests" class="form-control @error('special_requests') is-invalid @enderror" rows="3">{{ old('special_requests', $reservation->special_requests) }}</textarea>
                                        @error('special_requests')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Notlar -->
                                <div class="mb-4">
                                    <label for="notes" class="form-label fw-bold">Notlar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-note"></i></span>
                                        <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Durum -->
                                <div class="mb-4">
                                    <label for="status" class="form-label fw-bold">Durum <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ (old('status', $reservation->status) == 'pending') ? 'selected' : '' }}>Onay Bekliyor</option>
                                            <option value="confirmed" {{ (old('status', $reservation->status) == 'confirmed') ? 'selected' : '' }}>Onaylandı</option>
                                            <option value="checked_in" {{ (old('status', $reservation->status) == 'checked_in') ? 'selected' : '' }}>Check-in Yapıldı</option>
                                            <option value="checked_out" {{ (old('status', $reservation->status) == 'checked_out') ? 'selected' : '' }}>Check-out Yapıldı</option>
                                            <option value="cancelled" {{ (old('status', $reservation->status) == 'cancelled') ? 'selected' : '' }}>İptal Edildi</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Butonlar -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between p-3">
                                <div>
                                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                                        <i class='bx bx-list-ul'></i> {{ __('Tüm Rezervasyonlar') }}
                                    </a>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                                        <i class='bx bx-x'></i> {{ __('İptal') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                                        <i class='bx bx-save'></i> {{ __('Güncelle') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_id');
            const adultsInput = document.getElementById('adults');
            const childrenInput = document.getElementById('children');
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');

            // Oda kapasiteleri (mevcut oda + diğer odalar)
            const roomCapacities = {
                {{ $reservation->room_id }}: {{ $reservation->room->roomType->capacity }},
                @foreach($rooms as $room)
                    @if($room->id != $reservation->room_id)
                    {{ $room->id }}: {{ $room->roomType->capacity }},
                    @endif
                @endforeach
            };

            // Kapasite kontrolü
            function checkCapacity() {
                const roomId = roomSelect.value;
                const adults = parseInt(adultsInput.value) || 0;
                const children = parseInt(childrenInput.value) || 0;
                const totalGuests = adults + children;

                // Mevcut uyarıyı kaldır
                const existingAlert = document.querySelector('.capacity-warning');
                if (existingAlert) {
                    existingAlert.remove();
                }

                if (roomId && roomCapacities[roomId]) {
                    const capacity = roomCapacities[roomId];

                    if (totalGuests > capacity) {
                        // Uyarı mesajı oluştur
                        const warningDiv = document.createElement('div');
                        warningDiv.className = 'alert alert-warning capacity-warning mt-2 d-flex align-items-center';
                        warningDiv.innerHTML = `
                            <i class='bx bx-error-circle me-2 fs-5'></i>
                            <div>
                                <strong>Kapasite Aşıldı!</strong> Seçilen oda maksimum <strong>${capacity} kişilik</strong> kapasiteye sahiptir.
                                Toplam misafir sayısı: <strong>${totalGuests} kişi</strong>
                            </div>
                        `;

                        // Çocuk sayısı input'undan sonra ekle
                        childrenInput.closest('.col-md-6').insertAdjacentElement('afterend', warningDiv);
                    }
                }
            }

            // Oda çakışması kontrolü
            function checkRoomConflict() {
                const roomId = roomSelect.value;
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                // Mevcut çakışma uyarısını kaldır
                const existingConflictAlert = document.querySelector('.conflict-warning');
                if (existingConflictAlert) {
                    existingConflictAlert.remove();
                }

                if (roomId && checkIn && checkOut) {
                    // AJAX ile çakışma kontrolü yap
                    fetch('/api/check-room-conflict', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            room_id: roomId,
                            check_in: checkIn,
                            check_out: checkOut,
                            reservation_id: {{ $reservation->id }} // Mevcut rezervasyonu hariç tut
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.conflict) {
                            // Çakışma uyarısı göster
                            const warningDiv = document.createElement('div');
                            warningDiv.className = 'alert alert-danger conflict-warning mt-2 d-flex align-items-center';
                            warningDiv.innerHTML = `
                                <i class='bx bx-error-circle me-2 fs-5'></i>
                                <div>
                                    <strong>Oda Çakışması!</strong> ${data.room_number} numaralı oda için belirtilen tarihlerde başka bir rezervasyon bulunuyor.
                                    <br><small>Çakışan rezervasyon: ${data.conflict_dates}</small>
                                </div>
                            `;
                            checkOutInput.closest('.col-md-6').insertAdjacentElement('afterend', warningDiv);
                        }
                    })
                    .catch(error => {
                        console.error('Çakışma kontrolü hatası:', error);
                    });
                }
            }

            // Sayfa yüklenirken kontrol et
            checkCapacity();
            checkRoomConflict();

            // Event listener'ları ekle
            roomSelect.addEventListener('change', function() {
                checkCapacity();
                checkRoomConflict();
            });
            adultsInput.addEventListener('input', checkCapacity);
            childrenInput.addEventListener('input', checkCapacity);
            checkInInput.addEventListener('change', checkRoomConflict);
            checkOutInput.addEventListener('change', checkRoomConflict);

            // Tarih alanları için minimum tarih ayarı
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in').setAttribute('min', today);
            document.getElementById('check_out').setAttribute('min', today);

            // Giriş tarihine göre çıkış tarihini ayarlama
            document.getElementById('check_in').addEventListener('change', function() {
                const checkInDate = this.value;
                document.getElementById('check_out').setAttribute('min', checkInDate);

                // Eğer çıkış tarihi giriş tarihinden önceyse, çıkış tarihini giriş tarihine eşitle
                const checkOutDate = document.getElementById('check_out').value;
                if (checkOutDate < checkInDate) {
                    document.getElementById('check_out').value = checkInDate;
                }
            });
        });
    </script>
</x-app-layout>
