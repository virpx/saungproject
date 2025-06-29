<!-- resources/views/reservations/step-three.blade.php -->
<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <div class="flex items-center min-h-screen bg-gray-800">
            <div class="flex-1 h-full max-w-4xl mx-auto bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="hidden md:block md:w-1/3">
                        <img class="object-cover w-full h-full" src="{{ asset('images/Restaurant.jpeg') }}"
                            alt="img" />
                    </div>
                    <div class="w-full md:w-2/3 bg-gray-900 p-8 flex flex-col">
                        <h3 class="text-2xl font-bold text-yellow-400 mb-6">Pilih Menu</h3>

                        <div class="flex items-center justify-between mb-8">
                            @foreach ([1, 2, 3, 4] as $step)
                                @php
                                    $isActive = $step === 3;
                                    $isCompleted = $step < 3;
                                @endphp
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="step {{ $isActive ? 'step-active' : '' }}">{{ $step }}</div>
                                    <span
                                        class="text-xs mt-2 {{ $isActive ? 'text-yellow-400 font-bold' : ($isCompleted ? 'text-green-500 font-bold' : 'text-gray-500') }}">
                                        {{ ['Data Diri', 'Meja/Menu', 'Menu', 'Pembayaran'][$step - 1] }}
                                    </span>
                                </div>
                                @if ($step < 4)
                                    <div
                                        class="flex-1 h-1 mx-2 {{ $step < 3 ? 'bg-gray-700' : 'bg-yellow-400' }} rounded">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <form method="GET" action="{{ route('reservations.step-three') }}" class="mb-6 space-y-4">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Cari menu..."
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-2 bg-gray-800 text-gray-200 rounded-l-md focus:ring-yellow-400" />
                                <button type="submit" class="px-4 py-2 bg-yellow-400 font-semibold">Search</button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($categories as $category)
                                    <label
                                        class="flex items-center space-x-2 px-4 py-2 bg-gray-800 text-gray-200 rounded-full">
                                        <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}
                                            class="h-4 w-4 text-yellow-400" />
                                        <span class="text-sm">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                                <button type="submit"
                                    class="px-4 py-2 bg-yellow-400 font-semibold ml-auto">Filter</button>
                            </div>
                        </form>

                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 rounded-lg p-4 mb-6">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- rekomendasi menu untuk user --}}
                        @if (isset($namaMenuRekomendasi) && $namaMenuRekomendasi->isNotEmpty())
                            <div role="alert"
                                class="mb-6 px-4 py-3 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 112 0v4a1 1 0 11-2 0V7zm1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="font-semibold">Rekomendasi Menu:</p>
                                </div>
                                <p class="mt-2">{{ $namaMenuRekomendasi->implode(', ') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('reservations.store.step-three') }}"
                            class="flex-1 flex flex-col">
                            @csrf
                            <div class="overflow-x-auto pb-4 hide-scrollbar">
                                <div class="flex space-x-6 px-1">
                                    @foreach ($menus as $menu)
                                        <div
                                            class="flex-shrink-0 w-64 bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition">
                                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}"
                                                class="w-full h-32 object-cover" />
                                            <div class="p-4">
                                                <h5 class="text-lg font-semibold text-gray-100 mb-1">
                                                    {{ $menu->name }}</h5>
                                                <p class="text-gray-400 text-sm mb-3">
                                                    {{ Str::limit($menu->description, 80) }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="bg-yellow-400 text-gray-900 px-2 py-1 text-xs rounded">Rp
                                                        {{ number_format($menu->price, 0, ',', '.') }}</span>
                                                    <label class="flex items-center space-x-2">
                                                        <input type="checkbox" name="menu_items[]"
                                                            value="{{ $menu->id }}"
                                                            class="menu-checkbox h-5 w-5 text-yellow-400"
                                                            data-id="{{ $menu->id }}" />
                                                        <span class="text-gray-200 text-sm">Pilih</span>
                                                    </label>
                                                </div>
                                                <input type="number" id="qty_{{ $menu->id }}"
                                                    name="quantities[{{ $menu->id }}]" min="1"
                                                    value="1"
                                                    class="mt-3 w-full px-2 py-1 bg-gray-700 text-gray-100 rounded-md focus:ring-yellow-400" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ route('reservations.step-two') }}"
                                    class="px-6 py-3 bg-gray-700 text-white rounded-lg">Previous</a>
                                <button type="submit"
                                    class="px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg">Next</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // supaya menu bisa discroll mouse secara horizontal
            const sc = document.querySelector('.overflow-x-auto');
            if (sc) sc.addEventListener('wheel', e => {
                e.preventDefault();
                sc.scrollLeft += e.deltaY;
            });

            document.querySelectorAll('.menu-checkbox').forEach(cb => {
                const id = cb.dataset.id;
                const qty = document.getElementById('qty_' + id);
                cb.addEventListener('change', () => {
                    if (cb.checked) {
                        qty.disabled = false;
                        qty.name = 'quantities[' + id + ']';
                    } else {
                        qty.disabled = true;
                        qty.value = 1;
                        qty.removeAttribute('name');
                    }
                });
            });
        });
    </script>
</x-guest-layout>
