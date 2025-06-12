<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class='bx bxs-hotel me-1'></i>
            ÖnBüro
        </a>

        <!-- Hamburger Butonu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menü Linkleri -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class='bx bxs-dashboard me-1'></i> Dashboard
                    </a>
                </li>

                <!-- Otel Yönetimi Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bxs-business me-1'></i> Otel Yönetimi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reservations.index') }}">Rezervasyonlar</a></li>
                        <li><a class="dropdown-item" href="{{ route('rooms.index') }}">Odalar</a></li>
                        <li><a class="dropdown-item" href="{{ route('room-types.index') }}">Oda Tipleri</a></li>
                        <li><a class="dropdown-item" href="{{ route('customers.index') }}">Müşteriler</a></li>
                    </ul>
                </li>

                <!-- Operasyonlar Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-task me-1'></i> Operasyonlar
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('rooms.calendar') }}">Oda Takvimi</a></li>
                        <li><a class="dropdown-item" href="{{ route('cleaning-tasks.index') }}">Temizlik Görevleri</a></li>
                        <li><a class="dropdown-item" href="{{ route('room-requests.index') }}">Oda İstekleri</a></li>
                    </ul>
                </li>

                <!-- Raporlar ve Analizler -->
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class='bx bxs-report me-1'></i> Raporlar
                    </a>
                </li>
                @endif

                <!-- Sistem Ayarları Dropdown -->
                @if(Auth::user()->isAdmin())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bxs-cog me-1'></i> Sistem
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Kullanıcılar</a></li>
                        <li><a class="dropdown-item" href="{{ route('activity-logs.index') }}">Aktivite Logları</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('hotel-settings.index') }}">Otel Ayarları</a></li>
                        <li><a class="dropdown-item" href="{{ route('email-template-settings.index') }}">Email Ayarları</a></li>
                        <li><a class="dropdown-item" href="{{ route('cron-job-settings.index') }}">Cron Job Ayarları</a></li>
                    </ul>
                </li>
                @endif
            </ul>

            <!-- Sağ Kullanıcı Menüsü -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class='bx bxs-user-circle me-1'></i> Profil & SMTP</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class='bx bx-log-out me-1'></i> Çıkış Yap
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
