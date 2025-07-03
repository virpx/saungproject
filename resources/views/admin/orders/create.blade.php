<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a href="{{ route('admin.orders.index') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Back to Orders</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    <form method="POST" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Customer Name -->
                        <div class="sm:col-span-6 mb-4">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer
                                Name</label>
                            <div class="mt-1">
                                <input type="text" id="customer_name" name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                    required />
                            </div>
                            @error('customer_name')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Email -->
                        <div class="sm:col-span-6 mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Customer Email</label>
                            <div class="mt-1">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                    required />
                            </div>
                            @error('email')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Phone -->
                        <div class="sm:col-span-6 mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Customer Phone</label>
                            <div class="mt-1">
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                    required />
                            </div>
                            @error('phone')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Select Menu -->
                        <div class="mb-4">
                            <label for="menu_select" class="block text-sm font-medium text-gray-700">Menu</label>
                            <select id="menu_select" name="menu_select"
                                class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                required>
                                <option value="">-- Pilih Menu --</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}" data-price="{{ $menu->price }}"
                                        {{ old('menu_select') == $menu->id ? 'selected' : '' }}>
                                        {{ $menu->name }} – Rp. {{ number_format($menu->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('menu_select')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', 1) }}"
                                min="1"
                                class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                required>
                            @error('amount')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Price -->
                        <div class="mb-4">
                            <label for="total_price" class="block text-sm font-medium text-gray-700">Total Price</label>
                            <input type="text" id="total_price" name="total_price"
                                value="{{ old('total_price', '0') }}" readonly
                                class="block w-full bg-gray-100 border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm">
                            @error('total_price')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Status -->
                        <div class="sm:col-span-6 mb-4">
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment
                                Status</label>
                            <select name="payment_status" id="payment_status"
                                class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm"
                                required>
                                <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="completed" {{ old('payment_status') == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                            </select>
                            @error('payment_status')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- QRIS Screenshot -->
                        <div class="sm:col-span-6 mb-4">
                            <label for="qris_screenshot" class="block text-sm font-medium text-gray-700">QRIS Screenshot
                                (Optional)</label>
                            <div class="mt-1">
                                <input type="file" id="qris_screenshot" name="qris_screenshot" accept="image/*"
                                    class="block w-full bg-white border border-gray-400 rounded-md py-2 px-3 text-base sm:text-sm" />
                            </div>
                            @error('qris_screenshot')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 p-4">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const menuSelect = document.getElementById('menu_select');
        const qtyInput = document.getElementById('amount');
        const totalInput = document.getElementById('total_price');

        function updateTotal() {
            const selectedOption = menuSelect.selectedOptions[0];
            const price = selectedOption ? parseFloat(selectedOption.dataset.price) || 0 : 0;
            const qty = parseInt(qtyInput.value) || 0;
            const total = price * qty;
            totalInput.value = total.toFixed(0); // Remove decimals for Indonesian currency
        }

        menuSelect.addEventListener('change', updateTotal);
        qtyInput.addEventListener('input', updateTotal);

        // Update total on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });
    </script>
</x-admin-layout>
