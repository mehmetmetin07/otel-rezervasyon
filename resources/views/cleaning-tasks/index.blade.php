<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Temizlik Görevleri') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-broom fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Temizlik Görevleri Yönetimi</h5>
                    </div>
                    <a href="{{ route('cleaning-tasks.create') }}" class="btn btn-primary">
                        <i class='bx bx-plus me-1'></i> Yeni Temizlik Görevi
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filtreler -->
                    <form action="{{ route('cleaning-tasks.index') }}" method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Durum</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Tümü</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>İptal Edildi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="date" class="form-label">Tarih</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                    <input type="date" id="date" name="date" value="{{ request('date') }}" class="form-control">
                                </div>
                                <div class="form-text">Belirtilen tarihte planlanan görevler</div>
                            </div>

                            <div class="col-md-4">
                                <label for="search" class="form-label">Arama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-search'></i></span>
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Oda no, personel adı...">
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-filter me-1'></i> Filtrele
                                    </button>
                                    <a href="{{ route('cleaning-tasks.index') }}" class="btn btn-secondary">
                                        <i class='bx bx-reset me-1'></i> Sıfırla
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Sonuçlar -->
                    <div class="table-responsive">
                        <table class="table table-hover border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Oda</th>
                                    <th>Personel</th>
                                    <th>Tarih</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cleaningTasks as $task)
                                    <tr>
                                        <td><span class="fw-medium">#{{ $task->id }}</span></td>
                                        <td>
                                            <span class="badge bg-label-dark text-dark">{{ $task->room->room_number }}</span>
                                        </td>
                                        <td>
                                            @if($task->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                        <span class="text-white">{{ substr($task->user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>{{ $task->user->name }}</div>
                                                </div>
                                            @else
                                                <span class="text-muted">Atanmadı</span>
                                            @endif
                                        </td>
                                        <td>{{ $task->scheduled_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @switch($task->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark"><i class='bx bx-time me-1'></i>Bekliyor</span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="badge bg-info text-white"><i class='bx bx-loader-alt me-1'></i>Devam Ediyor</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success"><i class='bx bx-check me-1'></i>Tamamlandı</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger"><i class='bx bx-x me-1'></i>İptal Edildi</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $task->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('cleaning-tasks.show', $task) }}" class="btn btn-sm btn-outline-primary" title="Görüntüle">
                                                    <i class="bx bx-show"></i>
                                                </a>

                                                @if($task->status != 'completed' && $task->status != 'cancelled')
                                                <a href="{{ route('cleaning-tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary" title="Düzenle">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                @endif

                                                @if($task->status == 'pending')
                                                <form action="{{ route('cleaning-tasks.start', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Başlat">
                                                        <i class="bx bx-play"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                @if($task->status == 'in_progress')
                                                <form action="{{ route('cleaning-tasks.complete', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Tamamla">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                @if($task->status != 'completed' && $task->status != 'cancelled')
                                                <form action="{{ route('cleaning-tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="İptal Et" onclick="return confirm('Bu temizlik görevini iptal etmek istediğinize emin misiniz?')">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class='bx bx-broom text-secondary mb-2' style='font-size: 3rem;'></i>
                                                <h5 class="mb-1">Temizlik Görevi Bulunamadı</h5>
                                                <p class="text-muted">Herhangi bir temizlik görevi kaydı bulunamadı.</p>
                                                <a href="{{ route('cleaning-tasks.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class='bx bx-plus me-1'></i> Yeni Temizlik Görevi Oluştur
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
                            {{ $cleaningTasks->total() > 0 ? 'Toplam '.$cleaningTasks->total().' temizlik görevi gösteriliyor' : '' }}
                        </div>
                        <div class="pagination-container">
                            {{ $cleaningTasks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
