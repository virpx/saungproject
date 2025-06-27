<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Saung DMS Restaurant') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('app/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.2/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.2/dist/js/splide.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #232526 0%, #1a1a2e 100%);
            color: #e0e0e0;
        }
        .navbar, .bg-white, .card, .rounded-md, .shadow-lg, .bg-gray-800 {
            background-color: #232526 !important;
            color: #e0e0e0 !important;
        }
        .border-bottom, .border-t, .border-gray-200 {
            border-color: #2d3748 !important;
        }
        .btn-warning {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #232526 !important;
            border: none;
        }
        .btn-warning:hover {
            background: linear-gradient(90deg, #38f9d7 0%, #43e97b 100%);
            color: #232526 !important;
        }
        .footer-dark {
            background: linear-gradient(90deg, #232526 0%, #0f2027 100%);
            color: #e0e0e0;
        }
        .card-img-top {
            object-fit: cover;
            height: 180px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark d-block d-sm-block d-md-block d-lg-none py-3 border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                <img src="{{ asset('images/logo.jpg') }}" alt="Restaurant Logo" class="h-10 w-10 rounded-circle">
                <span class="ms-2">🍣 Restawrant</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"> Restawrant</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body" style="margin-top: -24px">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <hr />
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#tentang-kami">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('menus.index') }}">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/reservation/step-one') }}">Reservasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('koki.login') }}">Koki</a>
                        </li>
                    </ul>
                    <hr />
                    <div class="d-grid gap-2">
                        <button class="btn btn-warning text-dark me-2 px-5 fw-500"
                        type="button"
                        onclick="location.href='{{ url('/reservation/step-one') }}'">
                        <i class="fas fa-calendar-plus"></i> &nbsp; &nbsp; Buat Reservasi
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <nav class="py-1 border-bottom d-none d-sm-none d-md-none d-lg-block" style="background: #232526;">
        <div class="container d-flex flex-wrap fs-15">
            <ul class="nav me-auto">
                <li class="nav-item me-2">
                    <a href="/" class="nav-link link-light px-2 active" aria-current="page">Beranda</a>
                </li>
                <li class="nav-item me-2">
                    <a href="/#tentang-kami" class="nav-link link-light px-2">Tentang Kami</a>
                </li>
                <li class="nav-item me-2">
                    <a  href="{{ route('blog.index') }}" class="nav-link link-light px-2">Blog</a>
                </li>
                <li class="nav-item me-2">
                    <a href="{{ route('menus.index') }}" class="nav-link link-light px-2">Order Menu</a>
                </li>
                <li class="nav-item me-2">
                    <a href="{{ url('/reservation/step-one') }}" class="nav-link link-light px-2">Reservasi</a>
                </li>
                <li class="nav-item me-2">
                    <a  href="{{ route('koki.login') }}" class="nav-link link-light px-2">Koki</a>
                </li>
            </ul>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link link-light px-2 no-effect-hover">Nomor Telepon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-light px-2 no-effect-hover">|</a>
                </li>
                <li class="nav-item">
                    <a href="https://wa.me/+628123456789" class="nav-link link-light px-2" target="_blank">
                        +628123456789</a>
                </li>
                <li class="nav-item">
                    <a href="https://wa.me/+628987654321" target="_blank"
                        class="nav-link link-light px-2">+628987654321</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="py-3 mb-4 border-bottom d-none d-sm-none d-md-none d-lg-block" style="background: #1a1a2e;">
        <div class="container d-flex flex-wrap justify-content-between">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-light text-decoration-none">
                <img src="{{ asset('images/logo.jpg') }}" alt="Restaurant Logo" class="h-10 w-10 rounded-circle">
                <span class="fs-3 fw-bold ms-2" style="font-family: 'Pacifico', cursive;">Saung DMS Restaurant</span>
            </a>
            <a href="{{ url('/reservation/step-one') }}" class="btn btn-warning text-dark me-2 px-5 fw-500">
                <i class="fas fa-calendar-plus"></i> &nbsp; &nbsp; Buat Reservasi
            </a>
        </div>
    </header>

    <div class="font-sans min-h-screen" style="background: linear-gradient(135deg, #232526 0%, #1a1a2e 100%); color: #e0e0e0;">
        {{ $slot }}
    </div>
    <footer class="footer-dark border-t border-gray-200 mt-4">
        <div class="container flex flex-wrap items-center justify-center px-4 py-8 mx-auto lg:justify-between">
            <div class="flex flex-wrap justify-center">
                <ul class="flex items-center space-x-4">
                    <li>Home</li>
                    <li>About</li>
                    <li>Contact</li>
                    <li>Terms</li>
                </ul>
            </div>
            <div class="flex justify-center mt-4 lg:mt-0">
                <a>
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="w-6 h-6 text-blue-400" viewBox="0 0 24 24">
                        <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                    </svg>
                </a>
                <a class="ml-3">
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="w-6 h-6 text-blue-300" viewBox="0 0 24 24">
                        <path
                            d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                        </path>
                    </svg>
                </a>
                <a class="ml-3">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" class="w-6 h-6 text-pink-400" viewBox="0 0 24 24">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                    </svg>
                </a>
                <a class="ml-3">
                    <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="0" class="w-6 h-6 text-blue-500" viewBox="0 0 24 24">
                        <path stroke="none"
                            d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z">
                        </path>
                        <circle cx="4" cy="4" r="2" stroke="none"></circle>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo2vPg/ytAnq64jdfhADjExgXQpYM6+FvJtLk9tPfxoKefg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiVcyLNXBt5mdQ0LwPOh3jCxdMTdo+9fdUsxrwK5pnGefAbQKGK49c3sS4WGBV7ImwnlcPmSTFw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')
</body>
</html>