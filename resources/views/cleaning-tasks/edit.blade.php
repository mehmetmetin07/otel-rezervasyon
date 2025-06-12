<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class='bx bx-edit-alt fs-3 me-2 text-primary'></i>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                    {{ __('Temizlik Görevi Düzenle') }} 
                    <span class="badge bg-primary rounded-pill ms-2">#{{ $cleaningTask->id }}</span>
                </h2>
            </div>
            <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class='bx bx-arrow-back me-1'></i> Tüm Görevler
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
                                <i class='bx bx-broom fs-4 me-2 text-primary'></i>
                                <h5 class="mb-0">Görev Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('cleaning-tasks.update', $cleaningTask) }}">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <!-- Oda Bilgisi -->
                                    <div class="col-md-6">
                                        <label for="room" class="form-label">Oda</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-hotel'></i></span>
                                            <input type="text" class="form-control bg-light" value="{{ $cleaningTask->room->room_number }} - {{ $cleaningTask->room->roomType->name }}" readonly>
                                            <input type="hidden" name="room_id" value="{{ $cleaningTask->room_id }}">
                                        </div>
                                    </div>

                                    <!-- Personel Seçimi -->
                                    <div class="col-md-6">
                                        <label for="user_id" class="form-label">Personel</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                                            <select id="user_id" name="user_id" class="form-select">
                                                <option value="">Henüz Atama Yapma</option>
                                                @foreach($cleaners as $cleaner)
                                                    <option value="{{ $cleaner->id }}" {{ (old('user_id', $cleaningTask->user_id) == $cleaner->id) ? 'selected' : '' }}>
                                                        {{ $cleaner->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                    </div>

                                    <!-- Planlanan Tarih ve Saat -->
                                    <div class="col-md-6">
                                        <label for="scheduled_date" class="form-label">Planlanan Tarih</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                            <input id="scheduled_date" class="form-control" type="date" name="scheduled_date" value="{{ old('scheduled_date', $cleaningTask->scheduled_at->format('Y-m-d')) }}" required>
                                        </div>
                                        <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                                    </div>

                                    <div class="col-md-6">
                                        <label for="scheduled_time" class="form-label">Planlanan Saat</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-time'></i></span>
                                            <input id="scheduled_time" class="form-control" type="time" name="scheduled_time" value="{{ old('scheduled_time', $cleaningTask->scheduled_at->format('H:i')) }}" required>
                                        </div>
                                        <x-input-error :messages="$errors->get('scheduled_time')" class="mt-2" />
                                    </div>

                                    <!-- Durum -->
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">Durum</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                            <select id="status" name="status" class="form-select" required>
                                                <option value="pending" {{ (old('status', $cleaningTask->status) == 'pending') ? 'selected' : '' }}>Bekliyor</option>
                                                <option value="in_progress" {{ (old('status', $cleaningTask->status) == 'in_progress') ? 'selected' : '' }}>Devam Ediyor</option>
                                                <option value="completed" {{ (old('status', $cleaningTask->status) == 'completed') ? 'selected' : '' }}>Tamamlandı</option>
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                    </div>

                                    <!-- Notlar -->
                                    <div class="col-md-12">
                                        <label for="notes" class="form-label">Notlar</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class='bx bx-note'></i></span>
                                            <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes', $cleaningTask->notes) }}</textarea>
                                        </div>
                                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('cleaning-tasks.show', $cleaningTask) }}" class="btn btn-outline-secondary">
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
        </div>
    </div>
</x-app-layout>
