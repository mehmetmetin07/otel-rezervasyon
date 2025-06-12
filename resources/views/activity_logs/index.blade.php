<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aktivite Günlükleri') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- İstatistik Kartları -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center bg-primary bg-gradient text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class='bx bx-list-ul fs-2 opacity-75'></i>
                                </div>
                                <div>
                                    <p class="text-light mb-1">Toplam Kayıt</p>
                                    <h3 class="mb-0 fw-bold">{{ $activityLogs->total() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center bg-success bg-gradient text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class='bx bx-plus-circle fs-2 opacity-75'></i>
                                </div>
                                <div>
                                    <p class="text-light mb-1">Oluşturma</p>
                                    <h3 class="mb-0 fw-bold">{{ $uniqueActions->filter(fn($action) => $action == 'created')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center bg-warning bg-gradient text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class='bx bx-edit fs-2 opacity-75'></i>
                                </div>
                                <div>
                                    <p class="text-light mb-1">Güncelleme</p>
                                    <h3 class="mb-0 fw-bold">{{ $uniqueActions->filter(fn($action) => $action == 'updated')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body text-center bg-info bg-gradient text-white">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <i class='bx bx-time fs-2 opacity-75'></i>
                                </div>
                                <div>
                                    <p class="text-light mb-1">Bugün</p>
                                    <h3 class="mb-0 fw-bold">{{ $activityLogs->where('created_at', '>=', today())->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtreler -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class='bx bx-filter-alt text-primary me-2'></i>
                        Filtreler
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('activity-logs.index', ['export' => 'excel'] + request()->except('page')) }}"
                           class="btn btn-success">
                            <i class='bx bx-download me-1'></i>
                            Excel İndir
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">İşlem Türü</label>
                                <select name="action" class="form-select">
                                    <option value="">Tüm İşlemler</option>
                                    <option value="created" @if(request('action') == 'created') selected @endif>Oluşturuldu</option>
                                    <option value="updated" @if(request('action') == 'updated') selected @endif>Güncellendi</option>
                                    <option value="deleted" @if(request('action') == 'deleted') selected @endif>Silindi</option>
                                    <option value="checked_in" @if(request('action') == 'checked_in') selected @endif>Check-in Yapıldı</option>
                                    <option value="checked_out" @if(request('action') == 'checked_out') selected @endif>Check-out Yapıldı</option>
                                    <option value="logged_in" @if(request('action') == 'logged_in') selected @endif>Giriş Yapıldı</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Model Türü</label>
                                <select name="model_type" class="form-select">
                                    <option value="">Tüm Modeller</option>
                                    @foreach($uniqueModelTypes as $model)
                                        @php
                                            $modelName = class_basename($model);
                                            $turkishModelName = match($modelName) {
                                                'Reservation' => 'Rezervasyon',
                                                'Customer' => 'Müşteri',
                                                'Room' => 'Oda',
                                                'User' => 'Kullanıcı',
                                                'CronJobSetting' => 'Cron Job Ayarı',
                                                default => $modelName
                                            };
                                        @endphp
                                        <option value="{{ $model }}" {{ request('model_type') == $model ? 'selected' : '' }}>
                                            {{ $turkishModelName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Başlangıç Tarihi</label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Bitiş Tarihi</label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-9">
                                <label class="form-label">Arama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-search'></i></span>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Kullanıcı adı, açıklama ara..." class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <div class="d-flex gap-2 w-100">
                                    <button type="submit" class="btn btn-primary">
                                        <i class='bx bx-search me-1'></i>
                                        Filtrele
                                    </button>
                                    <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                                        <i class='bx bx-refresh me-1'></i>
                                        Temizle
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tablo -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class='bx bx-table text-primary me-2'></i>
                        Aktivite Kayıtları
                        <span class="badge bg-primary ms-2">{{ $activityLogs->total() }} kayıt</span>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı</th>
                                    <th>İşlem</th>
                                    <th>Model</th>
                                    <th>Açıklama</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activityLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="fw-medium font-monospace">#{{ $log->id }}</span>
                                        </td>
                                        <td>
                                            @if($log->user)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                        <span class="text-white fw-medium">{{ strtoupper(substr($log->user->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $log->user->name }}</div>
                                                        @if($log->user->role)
                                                            <small class="text-muted">{{ $log->user->role->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class='bx bx-cog me-1'></i>
                                                    Sistem
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $actionConfig = match($log->action) {
                                                    'created' => ['bg-success-subtle text-success', 'bx-plus-circle', 'Oluşturma'],
                                                    'updated' => ['bg-primary-subtle text-primary', 'bx-edit-alt', 'Güncelleme'],
                                                    'deleted' => ['bg-danger-subtle text-danger', 'bx-trash', 'Silme'],
                                                    'checked_in' => ['bg-info-subtle text-info', 'bx-log-in', 'Check-in'],
                                                    'checked_out' => ['bg-warning-subtle text-warning', 'bx-log-out', 'Check-out'],
                                                    'logged_in' => ['bg-secondary-subtle text-secondary', 'bx-user', 'Giriş'],
                                                    default => ['bg-light text-dark', 'bx-info-circle', ucfirst($log->action)]
                                                };
                                            @endphp
                                            <span class="badge {{ $actionConfig[0] }}">
                                                <i class='bx {{ $actionConfig[1] }} me-1'></i>
                                                {{ $actionConfig[2] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ class_basename($log->model_type) }}</div>
                                            @if($log->model_id)
                                                <small class="text-muted">#{{ $log->model_id }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="{{ $log->description }}">
                                                {{ $log->description ?? '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $log->created_at->format('d.m.Y') }}</div>
                                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class='bx bx-search-alt-2 text-secondary mb-3' style='font-size: 4rem;'></i>
                                                <h5 class="mb-2">Kayıt Bulunamadı</h5>
                                                <p class="text-muted mb-3">Seçilen kriterlere uygun aktivite kaydı bulunamadı.</p>
                                                <a href="{{ route('activity-logs.index') }}"
                                                   class="btn btn-primary">
                                                    <i class='bx bx-refresh me-1'></i>
                                                    Tüm Kayıtları Göster
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                        <div class="text-muted">
                            Toplam {{ $activityLogs->total() }} kayıttan {{ $activityLogs->firstItem() }}-{{ $activityLogs->lastItem() }} arası gösteriliyor.
                        </div>
                        <div class="pagination-container">
                            {{ $activityLogs->appends(request()->input())->links('vendor.pagination.simple-bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
