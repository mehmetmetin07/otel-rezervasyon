@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold d-flex align-items-center">
                <i class='bx bxs-message-alt-detail fs-1 me-2 text-primary'></i>
                İstek Listesi
                <span class="badge bg-primary ms-2 fs-6">{{ $roomRequests->total() }}</span>
            </h1>
            <p class="text-muted">Odalar için oluşturulan istekleri görüntüleyin ve yönetin.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <a href="{{ route('room-requests.create') }}" class="btn btn-primary me-2">
                <i class='bx bx-plus-circle me-1'></i> Yeni İstek Oluştur
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class='bx bx-check-circle me-1'></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-bold"><i class='bx bx-list-ul me-2'></i>Tüm İstekler</h5>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-filter me-1'></i> Filtrele
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="{{ route('room-requests.index', ['status' => 'pending']) }}">Bekleyen İstekler</a></li>
                            <li><a class="dropdown-item" href="{{ route('room-requests.index', ['status' => 'in_progress']) }}">İşlemdeki İstekler</a></li>
                            <li><a class="dropdown-item" href="{{ route('room-requests.index', ['status' => 'completed']) }}">Tamamlanan İstekler</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('room-requests.index') }}">Tümünü Göster</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($roomRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="ps-3">ID</th>
                            <th scope="col">Oda</th>
                            <th scope="col">İstek</th>
                            <th scope="col">Durum</th>
                            <th scope="col">Oluşturulma</th>
                            <th scope="col" class="text-end pe-3">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roomRequests as $request)
                        <tr>
                            <td class="ps-3 fw-bold">#{{ $request->id }}</td>
                            <td>
                                <a href="{{ route('rooms.show', $request->room_id) }}" class="text-decoration-none">
                                    <span class="badge bg-info text-dark">{{ $request->room->room_number }}</span>
                                </a>
                            </td>
                            <td>
                                <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $request->request_content }}
                                </div>
                            </td>
                            <td>
                                @if($request->status == 'pending')
                                <span class="badge bg-warning text-dark">Bekliyor</span>
                                @elseif($request->status == 'in_progress')
                                <span class="badge bg-info text-dark">İşlemde</span>
                                @elseif($request->status == 'completed')
                                <span class="badge bg-success">Tamamlandı</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('room-requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="{{ route('room-requests.edit', $request->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $request->id }}">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $request->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $request->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $request->id }}">İsteği Sil</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="mb-4">
                                                    <i class='bx bx-error-circle text-danger' style="font-size: 5rem;"></i>
                                                </div>
                                                <h5 class="mb-3">Bu isteği silmek istediğinize emin misiniz?</h5>
                                                <p class="text-muted">Bu işlem geri alınamaz ve tüm istek verileri silinecektir.</p>
                                            </div>
                                            <div class="modal-footer border-0 pt-0 justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class='bx bx-x me-1'></i> İptal
                                                </button>
                                                <form action="{{ route('room-requests.destroy', $request->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class='bx bx-trash me-1'></i> Evet, Sil
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No Requests" style="width: 120px; height: 120px; opacity: 0.5;">
                <h4 class="mt-3">Henüz İstek Bulunmuyor</h4>
                <p class="text-muted">Odalar için yeni istekler oluşturarak listeyi doldurun.</p>
                <a href="{{ route('room-requests.create') }}" class="btn btn-primary mt-2">
                    <i class='bx bx-plus-circle me-1'></i> Yeni İstek Oluştur
                </a>
            </div>
            @endif
        </div>
        <div class="card-footer bg-white border-0 pt-0">
            <div class="d-flex justify-content-center">
                {{ $roomRequests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
