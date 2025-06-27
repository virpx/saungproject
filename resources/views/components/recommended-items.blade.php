<section class="recommended-menu-section py-5">
    <div class="container">
        <h3 class="fw-bold mb-4 text-white text-center">Menu yang Mungkin Anda Suka</h3>
        <div class="owl-carousel owl-theme recommended-carousel">
            @foreach($recommendedItems as $item)
                <div class="item">
                    <div class="card h-100 shadow-lg border-0 bg-gray-800 text-light rounded-3">
                        <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height:220px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-warning">{{ $item->name }}</h5>
                            <p class="card-text text-gray-300 mb-2 flex-grow-1">{{ Str::limit($item->description, 60) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-warning">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
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
    </div>
</section>