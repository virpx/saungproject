<x-guest-layout>
    <section id="detail" class="py-10 min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <div class="container max-w-3xl mx-auto bg-gray-900 rounded-xl shadow-lg p-8">
            <nav class="mb-6" aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-green-400">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-green-400">Blog</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $artikel->judul }}</li>
                </ol>
            </nav>
            <div class="mb-6">
                <img src="{{ asset('storage/blogs/' . $artikel->image) }}" class="w-full rounded-lg shadow mb-4 object-cover" style="max-height:350px;">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xs bg-green-600 text-white px-3 py-1 rounded-full">
                        {{ $artikel->created_at->format('d M Y') }}
                    </span>
                    <span class="text-xs text-gray-400">by Admin</span>
                </div>
                <h1 class="text-3xl font-bold text-green-400 mb-3">{{ $artikel->judul }}</h1>
            </div>
            <div class="prose prose-invert max-w-none text-gray-200 leading-relaxed" style="font-size:1.1rem;">
                {!! $artikel->desc !!}
            </div>
            <div class="mt-8">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-success px-4 py-2 rounded-pill fw-bold">
                    <i class="fas fa-arrow-left"></i> Kembali ke Blog
                </a>
            </div>
        </div>
    </section>
</x-guest-layout>
