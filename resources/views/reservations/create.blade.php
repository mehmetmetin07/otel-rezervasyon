<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Rezervasyon') }}
        </h2>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-calendar-plus fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Yeni Rezervasyon Oluştur</h5>
                            </div>
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bx bx-arrow-back me-1"></i> Rezervasyon Listesi
                            </a>
                        </div>

                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <div class="d-flex">
                                        <i class="bx bx-error-circle fs-4 me-2"></i>
                                        <div>
                                            <strong>Hata!</strong> Lütfen aşağıdaki hataları düzeltin:
                                            <ul class="mb-0 mt-1 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="fw-bold text-primary mb-3"><i class="bx bx-user me-1"></i> Müşteri Bilgileri</h5>
                                    <hr class="mt-0 mb-4">
                                </div>

                                <!-- Mevcut Müşteri Seçimi -->
                                <div class="mb-4">
                                    <label for="customer_id" class="form-label">Mevcut Müşteri</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-user-check"></i></span>
                                        <select id="customer_id" name="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                                            <option value="">Yeni Müşteri</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->full_name }} ({{ $customer->id_number }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div id="new-customer-fields" class="border rounded p-3 mb-3 bg-light">
                                    <div class="mb-3">
                                        <h6 class="fw-bold"><i class="bx bx-user-plus me-1"></i> Yeni Müşteri Bilgileri</h6>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Adı -->
                                        <div class="col-md-6">
                                            <label for="first_name" class="form-label">Adı</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="Müşterinin adı">
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Soyadı -->
                                        <div class="col-md-6">
                                            <label for="last_name" class="form-label">Soyadı</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Müşterinin soyadı">
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- T.C. Kimlik No / Pasaport No -->
                                        <div class="col-md-6">
                                            <label for="identity_number" class="form-label">T.C. Kimlik No / Pasaport No</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                                <input type="text" id="identity_number" name="identity_number" class="form-control @error('identity_number') is-invalid @enderror" value="{{ old('identity_number') }}" placeholder="11 haneli kimlik numarası">
                                                @error('identity_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Telefon -->
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Telefon</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="05XX XXX XX XX">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- E-posta -->
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">E-posta</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="ornek@mail.com">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Adres -->
                                        <div class="col-12">
                                            <label for="address" class="form-label">Adres</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-map"></i></span>
                                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="Müşterinin adresi">{{ old('address') }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="fw-bold text-primary mb-3"><i class="bx bx-calendar-event me-1"></i> Rezervasyon Detayları</h5>
                                    <hr class="mt-0 mb-4">
                                </div>

                                <!-- Oda Seçimi -->
                                <div class="mb-4">
                                    <label for="room_id" class="form-label">Oda <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-hotel"></i></span>
                                        <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                            <option value="">Oda Seçin</option>
                                            @forelse($rooms as $room)
                                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                    {{ $room->room_number }} - {{ $room->roomType->name }} - {{ $room->roomType->capacity }} kişilik - <strong>{{ number_format($room->roomType->base_price, 2) }} TL/gece</strong>
                                                </option>
                                            @empty
                                                <option value="" disabled>Müsait oda bulunamadı</option>
                                            @endforelse
                                        </select>
                                        @error('room_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($rooms->isEmpty())
                                        <div class="alert alert-warning mt-2 d-flex align-items-center" role="alert">
                                            <i class='bx bx-info-circle me-2 fs-5'></i>
                                            <div>Şu anda müsait oda bulunmamaktadır. Lütfen daha sonra tekrar deneyin veya bir odanın durumunu güncelleyin.</div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row g-3">
                                    <!-- Giriş Tarihi -->
                                    <div class="col-md-6">
                                        <label for="check_in" class="form-label">Giriş Tarihi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar-check"></i></span>
                                            <input type="date" id="check_in" name="check_in" class="form-control @error('check_in') is-invalid @enderror" value="{{ old('check_in') }}" required>
                                            @error('check_in')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Çıkış Tarihi -->
                                    <div class="col-md-6">
                                        <label for="check_out" class="form-label">Çıkış Tarihi <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar-x"></i></span>
                                            <input type="date" id="check_out" name="check_out" class="form-control @error('check_out') is-invalid @enderror" value="{{ old('check_out') }}" required>
                                            @error('check_out')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <!-- Yetişkin Sayısı -->
                                    <div class="col-md-6">
                                        <label for="adults" class="form-label">Yetişkin Sayısı <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input type="number" id="adults" name="adults" class="form-control @error('adults') is-invalid @enderror" value="{{ old('adults', 1) }}" min="1" required>
                                            @error('adults')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Çocuk Sayısı -->
                                    <div class="col-md-6">
                                        <label for="children" class="form-label">Çocuk Sayısı</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-child"></i></span>
                                            <input type="number" id="children" name="children" class="form-control @error('children') is-invalid @enderror" value="{{ old('children', 0) }}" min="0">
                                            @error('children')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Özel İstekler -->
                                <div class="mb-4 mt-3">
                                    <label for="special_requests" class="form-label">Özel İstekler</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-list-check"></i></span>
                                        <textarea id="special_requests" name="special_requests" class="form-control @error('special_requests') is-invalid @enderror" rows="2" placeholder="Özel istekler (oda tercihi, yastık tipi vb.)">{{ old('special_requests') }}</textarea>
                                        @error('special_requests')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Durum -->
                                <div class="mb-4">
                                    <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Onay Bekliyor</option>
                                            <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Onaylandı</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 border-top pt-4">
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bx bx-x me-1"></i> İptal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-calendar-plus me-1"></i> Rezervasyonu Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerSelect = document.getElementById('customer_id');
            const newCustomerFields = document.getElementById('new-customer-fields');
            const firstNameInput = document.getElementById('first_name');
            const lastNameInput = document.getElementById('last_name');
            const idNumberInput = document.getElementById('identity_number');
            const phoneInput = document.getElementById('phone');
            const roomSelect = document.getElementById('room_id');
            const adultsInput = document.getElementById('adults');
            const childrenInput = document.getElementById('children');

            // Oda kapasiteleri
            const roomCapacities = {
                @foreach($rooms as $room)
                {{ $room->id }}: {{ $room->roomType->capacity }},
                @endforeach
            };

            // Müşteri seçimine göre yeni müşteri alanlarını göster/gizle
            function toggleNewCustomerFields() {
                if (customerSelect.value === '') {
                    newCustomerFields.style.display = 'block';
                    // Yeni müşteri alanlarını zorunlu yap
                    firstNameInput.setAttribute('required', 'required');
                    lastNameInput.setAttribute('required', 'required');
                    idNumberInput.setAttribute('required', 'required');
                    phoneInput.setAttribute('required', 'required');
                } else {
                    newCustomerFields.style.display = 'none';
                    // Yeni müşteri alanlarının zorunluluğunu kaldır
                    firstNameInput.removeAttribute('required');
                    lastNameInput.removeAttribute('required');
                    idNumberInput.removeAttribute('required');
                    phoneInput.removeAttribute('required');
                }
            }

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

            // Sayfa yüklenirken durumu ayarla
            toggleNewCustomerFields();
            checkCapacity();

            // Event listener'ları ekle
            customerSelect.addEventListener('change', toggleNewCustomerFields);
            roomSelect.addEventListener('change', checkCapacity);
            adultsInput.addEventListener('input', checkCapacity);
            childrenInput.addEventListener('input', checkCapacity);

            // Tarih alanları için minimum tarih ayarı
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('check_in').setAttribute('min', today);
            document.getElementById('check_out').setAttribute('min', today);

            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');

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
                            check_out: checkOut
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

            // Giriş tarihine göre çıkış tarihini ayarlama
            checkInInput.addEventListener('change', function() {
                const checkInDate = this.value;
                checkOutInput.setAttribute('min', checkInDate);

                // Eğer çıkış tarihi giriş tarihinden önceyse, çıkış tarihini giriş tarihine eşitle
                const checkOutDate = checkOutInput.value;
                if (checkOutDate < checkInDate) {
                    checkOutInput.value = checkInDate;
                }

                // Çakışma kontrolü yap
                checkRoomConflict();
            });

            // Çıkış tarihi değiştiğinde de çakışma kontrolü yap
            checkOutInput.addEventListener('change', checkRoomConflict);

            // Oda değiştiğinde de çakışma kontrolü yap
            roomSelect.addEventListener('change', function() {
                checkCapacity();
                checkRoomConflict();
            });
        });
    </script>
</x-app-layout>
