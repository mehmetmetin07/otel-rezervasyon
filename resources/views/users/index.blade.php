<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kullanıcı Yönetimi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center">
                        <i class='bx bxs-user-account fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Kullanıcı Yönetimi</h5>
                    </div>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class='bx bx-user-plus me-1'></i> Yeni Kullanıcı Ekle
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover border-top">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı</th>
                                    <th>E-posta</th>
                                    <th>Rol</th>
                                    <th>Kayıt Tarihi</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td><span class="fw-medium">#{{ $user->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                                    <span class="text-white">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                                <div>{{ $user->name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="fw-bold">
                                            @if($user->role)
                                                @if($user->isAdmin())
                                                    <span class="badge bg-primary"><i class='bx bx-crown me-1'></i> {{ $user->role->name }}</span>
                                                @elseif($user->isReceptionist())
                                                    <span class="badge bg-info"><i class='bx bx-id-card me-1'></i> {{ $user->role->name }}</span>
                                                @else
                                                    <span class="badge bg-success"><i class='bx bx-broom me-1'></i> {{ $user->role->name }}</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary"><i class='bx bx-user me-1'></i> Rol Atanmamış</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-edit-alt me-1"></i> Düzenle
                                                </a>
                                                @if(Auth::id() != $user->id)
                                                <a href="#" class="btn btn-sm btn-outline-danger" 
                                                   onclick="event.preventDefault(); if(confirm('Kullanıcıyı silmek istediğinize emin misiniz?')) document.getElementById('delete-user-{{ $user->id }}').submit();">
                                                    <i class="bx bx-trash me-1"></i> Sil
                                                </a>
                                                <form id="delete-user-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class='bx bx-user-x text-secondary mb-2' style='font-size: 3rem;'></i>
                                                <h5 class="mb-1">Kullanıcı Bulunamadı</h5>
                                                <p class="text-muted">Herhangi bir kullanıcı kaydı bulunamadı.</p>
                                                <a href="{{ route('register') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class='bx bx-user-plus me-1'></i> Yeni Kullanıcı Oluştur
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
