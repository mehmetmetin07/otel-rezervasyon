<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold d-flex align-items-center">
                <i class='bx bx-calendar-check me-2 text-primary'></i> {{ __('Rezervasyon Detayları') }}
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill px-3">#{{ $reservation->id }}</span>
            </h2>
            <div class="d-flex gap-2">
                @if($reservation->status != 'cancelled' && $reservation->status != 'checked_out')
                    <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                        <i class='bx bx-edit me-1'></i> {{ __('Düzenle') }}
                    </a>
                @endif
                <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row mb-4">
                <!-- Rezervasyon Bilgileri -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-info-circle fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Rezervasyon Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">

                        <div class="row g-4">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <i class='bx bx-id-card text-primary'></i>
                                    </div>
                                    <h6 class="mb-0 fw-semibold">Rezervasyon #{{ $reservation->id }}</h6>
                                    <span class="ms-auto badge bg-{{ $reservation->status == 'confirmed' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'checked_in' ? 'info' : ($reservation->status == 'checked_out' ? 'secondary' : 'danger'))) }}-subtle text-{{ $reservation->status == 'confirmed' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'checked_in' ? 'info' : ($reservation->status == 'checked_out' ? 'secondary' : 'danger'))) }} rounded-pill px-3 py-2">
                                        @switch($reservation->status)
                                            @case('pending')
                                                <i class='bx bx-time-five me-1'></i> Onay Bekliyor
                                                @break
                                            @case('confirmed')
                                                <i class='bx bx-check-circle me-1'></i> Onaylandı
                                                @break
                                            @case('checked_in')
                                                <i class='bx bx-log-in me-1'></i> Giriş Yapıldı
                                                @break
                                            @case('checked_out')
                                                <i class='bx bx-log-out me-1'></i> Çıkış Yapıldı
                                                @break
                                            @case('cancelled')
                                                <i class='bx bx-x-circle me-1'></i> İptal Edildi
                                                @break
                                            @default
                                                {{ $reservation->status }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class='bx bx-calendar text-primary'></i>
                                            </div>
                                            <h6 class="mb-0 fw-semibold">Tarih Bilgileri</h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="small text-muted">Giriş Tarihi</div>
                                                <div class="fw-medium">{{ $reservation->check_in->format('d.m.Y') }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Çıkış Tarihi</div>
                                                <div class="fw-medium">{{ $reservation->check_out->format('d.m.Y') }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Konaklama Süresi</div>
                                                <div class="fw-medium">{{ $reservation->nights }} gece</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Oluşturulma Tarihi</div>
                                                <div class="fw-medium">{{ $reservation->created_at->format('d.m.Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light border-0 h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class='bx bx-group text-primary'></i>
                                            </div>
                                            <h6 class="mb-0 fw-semibold">Misafir Bilgileri</h6>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="small text-muted">Yetişkin Sayısı</div>
                                                <div class="fw-medium">{{ $reservation->adults }} kişi</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Çocuk Sayısı</div>
                                                <div class="fw-medium">{{ $reservation->children }} çocuk</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Toplam Kişi</div>
                                                <div class="fw-medium">{{ $reservation->adults + $reservation->children }} kişi</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="small text-muted">Toplam Tutar</div>
                                                <div class="fw-medium fs-5 text-success">{{ number_format($reservation->total_price, 2) }} TL</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($reservation->special_requests)
                            <div class="col-md-12 mt-3">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                <i class='bx bx-message-detail text-primary'></i>
                                            </div>
                                            <h6 class="mb-0 fw-semibold">Özel İstekler</h6>
                                        </div>
                                        <p class="mb-0 ps-4">{{ $reservation->special_requests }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 mt-3">
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-hotel text-primary'></i>
                                        </div>
                                        <h6 class="mb-0 fw-semibold">Oda Bilgileri</h6>
                                        <a href="{{ route('rooms.show', $reservation->room) }}" class="ms-auto btn btn-sm btn-outline-primary rounded-pill">
                                            <i class='bx bx-show me-1'></i> Oda Detayları
                                        </a>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-3 col-6">
                                            <div class="small text-muted">Oda Numarası</div>
                                            <div class="fw-medium">{{ $reservation->room->room_number }}</div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="small text-muted">Kat</div>
                                            <div class="fw-medium">{{ $reservation->room->floor }}. Kat</div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="small text-muted">Oda Tipi</div>
                                            <div class="fw-medium">{{ $reservation->room->roomType->name }}</div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="small text-muted">Gecelik Fiyat</div>
                                            <div class="fw-medium">{{ number_format($reservation->room->roomType->base_price, 2) }} TL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>

                <!-- Müşteri Bilgileri ve İşlemler -->
                <div class="col-md-4">
                    <!-- Müşteri Bilgileri -->
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
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-lg bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bxs-user text-primary fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $reservation->customer->full_name }}</h6>
                                    <p class="mb-0 text-muted small">{{ $reservation->customer->email }}</p>
                                </div>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                                    <span class="text-muted">T.C. Kimlik / Pasaport</span>
                                    <span class="fw-medium">{{ $reservation->customer->id_number }}</span>
                                </div>
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                                    <span class="text-muted">Telefon</span>
                                    <span class="fw-medium">{{ $reservation->customer->phone }}</span>
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

                    <!-- İşlemler -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-cog fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">İşlemler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-2">
                                @if($reservation->status == 'pending')
                                    <form action="{{ route('reservations.confirm', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success d-flex align-items-center justify-content-center">
                                            <i class='bx bx-check-circle me-2'></i> {{ __('Rezervasyonu Onayla') }}
                                        </button>
                                    </form>
                                @endif

                                @if($reservation->status == 'confirmed')
                                    @php
                                        $canCheckinToday = now()->startOfDay()->greaterThanOrEqualTo($reservation->check_in->startOfDay());
                                    @endphp

                                    @if($canCheckinToday)
                                        <form action="{{ route('reservations.check-in', $reservation) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-info d-flex align-items-center justify-content-center">
                                                <i class='bx bx-log-in-circle me-2'></i> {{ __('Manuel Check-in Yap') }}
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-warning d-flex align-items-center">
                                            <i class='bx bx-info-circle me-2'></i>
                                            <small>
                                                Check-in tarihi henüz gelmedi.<br>
                                                Check-in tarihi: {{ $reservation->check_in->format('d.m.Y') }}<br>
                                                Otomatik check-in o tarihte yapılacak.
                                            </small>
                                        </div>
                                    @endif
                                @endif

                                @if($reservation->status == 'checked_in')
                                    <form action="{{ route('reservations.check-out', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-secondary d-flex align-items-center justify-content-center">
                                            <i class='bx bx-log-out-circle me-2'></i> {{ __('Check-out Yap') }}
                                        </button>
                                    </form>
                                @endif

                                @if($reservation->status != 'cancelled' && $reservation->status != 'checked_out')
                                    <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                                        <i class='bx bx-edit me-2'></i> {{ __('Rezervasyonu Düzenle') }}
                                    </a>

                                    <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#cancelReservationModal">
                                        <i class='bx bx-x-circle me-2'></i> {{ __('Rezervasyonu İptal Et') }}
                                    </button>
                                @endif

                                <a href="{{ route('reservations.invoice', $reservation) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center">
                                    <i class='bx bx-printer me-2'></i> {{ __('Fatura Yazdır') }}
                                </a>
                            </div>
                        </div>
                    </div>

                            @if($reservation->status != 'cancelled' && $reservation->status != 'checked_out')
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')">
                                        {{ __('Rezervasyonu İptal Et') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- İptal Etme Modal -->
            <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelReservationModalLabel">Rezervasyon İptali</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                        </div>
                        <div class="modal-body">
                            <p>Rezervasyonu iptal etmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Vazgeç</button>
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Rezervasyonu İptal Et</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
