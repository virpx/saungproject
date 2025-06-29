<!-- resources/views/reservations/step-four.blade.php -->
<x-guest-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex items-center min-h-screen bg-gray-800">
            <!-- Card Wrapper -->
            <div
                class="flex-1 max-w-4xl mx-auto bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
                <!-- Image Section -->
                <div class="hidden md:block md:w-1/3">
                    <img src="{{ asset('images/Restaurant.jpeg') }}" alt="img" class="object-cover w-full h-full" />
                </div>
                <!-- Content Section -->
                <div class="w-full md:w-2/3 p-8 flex flex-col justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-400 mb-6">Pembayaran</h3>

                        <!-- Step Indicator -->
                        <div class="flex items-center justify-between mb-8">
                            @foreach ([1, 2, 3, 4] as $step)
                                @php
                                    $active = $step === 4;
                                    $done = $step < 4;
                                @endphp
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="step {{ $active ? 'step-active' : '' }}">
                                        {{ $step }}
                                    </div>
                                    <span
                                        class="text-xs mt-2 {{ $active ? 'text-yellow-400 font-bold' : ($done ? 'text-green-500 font-bold' : 'text-gray-500') }}">
                                        {{ ['Data Diri', 'Meja/Menu', 'Menu', 'Pembayaran'][$step - 1] }}
                                    </span>
                                </div>
                                @if ($step < 4)
                                    <div class="flex-1 h-1 mx-2 {{ $done ? 'bg-yellow-400' : 'bg-gray-700' }} rounded">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('reservations.store.step-four') }}" class="space-y-6">
                            @csrf

                            <!-- Summary Card -->
                            @if (!empty($rincianMenu))
                                <div class="bg-gray-800 p-6 rounded-lg mb-6">
                                    <h4 class="text-lg font-semibold text-gray-200 mb-4">Detail Menu</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-left text-gray-300">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-2">Nama</th>
                                                    <th class="px-4 py-2">Harga</th>
                                                    <th class="px-4 py-2">Jumlah</th>
                                                    <th class="px-4 py-2">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rincianMenu as $item)
                                                    <tr class="border-t border-gray-700">
                                                        <td class="px-4 py-2">{{ $item['name'] }}</td>
                                                        <td class="px-4 py-2">
                                                            Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                                        <td class="px-4 py-2">{{ $item['quantity'] }}</td>
                                                        <td class="px-4 py-2 font-semibold">
                                                            Rp{{ number_format($item['subtotal'], 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                            <div class="bg-gray-800 p-6 rounded-lg">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-400">Subtotal</span>
                                    <span class="text-gray-100 font-semibold">Rp
                                        {{ number_format($totalCost, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-400">Pajak (10%)</span>
                                    <span class="text-gray-100 font-semibold">Rp
                                        {{ number_format($totalCost * 0.1, 0, ',', '.') }}</span>
                                </div>
                                @if (isset($overPeopleFee) && $overPeopleFee > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Biaya Tambahan Orang
                                            ({{ $overPeopleCount }}×)</span>
                                        <span class="text-orange-400 font-semibold">Rp
                                            {{ number_format($overPeopleFee, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Payment Method -->
                            <div class="bg-gray-800 p-6 rounded-lg">
                                <label for="payment_channel" class="block text-gray-300 mb-2">Metode Pembayaran</label>
                                <select id="payment_channel" name="payment_channel"
                                    class="w-full bg-gray-700 text-gray-200 rounded-md p-3 focus:ring-yellow-400"
                                    required>
                                    <option value="">Pilih Channel</option>
                                    @foreach ($channelsPayment['data'] ?? [] as $channel)
                                        <option value="{{ $channel['code'] }}"
                                            data-fee-flat="{{ $channel['total_fee']['flat'] }}"
                                            data-fee-percent="{{ $channel['total_fee']['percent'] }}">
                                            {{ $channel['name'] }} ({{ $channel['group'] }})
                                        </option>
                                    @endforeach
                                </select>

                                <div id="feeBox" class="hidden mt-4 flex justify-between text-yellow-400"></div>
                                <div id="grandTotalBox"
                                    class="hidden mt-2 flex justify-between font-bold text-gray-100"></div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between">
                                <a href="{{ route('reservations.step-three') }}"
                                    class="px-6 py-3 bg-gray-700 text-gray-200 rounded-lg hover:bg-gray-600 font-semibold">Previous</a>
                                <button type="submit"
                                    class="px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-500 font-semibold">Complete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .step {
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background: #374151;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .step-active {
            background: #fbbf24;
            color: #111;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('payment_channel');
            const feeBox = document.getElementById('feeBox');
            const grandBox = document.getElementById('grandTotalBox');
            const total = {{ $totalCost }};
            const tax = total * 0.1;
            const over = {{ $overPeopleFee ?? 0 }};
            select.addEventListener('change', function() {
                const opt = select.options[select.selectedIndex];
                const flat = +opt.dataset.feeFlat || 0;
                const pct = +opt.dataset.feePercent || 0;
                let fee = flat + ((total + tax + over) * pct / 100);
                if (fee > 0 && fee < 1000 && /dana|qris|ovo|shopeepay/.test(opt.text.toLowerCase())) fee =
                    1000;
                feeBox.textContent = 'Biaya Channel: Rp ' + Math.round(fee).toLocaleString('id-ID');
                grandBox.textContent = 'Total Bayar: Rp ' + Math.round(total + tax + over + fee)
                    .toLocaleString('id-ID');
                feeBox.classList.remove('hidden');
                grandBox.classList.remove('hidden');
            });
        });
    </script>
</x-guest-layout>
