<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight d-flex align-items-center">
                <i class='bx bx-user-circle me-2 text-primary'></i> {{ __('Müşteri Detayları') }}
                <span class="badge bg-primary-subtle text-primary ms-2 rounded-pill px-3">#{{ $customer->id }}</span>
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-edit me-1'></i> {{ __('Düzenle') }}
                </a>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center">
                    <i class='bx bx-arrow-back me-1'></i> {{ __('Geri Dön') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row">
                <!-- Müşteri Bilgileri -->
                <div class="col-md-8 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-user fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Müşteri Bilgileri</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-user-pin text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Ad Soyad</div>
                                            <div class="fw-medium">{{ $customer->full_name }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-id-card text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">T.C. Kimlik / Pasaport No</div>
                                            <div class="fw-medium">{{ $customer->identity_number }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-phone text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Telefon</div>
                                            <div class="fw-medium">{{ $customer->phone }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-envelope text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">E-posta</div>
                                            <div class="fw-medium">{{ $customer->email ?? 'Belirtilmemiş' }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-map text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Adres</div>
                                            <div class="fw-medium">{{ $customer->address ?? 'Belirtilmemiş' }}</div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                            <i class='bx bx-calendar text-primary'></i>
                                        </div>
                                        <div>
                                            <div class="text-muted small">Kayıt Tarihi</div>
                                            <div class="fw-medium">{{ $customer->created_at->format('d.m.Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($customer->notes)
                                <div class="alert alert-light border d-flex mt-3">
                                    <i class='bx bx-note me-3 fs-5 text-primary'></i>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Notlar</h6>
                                        <p class="mb-0">{{ $customer->notes }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Hızlı İşlemler -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-bolt fs-4 text-primary'></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Hızlı İşlemler</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('reservations.create') }}?customer_id={{ $customer->id }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                                    <i class='bx bx-calendar-plus fs-5'></i>
                                    <span>{{ __('Yeni Rezervasyon Oluştur') }}</span>
                                </a>
                                
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-primary d-flex align-items-center justify-content-center gap-2">
                                    <i class='bx bx-edit fs-5'></i>
                                    <span>{{ __('Müşteri Bilgilerini Düzenle') }}</span>
                                </a>
                                
                                <button type="button" class="btn btn-outline-info d-flex align-items-center justify-content-center gap-2" onclick="window.location.href='mailto:{{ $customer->email }}'">
                                    <i class='bx bx-envelope fs-5'></i>
                                    <span>{{ __('E-posta Gönder') }}</span>
                                </button>

                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="mt-2" onsubmit="return confirm('Bu müşteriyi silmek istediğinizden emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class='bx bx-trash fs-5'></i>
                                        <span>{{ __('Müşteriyi Sil') }}</span>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="alert alert-info d-flex align-items-center mt-4" role="alert">
                                <i class='bx bx-info-circle me-2 fs-5'></i>
                                <div>
                                    Bu müşterinin toplam {{ $customer->reservations->count() }} rezervasyonu bulunmaktadır.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rezervasyon Geçmişi -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center">
                                        <i class='bx bx-history fs-4 text-primary'></i>
                                    </div>
                                    <h5 class="mb-0 fw-semibold">Rezervasyon Geçmişi</h5>
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $customer->reservations->count() }}</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($customer->reservations && $customer->reservations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">#</th>
                                                <th>Oda</th>
                                                <th>Tarih Aralığı</th>
                                                <th>Kişi</th>
                                                <th>Tutar</th>
                                                <th>Durum</th>
                                                <th class="text-end pe-4">İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customer->reservations as $reservation)
                                                <tr>
                                                    <td class="ps-4 fw-medium">{{ $reservation->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                                <i class='bx bx-hotel text-primary'></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $reservation->room->room_number }}</div>
                                                                <div class="text-muted small">{{ $reservation->room->roomType->name }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bx-calendar me-2 text-muted'></i>
                                                            <div>
                                                                <div>{{ $reservation->check_in->format('d.m.Y') }} - {{ $reservation->check_out->format('d.m.Y') }}</div>
                                                                <div class="text-muted small">{{ $reservation->check_in->diffInDays($reservation->check_out) }} gece</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bx-user me-2 text-muted'></i>
                                                            <span>{{ $reservation->adults }} yetişkin, {{ $reservation->children }} çocuk</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold">{{ number_format($reservation->total_price, 2) }} TL</div>
                                                    </td>
                                                    <td>
                                                        @switch($reservation->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning-subtle text-warning">Onay Bekliyor</span>
                                                                @break
                                                            @case('confirmed')
                                                                <span class="badge bg-info-subtle text-info">Onaylandı</span>
                                                                @break
                                                            @case('checked_in')
                                                                <span class="badge bg-success-subtle text-success">Check-in Yapıldı</span>
                                                                @break
                                                            @case('checked_out')
                                                                <span class="badge bg-secondary-subtle text-secondary">Check-out Yapıldı</span>
                                                                @break
                                                            @case('cancelled')
                                                                <span class="badge bg-danger-subtle text-danger">İptal Edildi</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary-subtle text-secondary">{{ $reservation->status }}</span>
                                                        @endswitch
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class='bx bx-dots-vertical-rounded'></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('reservations.show', $reservation) }}"><i class='bx bx-show me-2'></i> Görüntüle</a></li>
                                                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('reservations.edit', $reservation) }}"><i class='bx bx-edit me-2'></i> Düzenle</a></li>
                                                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('reservations.invoice', $reservation) }}"><i class='bx bx-file me-2'></i> Fatura</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info m-4 d-flex align-items-center" role="alert">
                                    <i class='bx bx-info-circle me-2 fs-5'></i>
                                    <div>Bu müşteriye ait rezervasyon bulunamadı.</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
