<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Saung DMS Restaurant</title>
     <!-- Fonts & CSS -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('app/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.2/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.2/dist/js/splide.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <
    <style>
        body {
            background: linear-gradient(135deg, #232526 0%, #1a1a2e 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .login-card {
            background: linear-gradient(135deg, #232526 60%, #2d3748 100%);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid #38bdf8;
        }
        .login-title {
            color: #38bdf8;
            font-weight: bold;
        }
        .login-btn {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #232526;
            font-weight: bold;
        }
        .login-btn:hover {
            background: linear-gradient(90deg, #38f9d7 0%, #43e97b 100%);
            color: #232526;
        }
        .input-custom {
            background: #232526;
            color: #e0e0e0;
            border: 1px solid #38bdf8;
        }
        .input-custom:focus {
            border-color: #43e97b;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-8 login-card">
            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.jpg') }}" class="w-16 h-16 rounded-full shadow mb-2" alt="Logo">
                <h1 class="text-2xl login-title mb-1">@yield('title', 'Login')</h1>
                <p class="text-gray-400 text-sm">@yield('subtitle', 'Masuk ke dashboard Saung DMS')</p>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>