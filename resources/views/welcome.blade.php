<x-guest-layout>
    {{-- rekomendasi menu --}}
    <div class="rekomendasi-men py-2">
        <h1 class="font-bold text-3xl text-center mb-8">Menu Rekomendasi Kami</h1>

        @if ($namaMenuRekomendasi->isNotEmpty())
            <div x-data="{ currentIndex: 0 }" class="relative w-full max-w-3xl mx-auto">
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500"
                        :style="'transform: translateX(-' + (currentIndex * 100) + '%)'">
                        @foreach ($namaMenuRekomendasi as $menu)
                            <div class="w-full flex-shrink-0 px-4">
                                <div class="bg-white p-6 rounded-lg shadow text-center">
                                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}"
                                        class="w-48 h-48 mx-auto object-cover rounded-md mb-3" />
                                    <h2 class="text-xl font-semibold text-yellow-500">{{ $menu->name }}</h2>
                                    <p class="text-orange-400 text-lg">
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between mt-4 px-8">
                    <button
                        @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : {{ $namaMenuRekomendasi->count() - 1 }}"
                        class="px-4 py-2 bg-yellow-400 rounded hover:bg-yellow-500">←</button>
                    <button @click="currentIndex = (currentIndex + 1) % {{ $namaMenuRekomendasi->count() }}"
                        class="px-4 py-2 bg-yellow-400 rounded hover:bg-yellow-500">→</button>
                </div>
            </div>
        @endif
    </div>

    <!-- ------------------------ Splide Hero Section ------------------------ -->
    <section class="splide my-4" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <a href="{{ url('/menus') }}">
                        <img src="{{ url('images/splide/landing-page/hero-slide-1.png') }}" class="d-block w-100"
                            style="border-radius:8px;">
                    </a>
                </li>
                <li class="splide__slide">
                    <a href="{{ url('/reservation/step-one') }}">
                        <img src="{{ url('images/splide/landing-page/hero-slide-2.png') }}" class="d-block w-100"
                            style="border-radius:8px;">
                    </a>
                </li>
                <li class="splide__slide">
                    <a href="{{ url('/reservation/step-one') }}">
                        <img src="{{ url('images/splide/landing-page/hero-slide-3.png') }}" class="d-block w-100"
                            style="border-radius:8px;">
                    </a>
                </li>
                <li class="splide__slide">
                    <img src="{{ url('images/splide/landing-page/hero-slide-4.png') }}" class="d-block w-100"
                        style="border-radius:8px;">
                </li>
            </ul>
        </div>
    </section>

    <!-- End Main Hero Content -->
    <section class="px-2 py-32 bg-black md:px-0">
        <div class="container items-center max-w-6xl px-8 mx-auto xl:px-5">
            <div class="flex flex-wrap items-center sm:-mx-3">
                <div class="w-full md:w-1/2 md:px-3">
                    <div class="w-full pb-6 space-y-4 sm:max-w-md lg:max-w-lg lg:space-y-4 lg:pr-0 md:pb-0">
                        <!-- <h1
              class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl"
            > -->
                        <h3 class="text-xl text-green-600">OUR STORY
                        </h3>
                        <h2 class="text-4xl text-green-600">Welcome</h2>
                        <!-- </h1> -->
                        <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-xl md:max-w-3xl">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus nemo incidunt
                            praesentium, ipsum
                            culpa minus eveniet, id nesciunt excepturi sit voluptate repudiandae. Explicabo, incidunt
                            quia.
                            Repellendus mollitia quaerat est voluptas!
                        </p>
                        <div class="relative flex">
                            <a href="#_"
                                class="flex items-center w-full px-6 py-3 mb-3 text-lg text-white bg-green-600 rounded-md sm:mb-0 hover:bg-green-700 sm:w-auto">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="w-full h-auto overflow-hidden rounded-md shadow-xl sm:rounded-xl">
                        <img src="{{ asset('images/people-2576336_960_720.jpg') }}" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-2 py-32 bg-black md:px-0">
        <div class="container items-center max-w-6xl px-4 px-10 mx-auto sm:px-20 md:px-32 lg:px-16">
            <div class="flex flex-wrap items-center -mx-3">
                <div class="order-1 w-full px-3 lg:w-1/2 lg:order-0">
                    <div class="w-full lg:max-w-md">
                        <h2 class="mb-4 text-2xl font-bold text-green-600">About Us</h2>
                        <h2
                            class="mb-4 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                            WHY CHOOSE US?</h2>

                        <p class="mb-4 font-medium tracking-tight text-gray-400 xl:mb-6">Lorem ipsum dolor sit amet
                            consectetur
                            adipisicing elit. Natus hic atque magni minus aliquam, eos quam incidunt nam iusto sunt
                            voluptates
                            inventore a veritatis doloremque corrupti. Veritatis est expedita cupiditate!</p>
                        <ul>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                                    </path>
                                </svg>
                                <span class="font-medium text-gray-500">Faster Processing and Delivery</span>
                            </li>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium text-gray-500">Easy Payments</span>
                            </li>
                            <li class="flex items-center py-2 space-x-4 xl:py-3">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span class="font-medium text-gray-500">100% Protection and Security for Your
                                    App</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full px-3 mb-12 lg:w-1/2 order-0 lg:order-1 lg:mb-0"><img
                        class="mx-auto sm:max-w-sm lg:max-w-full"
                        src="{{ asset('images/Free Vector _ People sitting at the cafe.jpeg') }}"
                        alt="feature image">
                </div>
            </div>
        </div>
    </section>
    @if (is_array($specials))
        <section class="mt-8 bg-white">
            <div class="mt-4 text-center">
                <h3 class="text-2xl font-bold">Our Menu</h3>
                <h2
                    class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
                    TODAY'S SPECIALITY</h2>
            </div>
            <div class="container w-full px-5 py-6 mx-auto">
                <div class="grid lg:grid-cols-4 gap-y-6">
                    @foreach ($specials->menus as $menu)
                        <div class="max-w-xs mx-4 mb-2 rounded-lg shadow-lg">
                            <img class="w-full h-48" src="{{ Storage::url($menu->image) }}" alt="Image" />
                            <div class="px-6 py-4">
                                <h4 class="mb-3 text-xl font-semibold tracking-tight text-green-600 uppercase">
                                    {{ $menu->name }}</h4>
                                <p class="leading-normal text-gray-700">{{ $menu->description }}.</p>
                            </div>
                            <div class="flex items-center justify-between p-4">
                                <span class="text-xl text-green-600">${{ $menu->price }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>
    @endif
    @if ($recommendations->count())
        <section class="my-8">
            <h2 class="text-2xl font-bold mb-4 text-green-400">Rekomendasi Menu Terbaik per Kategori</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recommendations as $rec)
                    @php $item = $rec['menu']; @endphp
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <img src="{{ $item->image ? Storage::url($item->image) : asset('images/default-menu.jpg') }}"
                            alt="{{ $item->name }}" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold text-lg text-green-300 mb-1">{{ $item->name }}</h4>
                            <span class="badge bg-success mb-2">{{ $item->categories->name ?? '-' }}</span>
                            <p class="text-gray-400 text-xs mb-1">Skor: {{ number_format($rec['score'], 2) }}</p>
                            <p class="text-gray-300 mb-2">{{ Str::limit($item->description, 60) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-green-400 font-bold">Rp
                                    {{ number_format($item->price, 0, ',', '.') }}</span>
                                <a href="{{ route('menus.index') }}" class="btn btn-sm btn-success">Lihat</a>
                            </div>
                            <!-- Rating dengan bintang -->
                            <div class="mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fas fa-star {{ $i <= $item->rating ? 'text-warning' : 'text-gray-400' }}"></i>
                                @endfor
                                <span class="text-gray-300">({{ number_format($item->rating, 1) }})</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Blog Section -->
    <section id="blog" class="px-2 py-32 bg-black md:px-0">
        <div class="container">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-green-600 mb-2">Blog Restoran Saung DMS</h2>
                <p class="text-gray-400">Info terbaru, tips kuliner, dan berita menarik seputar restoran kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($artikels as $item)
                    <div
                        class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden border border-green-700 hover:shadow-2xl transition">
                        <img src="{{ asset('storage/blogs/' . $item->image) }}" class="w-full h-48 object-cover"
                            alt="{{ $item->judul }}">
                        <div class="p-5 flex flex-col h-full">
                            <div class="flex items-center mb-2">
                                <span class="text-xs bg-green-600 text-white px-2 py-1 rounded-full mr-2">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <span class="text-xs text-gray-400">by Admin</span>
                            </div>
                            <h4 class="font-bold text-lg text-green-400 mb-2">{{ $item->judul }}</h4>
                            <p class="text-gray-300 mb-4">{{ Str::limit(strip_tags($item->desc), 100) }}</p>
                            <a href="{{ route('blog.detail', $item->slug) }}"
                                class="inline-block text-green-400 hover:text-green-200 font-semibold transition">
                                Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-success px-4 py-2 rounded-pill fw-bold">
                    <i class="fas fa-arrow-right"></i> Lihat Semua Blog
                </a>
            </div>
    </section>
    <!-- End Blog Section -->
    <section class="pt-4 pb-12 bg-gradient-to-br from-[#232526] via-[#1a1a2e] to-[#232526]">
        <div class="my-16 text-center">
            <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-blue-400">
                Testimonial
            </h2>
            <p class="text-xl text-gray-200">Apa kata pelanggan tentang Saung DMS Restaurant?</p>
        </div>
        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 px-4">
            <!-- Testimonial 1 -->
            <div
                class="max-w-md mx-auto p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#2d3748] to-[#232526] border border-green-400">
                <div class="flex justify-center -mt-16 mb-4">
                    <img class="object-cover w-24 h-24 border-4 border-green-400 rounded-full shadow-lg bg-white"
                        src="{{ asset('images/Casual businessman at office.jpeg') }}">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-300 mb-1">John Doe</h3>
                    <p class="text-sm text-gray-400 mb-2">Pelanggan Setia</p>
                    <p class="mt-2 text-gray-200 italic">"Makanannya enak, pelayanannya ramah, dan suasananya nyaman.
                        Sangat recommended untuk keluarga!"</p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="text-green-400 font-bold">★★★★★</span>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div
                class="max-w-md mx-auto p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#2d3748] to-[#232526] border border-blue-400">
                <div class="flex justify-center -mt-16 mb-4">
                    <img class="object-cover w-24 h-24 border-4 border-blue-400 rounded-full shadow-lg bg-white"
                        src="{{ asset('images/young-3061652__340.jpg') }}">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-blue-300 mb-1">Jane Smith</h3>
                    <p class="text-sm text-gray-400 mb-2">Food Blogger</p>
                    <p class="mt-2 text-gray-200 italic">"Menu variatif, harga terjangkau, dan tempatnya instagramable.
                        Pasti balik lagi!"</p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="text-blue-400 font-bold">★★★★★</span>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div
                class="max-w-md mx-auto p-6 rounded-xl shadow-lg bg-gradient-to-br from-[#2d3748] to-[#232526] border border-pink-400">
                <div class="flex justify-center -mt-16 mb-4">
                    <img class="object-cover w-24 h-24 border-4 border-pink-400 rounded-full shadow-lg bg-white"
                        src="{{ asset('images/purchase-3090818__340.jpg') }}">
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-pink-300 mb-1">Andi Wijaya</h3>
                    <p class="text-sm text-gray-400 mb-2">Mahasiswa</p>
                    <p class="mt-2 text-gray-200 italic">"Tempat favorit buat nongkrong bareng teman. Wifi kencang,
                        makanan cepat saji!"</p>
                </div>
                <div class="flex justify-end mt-4">
                    <span class="text-pink-400 font-bold">★★★★★</span>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var splide = new Splide('.splide', {
            type: 'loop', // Tipe loop agar slideshow berulang
            padding: '80px', // Padding untuk space di samping gambar
            gap: '24px', // Jarak antar gambar
            autoplay: true, // Memulai slideshow secara otomatis
            arrows: false, // Menghilangkan tombol panah
            breakpoints: {
                576: {
                    type: 'loop',
                    perPage: 1, // Menampilkan 1 slide pada perangkat kecil
                    gap: '8px', // Jarak antar slide lebih kecil pada perangkat kecil
                    padding: '8px', // Padding lebih kecil pada perangkat kecil
                },
            }
        });
        splide.mount(); // Menginisialisasi Splide
    });
</script>
