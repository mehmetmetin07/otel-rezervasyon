<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yeni Temizlik Görevi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-broom fs-4 me-2 text-primary"></i>
                                <h5 class="mb-0">Temizlik Görevi Oluştur</h5>
                            </div>
                            <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bx bx-arrow-back me-1"></i> Görev Listesi
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
                            
                            <form method="POST" action="{{ route('cleaning-tasks.store') }}">
                                @csrf
                                
                                <div class="row g-4">
                                    <div class="col-12 mb-2">
                                        <h6 class="fw-bold text-primary"><i class="bx bx-info-circle me-1"></i> Görev Bilgileri</h6>
                                        <hr class="mt-1">
                                    </div>
                                    
                                    <!-- Oda Seçimi -->
                                    <div class="col-md-6">
                                        <label for="room_id" class="form-label">Oda <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-hotel"></i></span>
                                            <select id="room_id" name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                                                <option value="">Oda Seçin</option>
                                                @forelse($rooms as $room)
                                                    <option value="{{ $room->id }}" {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                                        {{ $room->room_number }} - {{ $room->roomType->name }} ({{ $room->status == 'available' ? 'Boş' : 'Temizlik Bekliyor' }})
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Temizlenecek oda bulunamadı</option>
                                                @endforelse
                                            </select>
                                            @error('room_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($rooms->isEmpty())
                                                <div class="alert alert-warning mt-2 d-flex align-items-center" role="alert">
                                                    <i class='bx bx-info-circle me-2 fs-5'></i>
                                                    <div>Şu anda temizlenecek oda bulunmamaktadır. Lütfen daha sonra tekrar deneyin veya bir odanın durumunu güncelleyin.</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Personel Seçimi -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label">Personel</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                                <option value="">Henüz Atama Yapma</option>
                                                @foreach($cleaners as $cleaner)
                                                    <option value="{{ $cleaner->id }}" {{ old('user_id') == $cleaner->id ? 'selected' : '' }}>
                                                        {{ $cleaner->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mt-2 mb-2">
                                        <h6 class="fw-bold text-primary"><i class="bx bx-calendar me-1"></i> Zamanlama</h6>
                                        <hr class="mt-1">
                                    </div>
                                    
                                    <!-- Planlanan Tarih -->
                                    <div class="col-md-6">
                                        <label for="scheduled_date" class="form-label">Planlanan Tarih <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                            <input type="date" id="scheduled_date" name="scheduled_date" class="form-control @error('scheduled_date') is-invalid @enderror" value="{{ old('scheduled_date', date('Y-m-d')) }}" required>
                                            @error('scheduled_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Planlanan Saat -->
                                    <div class="col-md-6">
                                        <label for="scheduled_time" class="form-label">Planlanan Saat <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="time" id="scheduled_time" name="scheduled_time" class="form-control @error('scheduled_time') is-invalid @enderror" value="{{ old('scheduled_time', date('H:i')) }}" required>
                                            @error('scheduled_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Durum -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mt-2 mb-2">
                                        <h6 class="fw-bold text-primary"><i class="bx bx-detail me-1"></i> Ek Bilgiler</h6>
                                        <hr class="mt-1">
                                    </div>
                                    
                                    <!-- Notlar -->
                                    <div class="col-md-6">
                                        <label for="notes" class="form-label">Notlar</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-note"></i></span>
                                            <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2" placeholder="Özel talimatlar veya notlar">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Durum -->
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Durum <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-check-circle"></i></span>
                                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4 border-top pt-4">
                                    <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="bx bx-x me-1"></i> İptal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-1"></i> Görevi Oluştur
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
