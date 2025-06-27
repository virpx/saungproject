<x-guest-layout>
    {{-- Container utama dengan background hitam untuk seluruh halaman menu --}}
    <div class="bg-black text-white py-5">

        {{-- Hero section --}}
        <section class="bg-gradient-to-r from-gray-900 via-gray-800 to-black text-white rounded-3xl p-8 mb-5 mx-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1 class="fw-bold text-5xl mb-3 text-white">Katalog Menu Restoran</h1>
                        <p class="lead text-gray-200">Temukan berbagai pilihan menu makanan dan minuman favorit. Scroll ke bawah untuk melihat semua kategori yang tersedia!</p>
                        <a href="#menu-list" class="btn bg-gradient-to-r from-yellow-500 to-orange-500 text-white fw-bold px-6 py-3 mt-2 rounded-lg hover:from-yellow-400 hover:to-orange-400 transition duration-300">Lihat Semua <i class="fas fa-arrow-down ms-2"></i></a>
                    </div>
                    <div class="col-md-5 text-center d-none d-md-block">
                        <img src="{{ url('images/user-listing-images-removebg-preview-2.png') }}" class="img-fluid" alt="Hero Image" />
                    </div>
                </div>
            </div>
        </section>

        {{-- Menu Terbaik di Setiap Kategori --}}
        @if(isset($highestRatedMenus) && !empty($highestRatedMenus))
            <section class="recommended-menu-section py-5 bg-gray-900">
                <div class="container">
                    <h3 class="fw-bold text-4xl mb-4 text-center text-white">Menu Terbaik di Setiap Kategori</h3>
                    <div class="row">
                        @foreach($highestRatedMenus as $menu)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-xl border-0 bg-gradient-to-r from-gray-700 via-gray-800 to-black text-light rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                                    <img src="{{ Storage::url($menu->image) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-warning text-2xl font-bold">{{ $menu->name }}</h5>
                                        <p class="card-text text-gray-300 mb-2 flex-grow-1">{{ Str::limit($menu->description, 60) }}</p>

                                        {{-- Rating dengan bintang --}}
                                        <div class="mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $menu->rating ? 'text-warning' : 'text-gray-400' }}"></i>
                                            @endfor
                                            <span class="text-gray-300">({{ number_format($menu->rating, 1) }})</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="fw-bold text-warning">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                            <form action="{{ route('menus.addToCart', $menu->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm bg-gradient-to-r from-yellow-500 to-orange-500 text-dark fw-bold rounded-lg hover:from-yellow-400 hover:to-orange-400 transition duration-300">Pesan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Rekomendasi Menu Berdasarkan Pilihan Anda --}}
        @if(isset($recommendedItems) && $recommendedItems->isNotEmpty())
            <section class="recommended-menu-section py-5 bg-gray-900">
                <div class="container">
                    <h3 class="fw-bold text-4xl mb-4 text-center text-white">Rekomendasi Menu Berdasarkan Pilihan Anda</h3>
                    <div class="row">
                        @foreach($recommendedItems as $item)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-xl border-0 bg-gradient-to-r from-gray-700 via-gray-800 to-black text-light rounded-xl overflow-hidden transform hover:scale-105 transition duration-300">
                                    <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-warning text-2xl font-bold">{{ $item->name }}</h5>
                                        <p class="card-text text-gray-300 mb-2 flex-grow-1">{{ Str::limit($item->description, 60) }}</p>

                                        {{-- Rating dengan bintang --}}
                                        <div class="mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-gray-400' }}"></i>
                                            @endfor
                                            <span class="text-gray-300">({{ number_format($item->rating, 1) }})</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="fw-bold text-warning">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            <form action="{{ route('menus.addToCart', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm bg-gradient-to-r from-yellow-500 to-orange-500 text-dark fw-bold rounded-lg hover:from-yellow-400 hover:to-orange-400 transition duration-300">Pesan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Daftar menu dengan filter dan pencarian --}}
        <section id="menu-list" class="mt-4">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-4 d-none d-md-block">
                        <div class="sticky-top" style="top: 20px;">
                            {{-- Filter card dengan background cerah --}}
                            <div class="alert alert-primary text-center">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>

                            {{-- Form Pencarian --}}
                            <form action="{{ route('menus.index') }}" method="GET" class="mb-4">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama menu..." value="{{ request('search') }}">
                                    <button class="btn btn-warning" type="submit"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </form>

                            {{-- Filter Kategori --}}
                            <div class="card bg-gray-800 text-gray-200 p-4 rounded-3">
                                <h5 class="fw-semibold mb-3 text-white">Filter Kategori</h5>
                                <form method="GET" action="{{ route('menus.index') }}">
                                    @foreach ($categories as $category)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                                            {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label text-gray-200" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-warning btn-sm mt-3 w-100">Terapkan Filter</button>
                                </form>
                            </div>

                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="card mt-4 p-4 rounded-3 bg-gray-800 text-gray-200">
                                    <h5 class="fw-semibold mb-3 text-white"><i class="fas fa-shopping-cart me-2 text-warning"></i>Keranjang Anda</h5>
                                    <ul class="list-group list-group-flush">
                                        @php $total = 0; @endphp
                                        @foreach (session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity']; @endphp
                                            <li class="list-group-item bg-transparent text-gray-200 border-secondary">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $details['name'] }}</strong><br>
                                                        <small class="text-gray-400">Rp {{ number_format($details['price'], 0, ',', '.') }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <form action="{{ route('menus.decreaseQuantity', $id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-outline-warning" type="submit">-</button>
                                                        </form>
                                                        <span class="mx-2">{{ $details['quantity'] }}</span>
                                                        <form action="{{ route('menus.addToCart', $id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-sm btn-outline-warning" type="submit">+</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="mt-3 text-end">
                                        <strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('menus.checkout') }}" class="btn btn-success w-100">Checkout</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="alert alert-primary text-center">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>
                        <div class="row g-4">
                            @foreach ($menus as $menu)
                                @if($menu->name !== 'Pajak 10%')  <!-- Filter agar menu pajak tidak tampil -->
                                    <div class="col-md-6">
                                        {{-- Card menu dengan background cerah dan border tipis --}}
                                        <div class="card h-100 bg-gray-800 text-light border border-secondary rounded-xl overflow-hidden">
                                            <img src="{{ Storage::url($menu->image) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title fw-bold text-gray-100">{{ $menu->name }}</h5>
                                                <p class="card-text text-gray-300 flex-grow-1">{{ $menu->description }}</p>
                                                <hr class="border-secondary">
                                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                                    <span class="fw-semibold text-warning fs-5">Rp. {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                    <form action="{{ route('menus.addToCart', $menu->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning btn-sm btn-add-to-cart">
                                                            Pesan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        /* Global Styles */
body {
    background-color: #000; /* Hitam untuk latar belakang utama */
    color: #fff; /* Putih untuk teks umum */
    font-family: 'Arial', sans-serif;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #0f172a, #1e293b); /* Gradasi biru tua */
    color: #fff;
    padding: 4rem 2rem;
    border-radius: 1rem;
}

.hero-section h1 {
    font-size: 3rem;
    font-weight: bold;
    color: #fff;
    margin-bottom: 1rem;
}

.hero-section p {
    font-size: 1.25rem;
    color: #d1d5db;
}

.hero-section .btn {
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    font-weight: bold;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.hero-section .btn:hover {
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
}

/* Card Styles for Menu Items */
.card {
    background-color: #1f2937; /* Dark gray background for the card */
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    border-radius: 1rem 1rem 0 0;
    object-fit: cover;
    height: 200px;
}

.card-body {
    padding: 1.5rem;
}

.card-body h5 {
    font-size: 1.25rem;
    color: #fbbf24; /* Yellow color for titles */
    font-weight: bold;
}

.card-body p {
    color: #d1d5db; /* Light gray text */
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.card-body .btn {
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.card-body .btn:hover {
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
}

/* Filter and Cart Styles */
.alert {
    background-color: #1f2937; /* Dark background for alert */
    color: #fff; /* White text for alert */
}

.card-filter {
    background-color: #1f2937; /* Dark background for filter section */
    color: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
}

.card-filter label {
    color: #fff; /* White text for labels */
}

.card-filter button {
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    font-weight: bold;
    border-radius: 0.5rem;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.card-filter button:hover {
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
}

/* Cart Section */
.cart-card {
    background-color: #1f2937;
    color: #fff;
    padding: 1.5rem;
    border-radius: 1rem;
}

.cart-card .btn {
    background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
    color: #fff;
    font-weight: bold;
    padding: 1rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.cart-card .btn:hover {
    background: linear-gradient(90deg, #34d399 0%, #10b981 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        padding: 3rem 1rem;
    }

    .card {
        margin-bottom: 2rem;
    }

    .card img {
        height: 150px; /* Adjust image height for mobile */
    }
}
/* Rekomendasi Menu Section */
.recommended-menu-section {
    background-color: #111; /* Latar belakang hitam untuk bagian rekomendasi */
    padding: 4rem 2rem;
}

/* Card di dalam rekomendasi */
.recommended-menu-section .card {
    background-color: #1f2937; /* Card dengan latar belakang gelap */
    color: #fff; /* Teks putih untuk kontras yang baik */
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Bayangan halus untuk card */
    transition: transform 0.3s ease-in-out;
}

.recommended-menu-section .card:hover {
    transform: scale(1.05); /* Efek zoom saat hover pada card */
}

/* Gambar Card */
.recommended-menu-section .card-img-top {
    object-fit: cover;
    height: 200px;
    border-radius: 1rem 1rem 0 0; /* Menjaga gambar di bagian atas card tetap rapi */
}

/* Judul Card */
.recommended-menu-section .card-body h5 {
    font-size: 1.25rem;
    font-weight: bold;
    color: #fbbf24; /* Warna kuning cerah untuk nama menu */
}

/* Deskripsi Card */
.recommended-menu-section .card-body p {
    color: #d1d5db; /* Warna abu-abu cerah untuk deskripsi */
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

/* Tombol pada Card */
.recommended-menu-section .card-body .btn {
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    color: #fff;
    font-weight: bold;
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    transition: all 0.3s ease;
}

.recommended-menu-section .card-body .btn:hover {
    background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
}

/* Text Section Title */
.recommended-menu-section h3 {
    color: #fff; /* Judul section dengan teks putih */
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
}


    </style>
</x-guest-layout>


@push('scripts')
<script>
    $(document).ready(function() {
        $(".recommended-carousel").owlCarousel({
            loop: false,
            margin: 20,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            },
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"]
        });
    });
</script>
@endpush
