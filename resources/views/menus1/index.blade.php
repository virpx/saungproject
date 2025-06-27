<x-guest-layout>
    {{-- Container utama dengan background gelap untuk seluruh halaman menu --}}
    <div class="bg-gray-900 text-gray-200 py-5">

        <section class="bg-gray-800 text-gray-100 rounded-3 p-5 mb-5 mx-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1 class="fw-bold display-4 mb-3">Katalog Menu Restoran</h1>
                        <p class="lead text-gray-300">Temukan berbagai pilihan menu makanan dan minuman favorit. Scroll ke bawah untuk melihat semua kategori yang tersedia!</p>
                        <a href="#menu-list" class="btn btn-warning fw-bold px-4 py-2 mt-2">Lihat Semua <i class="fas fa-arrow-down ms-2"></i></a>
                    </div>
                    <div class="col-md-5 text-center d-none d-md-block">
                        <img src="{{ url('images/user-listing-images-removebg-preview-2.png') }}" class="img-fluid" alt="Hero Image" />
                    </div>
                </div>
            </div>
        </section>

       <div id="recommended-menu">
            @if(isset($recommendedItems) && $recommendedItems->isNotEmpty())
                @include('components.recommended-items', ['recommendedItems' => $recommendedItems])
            @else
                <p>No recommendations available at this time.</p>
            @endif
        </div>

        <div class="col-md-4 d-none d-md-block">
                <div class="sticky-top" style="top: 20px;">
                    {{-- Filter card with dark background --}}
                    <div class="alert alert-primary">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>

                    {{-- Search Form --}}
                    <form action="{{ route('menus.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama menu..." value="{{ request('search') }}">
                            <button class="btn btn-warning" type="submit"><i class="fas fa-search"></i> Cari</button>
                        </div>
                    </form>

                    {{-- Category Filter --}}
                    <div class="card bg-gray-800 text-gray-200 p-4 rounded-3">
                        <h5 class="fw-semibold mb-3">Filter Kategori</h5>
                        <form method="GET" action="{{ route('menus.index') }}">
                            @foreach ($categories as $category)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                                    {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-warning btn-sm mt-3 w-100">Terapkan Filter</button>
                        </form>
                    </div>
                </div>
            </div>



                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="card mt-4 p-4 rounded-3 bg-gray-800 text-gray-200">
                                    <h5 class="fw-semibold mb-3"><i class="fas fa-shopping-cart me-2 text-warning"></i>Keranjang Anda</h5>
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
                        <div class="alert alert-primary">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>
                        <div class="row g-4">
                            @foreach ($menus as $menu)
                                <div class="col-md-6">
                                    {{-- Card menu dengan background gelap dan border tipis --}}
                                    <div class="card h-100 bg-gray-800 text-light border border-secondary">
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
                                                        <i class="fas fa-plus"></i> Pesan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



<style>
    /* Efek hover pada tombol Pesan */
.btn-add-to-cart {
    transition: all 0.3s ease-in-out;
}

.btn-add-to-cart:hover {
    background-color: #f39c12;
    transform: scale(1.05);
}

/* Efek hover pada kartu menu */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Animasi untuk Owl Carousel */
.owl-carousel .item {
    padding: 15px;
    transition: transform 0.3s ease;
}

.owl-carousel .item:hover {
    transform: scale(1.05);
}

    /* Efek hover pada tombol Pesan */
.hover-effect {
    transition: all 0.3s ease-in-out;
}

.hover-effect:hover {
    background-color: #f39c12;
    transform: scale(1.05);
}

/* Efek hover pada kartu menu */
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

/* Styling untuk Owl Carousel */
.owl-carousel .item {
    padding: 15px;
    transition: transform 0.3s ease;
}

.owl-carousel .item:hover {
    transform: scale(1.05);
}

/* Customisasi warna background */
.bg-gray-800 {
    background-color: #2e2e2e;
}

.text-gray-300 {
    color: #b0b0b0;
}

.text-gray-100 {
    color: #f1f1f1;
}

.text-warning {
    color: #f39c12;
}

.card-title {
    font-weight: bold;
    color: #f39c12;
}

/* Menambahkan efek shadow pada kartu */
.card {
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

</style>

{{-- Tambahkan script JS untuk inisialisasi Owl Carousel di bagian akhir body --}}
@push('scripts')
@push('scripts')
        <script>
            $(document).ready(function() {
                // Inisialisasi Owl Carousel untuk rekomendasi menu
                $(".recommended-carousel").owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true,
                    responsive: {
                        0: { items: 1 },
                        576: { items: 2 },
                        768: { items: 3 },
                        992: { items: 4 },
                        1200: { items: 5 }
                    }
                });

                // AJAX untuk mendapatkan rekomendasi menu setelah memilih item
                $('.btn-add-to-cart').on('click', function(e) {
                    e.preventDefault();
                    var menuId = $(this).data('id');

                    $.ajax({
                        url: '/get-recommended-items/' + menuId,
                        method: 'GET',
                        success: function(response) {
                            $('#recommended-menu').html(response.html);
                        },
                        error: function() {
                            console.log('Terjadi kesalahan saat memuat menu rekomendasi');
                        }
                    });
                });
            });

            $('.btn-add-to-cart').on('click', function(e) {
                e.preventDefault();
                var menuId = $(this).data('id');
                
                $.ajax({
                    url: '/get-recommended-items/' + menuId,
                    method: 'GET',
                    success: function(response) {
                        $('#recommended-menu').html(response.html);
                    },
                    error: function() {
                        console.log('Error fetching recommended items');
                    }
                });
            });

        </script>
    @endpush
