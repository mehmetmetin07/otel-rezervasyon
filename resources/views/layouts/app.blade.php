<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Otel Rezervasyon') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css' rel='stylesheet' />

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #0ea5e9;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-color: #f3f4f6;
            --dark-color: #1f2937;
            --border-radius: 0.5rem;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #111827;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            font-weight: 500;
            color: #4b5563 !important;
            transition: all 0.2s ease;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            white-space: nowrap;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(79, 70, 229, 0.05);
            border-radius: 0.375rem;
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
            background-color: rgba(79, 70, 229, 0.1);
            border-radius: 0.375rem;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .btn {
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #6b7280;
            border-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
            border-color: #4b5563;
            transform: translateY(-1px);
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .table th {
            font-weight: 600;
            background-color: #f9fafb;
            border-bottom-width: 1px;
            border-bottom-color: #e5e7eb;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        main {
            flex: 1;
        }

        /* Dropdown menu improvements */
        .dropdown {
            position: relative !important;
        }

        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 0.5rem 0;
            z-index: 9999 !important; /* Çok daha yüksek z-index değeri */
            min-width: 10rem; /* Minimum genişlik */
            max-width: none; /* Maksimum genişlik kısıtlamasını kaldır */
            overflow: visible; /* Taşmaları göster */
            position: absolute !important; /* Kesin pozisyon */
            right: 0 !important; /* Sağa hizala */
            left: auto !important; /* Soldan otomatik */
            top: 100% !important; /* Tetikleyicinin altında */
            transform: none !important; /* Dönüşüm yok */
            margin-top: 0.5rem !important; /* Üst kenar boşluğu */
            background-color: #fff !important; /* Arka plan rengi */
        }

        /* Dropdown menu item styles */
        .dropdown-menu .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
            white-space: nowrap;
            width: 100%;
            display: flex;
            align-items: center;
        }

        /* Tablo hücrelerindeki dropdown menüler için ek stiller */
        .table td .dropdown-menu {
            position: absolute !important;
            right: 0 !important;
            left: auto !important;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s;
            white-space: nowrap; /* Metni tek satırda tut */
            overflow: hidden; /* Taşan metni gizle */
            text-overflow: ellipsis; /* Taşan metni ... ile göster */
            width: 100%; /* Tam genişlik */
            display: block; /* Blok element olarak göster */
        }

        .dropdown-item:hover, .dropdown-item:focus {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-top: 1px solid #e5e7eb;
        }

        /* Form içindeki dropdown itemler için düzeltme */
        .dropdown-menu form {
            width: 100%;
        }

        /* Dropdown menüsünün tablo hücrelerinde düzgün görüntülenmesi için */
        .table td .dropdown {
            position: relative;
        }

        .table td .dropdown-menu {
            right: 0;
            left: auto;
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
    <script src="{{ asset('js/smtp-settings.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js'></script>

    <!-- Bootstrap 5 JavaScript ve Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 bileşenlerini etkinleştirme -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bootstrap 5 dropdown menülerini etkinleştir
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Dropdown'ların düzgün çalışması için event listener ekle
            document.querySelectorAll('.dropdown-toggle').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    var dropdown = bootstrap.Dropdown.getInstance(element);
                    if (dropdown) {
                        dropdown.toggle();
                    } else {
                        new bootstrap.Dropdown(element).toggle();
                    }
                });
            });

            // Bootstrap 5 tooltips'leri etkinleştir
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
                    <img src="{{ asset('images/icon.png') }}" alt="Logo" style="height: 32px; margin-right: 10px;">
                    Otel Yönetim Sistemi
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar (Now Centered) -->
                    <ul class="navbar-nav mx-auto d-flex align-items-center">
                        @auth
                            <li class="nav-item mx-2">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class='bx bx-grid-alt me-1'></i> {{ __('Dashboard') }}
                                </a>
                            </li>

                            <!-- Otel Yönetimi Dropdown -->
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle" href="#" id="otelYonetimiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-building-house me-1'></i> Otel Yönetimi
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="otelYonetimiDropdown">
                                    <li><a class="dropdown-item" href="{{ route('reservations.index') }}"><i class='bx bx-calendar-check me-2'></i>Rezervasyonlar</a></li>
                                    <li><a class="dropdown-item" href="{{ route('rooms.index') }}"><i class='bx bx-door-open me-2'></i>Odalar</a></li>
                                    <li><a class="dropdown-item" href="{{ route('room-types.index') }}"><i class='bx bx-category-alt me-2'></i>Oda Tipleri</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cleaning-tasks.index') }}"><i class='bx bx-brush me-2'></i>Temizlik Görevleri</a></li>
                                </ul>
                            </li>

                            <!-- Operasyonlar Dropdown -->
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle" href="#" id="operasyonlarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-sitemap me-1'></i> Operasyonlar
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="operasyonlarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('room-requests.index') }}"><i class='bx bx-message-alt-detail me-2'></i>İstekler</a></li>
                                    <li><a class="dropdown-item" href="{{ route('reports.index') }}"><i class='bx bx-report me-2'></i>Raporlar</a></li>
                                </ul>
                            </li>

                            @if(Auth::user()->isAdmin())
                            <!-- Sistem Dropdown -->
                            <li class="nav-item dropdown mx-2">
                                <a class="nav-link dropdown-toggle" href="#" id="sistemDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-cog me-1'></i> Sistem
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="sistemDropdown">
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class='bx bx-user me-2'></i>Kullanıcılar</a></li>
                                    <li><a class="dropdown-item" href="{{ route('activity-logs.index') }}"><i class='bx bx-log-in-circle me-2'></i>Aktivite Logları</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cron-job-settings.index') }}"><i class='bx bx-time-five me-2'></i>Cronjob Ayarları</a></li>
                                </ul>
                            </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                        <i class='bx bx-user me-1'></i> Profil
                                    </a>
                                    <a href="#" class="btn btn-outline-danger btn-sm"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class='bx bx-log-out me-1'></i> Çıkış
                                    </a>
                                </div>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class='bx bx-log-out text-danger' style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="modal-title mb-3" id="logoutModalLabel">Çıkış yapmak istediğinize emin misiniz?</h5>
                    <p class="text-muted">Oturumunuz sonlandırılacak ve yeniden giriş yapmanız gerekecek.</p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> İptal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out me-1'></i> Çıkış Yap
                    </button>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
