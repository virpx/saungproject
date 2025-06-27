<x-guest-layout>
    <section class="py-10 min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <div class="container">
            <h2 class="text-3xl font-bold mb-8 text-green-400">Daftar Blog Restoran</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($artikels as $item)
                    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg overflow-hidden border border-green-700 hover:shadow-2xl transition">
                        <img src="{{ asset('storage/blogs/' . $item->image) }}" class="w-full h-48 object-cover" alt="{{ $item->judul }}">
                        <div class="p-5 flex flex-col h-full">
                            <div class="flex items-center mb-2">
                                <span class="text-xs bg-green-600 text-white px-2 py-1 rounded-full mr-2">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                                <span class="text-xs text-gray-400">by Admin</span>
                            </div>
                            <h4 class="font-bold text-lg text-green-400 mb-2">{{ $item->judul }}</h4>
                            <p class="text-gray-300 mb-4">{{ Str::limit(strip_tags($item->desc), 100) }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('blog.detail', $item->slug) }}" class="inline-block text-green-400 hover:text-green-200 font-semibold transition">
                                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-guest-layout>