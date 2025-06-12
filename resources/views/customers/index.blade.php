<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Müşteriler') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="p-4 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <h5 class="card-title mb-1">Müşteri Yönetimi</h5>
                                        <p class="card-text text-muted">Toplam {{ $customers->total() }} müşteri kaydı</p>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{ route('customers.index') }}" method="GET">
                                            <div class="input-group">
                                                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                                    class="form-control" placeholder="Müşteri ara...">
                                                <button type="submit" class="btn btn-primary px-3">
                                                    <i class='bx bx-search me-1'></i> Ara
                                                </button>
                                                @if(request('search'))
                                                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                                        <i class='bx bx-x'></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="form-text mt-1 ms-1">
                                                <small>Ad, soyad, telefon, e-posta veya kimlik numarası ile arayabilirsiniz</small>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('customers.index') }}" class="btn {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                            <i class='bx bx-list-ul me-1'></i> Tümü
                                        </a>
                                        <a href="{{ route('customers.index', ['filter' => 'recent']) }}" class="btn {{ request('filter') == 'recent' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                            <i class='bx bx-time me-1'></i> Son Eklenenler
                                        </a>
                                        <a href="{{ route('customers.index', ['filter' => 'active']) }}" class="btn {{ request('filter') == 'active' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                            <i class='bx bx-check-circle me-1'></i> Aktif Konaklayanlar
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('customers.index', ['export' => 'excel'] + request()->except('page')) }}" class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class='bx bx-export me-1'></i> Excel'e Aktar
                                    </a>
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class='bx bx-plus me-1'></i> Yeni Müşteri
                                    </a>
                                </div>
                            </div>

                            <!-- Sonuçlar -->
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4" style="width: 50px">ID</th>
                                            <th>Müşteri</th>
                                            <th>İletişim</th>
                                            <th>Kimlik</th>
                                            <th>Son Konaklama</th>
                                            <th class="text-end pe-4">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td class="ps-4 text-muted">#{{ $customer->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm me-3 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                                                            <span class="text-primary fw-bold">{{ substr($customer->first_name, 0, 1) }}</span>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $customer->first_name }} {{ $customer->last_name }}</h6>
                                                            <small class="text-muted">{{ $customer->created_at->format('d.m.Y') }} tarihinde eklendi</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div class="d-flex align-items-center mb-1">
                                                            <i class='bx bx-phone me-2 text-muted'></i>
                                                            <span>{{ $customer->phone }}</span>
                                                        </div>
                                                        @if($customer->email)
                                                            <div class="d-flex align-items-center">
                                                                <i class='bx bx-envelope me-2 text-muted'></i>
                                                                <span>{{ $customer->email }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class='bx bx-id-card me-1'></i> {{ $customer->id_number }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if(isset($customer->reservations) && $customer->reservations->isNotEmpty())
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bx-calendar me-2 text-success'></i>
                                                            <span>{{ $customer->reservations->sortByDesc('check_in')->first()->check_in->format('d.m.Y') }}</span>
                                                        </div>
                                                    @else
                                                        <span class="badge bg-light text-muted">
                                                            <i class='bx bx-calendar-x me-1'></i> Konaklama yok
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group">
                                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-info">
                                                            <i class='bx bx-show'></i>
                                                        </a>
                                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class='bx bx-edit'></i>
                                                        </a>
                                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" 
                                                                onclick="return confirm('Müşteriyi silmek istediğinize emin misiniz?')">
                                                                <i class='bx bx-trash'></i> Sil
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <div class="avatar avatar-lg bg-light rounded-circle mb-3 d-flex align-items-center justify-content-center">
                                                            <i class='bx bx-user-x fs-1 text-muted'></i>
                                                        </div>
                                                        <h6 class="mb-1">Herhangi bir müşteri bulunamadı</h6>
                                                        <p class="text-muted mb-3">Arama kriterlerinize uygun müşteri kaydı bulunmamaktadır.</p>
                                                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                                                            <i class='bx bx-plus me-1'></i> Yeni Müşteri Ekle
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($customers->hasPages())
                                <div class="p-3 border-top d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        {{ $customers->firstItem() ?? 0 }}-{{ $customers->lastItem() ?? 0 }} / {{ $customers->total() }} müşteri gösteriliyor
                                    </div>
                                    <div>
                                        {{ $customers->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
