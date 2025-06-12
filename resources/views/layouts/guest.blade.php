<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Otel Rezervasyon') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
        
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
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-primary:hover {
                background-color: #4338ca;
                border-color: #4338ca;
            }
            
            .text-primary {
                color: var(--primary-color) !important;
            }
            
            .auth-wrapper {
                width: 100%;
                max-width: 450px;
                padding: 2rem 1rem;
            }
            
            .auth-logo {
                margin-bottom: 2rem;
                text-align: center;
            }
            
            .auth-logo a {
                display: inline-block;
                text-decoration: none;
                color: var(--primary-color);
                font-weight: 700;
                font-size: 1.5rem;
            }
            
            .auth-footer {
                text-align: center;
                margin-top: 2rem;
                color: #6b7280;
                font-size: 0.875rem;
            }
            
            .form-control:focus, .form-select:focus, .form-check-input:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
            }
            
            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
        </style>
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="auth-logo">
                <a href="/" class="d-flex align-items-center justify-content-center">
                    <i class='bx bxs-hotel fs-1 me-2'></i>
                    <span>Otel Rezervasyon</span>
                </a>
            </div>
            
            {{ $slot }}
            
            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} Otel Rezervasyon Sistemi. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </body>
</html>
