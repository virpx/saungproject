<x-guest-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Step Indicator -->
        <div class="flex w-full items-center justify-between mb-8">
            @php $currentStep = 3; @endphp
            @foreach([1,2,3,4] as $step)
                @php
                    $isActive = $step === $currentStep;
                    $isCompleted = $step < $currentStep;
                @endphp
                <div class="flex flex-col items-center w-1/4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                        {{ $isActive ? 'bg-blue-600 text-white' : ($isCompleted ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600') }}">
                        {{ $step }}
                    </div>
                    <span class="text-xs mt-2 {{ $isActive ? 'text-blue-600 font-bold' : ($isCompleted ? 'text-green-500 font-bold' : 'text-gray-500') }}">
                        Step {{ $step }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Search & Category Filter -->
        <div class="flex flex-col md:flex-row md:items-center mb-6 space-y-4 md:space-y-0">
            <div class="flex-1">
                <form method="GET" action="{{ route('reservations.step-three') }}" class="flex w-full max-w-md">
                    <input type="text" name="search" placeholder="Cari menu..."
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">
                        Search
                    </button>
                </form>
            </div>
            <div class="flex-1">
                <form method="GET" action="{{ route('reservations.step-three') }}" class="flex flex-wrap items-center bg-gray-100 p-2 rounded-md gap-2">
                    @foreach ($categories as $category)
                        <label class="inline-flex items-center space-x-1 px-3 py-1 bg-white rounded-full hover:bg-gray-200">
                            <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}
                                class="form-checkbox text-blue-600" />
                            <span class="text-sm text-gray-700">{{ $category->name }}</span>
                        </label>
                    @endforeach
                    <button type="submit" class="ml-auto px-4 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Menu Grid -->
        <form method="POST" action="{{ route('reservations.store.step-three') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($menus as $menu)
                    <div class="bg-black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-transform transform hover:-translate-y-1">
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover" />
                        <div class="p-4">
                            <h5 class="text-lg font-semibold text-white">{{ $menu->name }}</h5>
                            <p class="text-sm text-gray-300 mt-1">{{ Str::limit($menu->description, 80) }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-yellow-400 font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                <input type="checkbox" name="menu_items[]" value="{{ $menu->id }}"
                                    class="form-checkbox h-5 w-5 text-blue-600" id="menu_{{ $menu->id }}" />
                            </div>
                            <div class="mt-2 flex items-center">
                                <label for="qty_{{ $menu->id }}" class="text-sm text-gray-200 mr-2">Qty:</label>
                                <input type="number" name="quantities[{{ $menu->id }}]"
                                    id="qty_{{ $menu->id }}" value="1" min="1"
                                    class="w-16 px-2 py-1 bg-gray-700 text-white rounded-md disabled:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    disabled />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('reservations.step-two') }}" class="px-5 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Previous
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Next
                </button>
            </div>
        </form>
    </div>

    <!-- Custom CSS for Improved Layout -->
    <style>
        .step-indicator {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background-color: #e2e8f0;
            color: #4a5568;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .step-label {
            font-size: 0.75rem;
            color: #a0aec0;
        }

        .search-input {
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            background-color: #edf2f7;
            transition: border-color 0.2s;
        }
        .search-input:focus {
            border-color: #3182ce;
            outline: none;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }
        .filter-label {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            background-color: #fff;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .filter-label:hover {
            background-color: #e2e8f0;
        }
        .filter-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: #3182ce;
        }
        .filter-button {
            padding: 0.5rem 1.5rem;
            background-color: #3182ce;
            color: #fff;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .filter-button:hover {
            background-color: #2b6cb0;
        }

        .menu-card {
            background-color: #000;
            border-radius: 0.5rem;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .menu-card:hover {
            transform: translateY(-4px);
        }
        .menu-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .menu-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .menu-desc {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        .price-checkbox {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .menu-price {
            font-size: 1rem;
            font-weight: 700;
        }
        .menu-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: #3182ce;
        }

        .quantity-label {
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            display: block;
        }
        .quantity-input {
            width: 4rem;
            padding: 0.5rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            text-align: center;
            transition: border-color 0.2s;
            background-color: #edf2f7;
        }
        .quantity-input:disabled {
            background-color: #e2e8f0;
            border-color: #cbd5e0;
        }
        .quantity-input:focus:not(:disabled) {
            border-color: #3182ce;
            outline: none;
        }

        .button-nav {
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .prev-button {
            background-color: #718096;
            color: #fff;
        }
        .prev-button:hover {
            background-color: #4a5568;
        }
        .next-button {
            background-color: #3182ce;
            color: #fff;
        }
        .next-button:hover {
            background-color: #2b6cb0;
        }
    </style>

    <!-- Script to enable/disable quantity input based on checkbox -->
    <script>
        document.querySelectorAll('input[type=checkbox][name="menu_items[]"]').forEach(cb => {
            const menuId = cb.value;
            const qtyInput = document.getElementById('qty_' + menuId);
            cb.addEventListener('change', () => {
                if (cb.checked) {
                    qtyInput.disabled = false;
                } else {
                    qtyInput.disabled = true;
                    qtyInput.value = 1;
                }
            });
            if (!cb.checked) {
                qtyInput.disabled = true;
            }
        });
    </script>
</x-guest-layout>