</x-guest-layout>




                <!-- code lama
<x-guest-layout>
    {{-- Container utama dengan background gelap untuk seluruh halaman menu --}}
    <div class="bg-gray-900 text-gray-200 py-5">

        <section class="bg-gray-800 text-gray-100 rounded-3 p-5 mb-5 mx-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1 class="fw-bold display-4 mb-3">Katalog Menu Restoran</h1>
                        <p class="lead text-gray-300">Temukan berbagai pilihan menu makanan dan minuman favorit. Scroll ke bawah untuk melihat semua kategori yang tersedia!</p>
                        <a href="#menu-list" class="btn btn-warning fw-bold px-4 py-2 mt-2">Lihat Semua <i class="fas fa-arrow-down ms-2"></i></a>
                    </div>
                    <div class="col-md-5 text-center d-none d-md-block">
                        <img src="{{ url('images/user-listing-images-removebg-preview-2.png') }}" class="img-fluid" alt="Hero Image" />
                    </div>
                </div>
            </div>
        </section>

        @if(isset($recommendedItems) && $recommendedItems->isNotEmpty())
        <section class="recommended-menu-section py-5">
            <div class="container">
                <h3 class="fw-bold mb-4 text-gray-100 text-center">Menu yang Mungkin Anda Suka</h3>
                {{-- Start Owl Carousel Wrapper --}}
                <div class="owl-carousel owl-theme recommended-carousel">
                    @foreach($recommendedItems as $item)
                        <div class="item"> {{-- Setiap item carousel harus memiliki class 'item' --}}
                            <div class="card h-100 shadow-sm border-0 bg-gray-800 text-light">
                                {{-- Pastikan path 'image' benar. Jika Anda menyimpan di storage, gunakan Storage::url() --}}
                                <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height:160px;object-fit:cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-warning">{{ $item->name }}</h5>
                                    <p class="card-text text-gray-300 mb-2 flex-grow-1">{{ Str::limit($item->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="fw-bold text-warning">Rp {{ number_format($item->price,0,',','.') }}</span>
                                        {{-- Tombol ini akan menambahkan item rekomendasi ke keranjang --}}
                                        <form action="{{ route('menus.addToCart', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold">Pesan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- End Owl Carousel Wrapper --}}
            </div>
        </section>
        @endif

        {{-- Daftar menu dengan filter dan pencarian --}}

        <section id="menu-list" class="mt-4">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-4 d-none d-md-block">
                        <div class="sticky-top" style="top: 20px;">
                            {{-- Filter card dengan background gelap --}}
                            <div class="alert alert-primary">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>
                            {{-- Form Pencarian --}}
                        <form action="{{ route('menus.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama menu..." value="{{ request('search') }}">
                                <button class="btn btn-warning" type="submit"><i class="fas fa-search"></i> Cari</button>
                            </div>
                        </form>
                            {{-- Filter Kategori --}}
                            <div class="card bg-gray-800 text-gray-200 p-4 rounded-3">
                                <h5 class="fw-semibold mb-3">Filter Kategori</h5>
                                <form method="GET" action="{{ route('menus.index') }}">
                                    @foreach ($categories as $category)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" id="category-{{ $category->id }}"
                                                {{ (isset($selectedCategories) && in_array($category->id, $selectedCategories)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-warning btn-sm mt-3 w-100">Terapkan Filter</button>
                                </form>
                            </div>

                            @if(session('cart') && count(session('cart')) > 0)
                                <div class="card mt-4 p-4 rounded-3 bg-gray-800 text-gray-200">
                                    <h5 class="fw-semibold mb-3"><i class="fas fa-shopping-cart me-2 text-warning"></i>Keranjang Anda</h5>
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
                        <div class="alert alert-primary">Terdapat total <strong>{{ $menus->count() }}</strong> menu yang tersedia</div>
                        <div class="row g-4">
                            @foreach ($menus as $menu)
                                <div class="col-md-6">
                                    {{-- Card menu dengan background gelap dan border tipis --}}
                                    <div class="card h-100 bg-gray-800 text-light border border-secondary">
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
                                                        <i class="fas fa-plus"></i> Pesan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-guest-layout>

{{-- Tambahkan script JS untuk inisialisasi Owl Carousel di bagian akhir body --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $(".recommended-carousel").owlCarousel({
            loop: false, // Set ke true jika ingin looping tak terbatas
            margin: 20, // Jarak antar item
            nav: true, // Menampilkan navigasi (panah kiri/kanan)
            dots: false, // Menampilkan indikator titik
            responsive: {
                0: {
                    items: 1 // Tampilkan 1 item di layar sangat kecil
                },
                576: {
                    items: 2 // Tampilkan 2 item di layar kecil (sm)
                },
                768: {
                    items: 3 // Tampilkan 3 item di layar sedang (md)
                },
                992: {
                    items: 4 // Tampilkan 4 item di layar besar (lg)
                },
                1200: {
                    items: 5 // Tampilkan 5 item di layar ekstra besar (xl)
                }
            },
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"] // Ikon untuk navigasi
        });
    });
</script>
@endpush -->