<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Styles -->
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, #38bdf8 60%, #38f9d7 100%);
            color: white;
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 30px;
            z-index: 1000;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease;
        }

        .sidebar .sidebar-header {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .sidebar .menu-item {
            padding: 14px 20px;
            margin-bottom: 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
            color: white;
        }

        .sidebar .menu-item:hover {
            background-color: #1a1a2e;
            color: #38bdf8;
        }

        .sidebar .menu-item svg {
            margin-right: 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            background: #f7f8fc;
            padding: 20px;
            min-height: 100vh;
            transition: margin-left 0.3s;
        }

        /* Header */
        .header {
            background-color: rgba(255, 255, 255, 0.9);
            color: #2d3748;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 600;
        }

        .header .user-name {
            font-size: 16px;
            color: #38bdf8;
            font-weight: 600;
        }

        /* Dropdown */
        .dropdown-menu {
            background: white;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 10px 20px;
            position: absolute;
            top: 50px;
            right: 0;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
        }

        .dropdown-item {
            padding: 10px;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f4f4f4;
        }

        /* Alert */
        .alert {
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #e6fffa;
            color: #2c7a7b;
        }

        .alert-danger {
            background-color: #fff5f5;
            color: #e53e3e;
        }

        .alert-warning {
            background-color: #fffaf0;
            color: #d69e2e;
        }

        /* Button */
        .btn-primary {
            background-color: #38bdf8;
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1c3d56;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .sidebar.open {
                width: 250px;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .header {
                padding: 15px;
                display: block;
            }

            .sidebar .menu-item {
                padding: 12px;
                font-size: 14px;
            }

            .dropdown-menu {
                right: 10px;
                top: 60px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="flex-col w-full md:flex md:flex-row md:min-h-screen dark:bg-gray-600">
        <div @click.away="open = false"
            class="flex flex-col flex-shrink-0 w-full text-gray-700 bg-slate-100 md:w-64 dark:text-gray-200 dark:bg-gray-800"
            x-data="{ open: false }">
            <div class="flex flex-row items-center justify-between flex-shrink-0 px-8 py-4">
                <a href="#"
                    class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark:text-white focus:outline-none focus:shadow-outline">Dashboard Admin</a>
                <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path x-show="!open" fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Tombol Update Rekomendasi Menu -->
                @if(auth()->user()->is_admin) <!-- Pastikan hanya admin yang dapat melihat tombol ini -->
                    <form action="{{ route('admin.update-recommendations') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Perbarui Rekomendasi Menu</button>
                    </form>
                @endif
            <nav :class="{'block': open, 'hidden': !open}"
                class="flex-grow px-4 pb-4 md:block md:pb-0 md:overflow-y-auto">
                <x-admin-nav-link :href="route('admin.update-recommendations')" :active="request()->routeIs('admin.update-recommendations')">
                    {{ __('Update Rekomendasi Menu') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.index')">
                    {{ __('Orders') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.index')">
                    {{ __('Tables') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.index')">
                    {{ __('Reservations') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.index')">
                    {{ __('Transaksi Pembayaran') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.koki.index')" :active="request()->routeIs('admin.koki.index')">
                    {{ __('Koki') }}
                </x-admin-nav-link>
                <x-admin-nav-link :href="route('admin.blog.index')" :active="request()->routeIs('admin.blog.index')">
                    {{ __('Informasi') }}
                </x-admin-nav-link>
                <div @click.away="open = false" class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark:bg-transparent dark:focus:text-white dark:hover:text-white dark:focus:bg-gray-600 dark:hover:bg-gray-600 md:block hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                        <span>{{ Auth::user()->name }}</span>
                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}"
                            class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-700">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <main class="m-2 p-8 w-full">
            <div>
                @if (session()->has('danger'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('danger') }}!</span>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('success') }}!</span>
                    </div>
                @endif
                @if (session()->has('warning'))
                    <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800"
                        role="alert">
                        <span class="font-medium">{{ session()->get('warning') }}!</span>
                    </div>
                @endif
            </div>
            {{ $slot }}
            <!-- Notifikasi setelah aksi di sidebar -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
        </main>
    </div>
    </body>
</html>
