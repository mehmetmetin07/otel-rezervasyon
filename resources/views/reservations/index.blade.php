<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rezervasyonlar') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rezervasyon Listesi</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('reservations.index', ['export' => 'excel'] + request()->except('page')) }}" class="btn btn-success">
                            <i class='bx bx-export me-1'></i> Excel'e Aktar
                        </a>
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                            <i class='bx bx-plus me-1'></i> Yeni Rezervasyon
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form action="{{ route('reservations.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Durum</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="">Tümü</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Onay Bekliyor</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Onaylandı</option>
                                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Check-in Yapıldı</option>
                                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Check-out Yapıldı</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="date" class="form-label">Tarih</label>
                                <input type="date" id="date" name="date" value="{{ request('date') }}" class="form-control">
                                <div class="form-text">Belirtilen tarihte aktif rezervasyonlar</div>
                            </div>

                            <div class="col-md-4">
                                <label for="search" class="form-label">Arama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-search'></i></span>
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Müşteri adı, oda no...">
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-filter me-1'></i> Filtrele
                                    </button>
                                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                                        <i class='bx bx-reset me-1'></i> Sıfırla
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Sonuçlar -->
                    <div class="table-responsive">
                        <table class="table table-hover border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>Ref No</th>
                                    <th>Müşteri</th>
                                    <th>Oda</th>
                                    <th>Giriş</th>
                                    <th>Çıkış</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td><span class="fw-medium">#{{ $reservation->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                    <span class="text-white">{{ substr($reservation->customer->first_name, 0, 1) }}{{ substr($reservation->customer->last_name, 0, 1) }}</span>
                                                </div>
                                                <div>{{ $reservation->customer->first_name }} {{ $reservation->customer->last_name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-info">{{ $reservation->room->room_number }}</span>
                                            <small>{{ $reservation->room->roomType->name }}</small>
                                        </td>
                                        <td>{{ $reservation->check_in->format('d.m.Y') }}</td>
                                        <td>{{ $reservation->check_out->format('d.m.Y') }}</td>
                                        <td><span class="fw-medium">{{ number_format($reservation->total_price, 2) }} ₺</span></td>
                                        <td>
                                            @switch($reservation->status)
                                                @case('pending')
                                                    <span class="badge bg-warning-subtle text-black"><i class='bx bx-time-five me-1'></i> Onay Bekliyor</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge bg-success-subtle text-black"><i class='bx bx-check-circle me-1'></i> Onaylandı</span>
                                                    @break
                                                @case('checked_in')
                                                    <span class="badge bg-info-subtle text-black"><i class='bx bx-log-in me-1'></i> Giriş Yapıldı</span>
                                                    @break
                                                @case('checked_out')
                                                    <span class="badge bg-secondary-subtle text-black"><i class='bx bx-log-out me-1'></i> Çıkış Yapıldı</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger-subtle text-black"><i class='bx bx-x-circle me-1'></i> İptal Edildi</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-label-info"><i class='bx bx-info-circle me-1'></i> {{ $reservation->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>

                                                @if($reservation->status == 'pending')
                                                <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success ms-1">
                                                        <i class="bx bx-check"></i> Onayla
                                                    </button>
                                                </form>
                                                @endif

                                                @if($reservation->status == 'confirmed')
                                                    @php
                                                        $canCheckinToday = now()->startOfDay()->greaterThanOrEqualTo($reservation->check_in->startOfDay());
                                                    @endphp

                                                    @if($canCheckinToday)
                                                        <form action="{{ route('reservations.check-in', $reservation) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-success ms-1" title="Manuel Check-in">
                                                                <i class="bx bx-log-in-circle"></i> Check-in
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="btn btn-sm btn-outline-secondary ms-1 disabled"
                                                              title="Check-in tarihi: {{ $reservation->check_in->format('d.m.Y') }} - Henüz gelmedi">
                                                            <i class="bx bx-clock"></i>
                                                            {{ $reservation->check_in->format('d.m') }}
                                                        </span>
                                                    @endif
                                                @endif

                                                @if($reservation->status == 'checked_in')
                                                <form action="{{ route('reservations.check-out', $reservation) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning ms-1">
                                                        <i class="bx bx-log-out-circle"></i> Check-out
                                                    </button>
                                                </form>
                                                @endif

                                                @if($reservation->status != 'cancelled' && $reservation->status != 'checked_out')
                                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1"
                                                            onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')">
                                                        <i class="bx bx-trash"></i> Sil
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class='bx bx-calendar-x text-secondary mb-2' style='font-size: 3rem;'></i>
                                                <h5 class="mb-1">Rezervasyon Bulunamadı</h5>
                                                <p class="text-muted">Herhangi bir rezervasyon kaydı bulunamadı.</p>
                                                <a href="{{ route('reservations.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class='bx bx-plus me-1'></i> Yeni Rezervasyon Oluştur
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center justify-content-md-between align-items-center mt-4 flex-wrap gap-3">
                        <div class="text-muted">
                            {{ $reservations->total() > 0 ? 'Toplam '.$reservations->total().' rezervasyon gösteriliyor' : '' }}
                        </div>
                        <div class="pagination-container">
                            {{ $reservations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
