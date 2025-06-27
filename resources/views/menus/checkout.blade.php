<x-guest-layout>
    <div class="container w-full px-5 py-6 mx-auto">
        <h2 class="text-2xl font-semibold mb-6">Checkout</h2>

        <!-- Session Error or Success Messages -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 animate-fade-in-down" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 animate-fade-in-down" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="col-md-12 mx-auto bg-dark text-white p-md-5 p-4 shadow-lg rounded-3">
            <h1 class="fw-bold text-white mb-4">FORM PEMESANAN</h1>
            <p class="text-gray-300">Data Pemesanan anda</p>
            <hr class="border-gray-600 mb-6"/>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Kiri: Keranjang -->
                <div class="flex-1 md:sticky md:top-8 h-fit mb-8 md:mb-0">
                    @if(session()->has('cart'))
                        <div class="bg-dark rounded-3 shadow-sm p-4 mb-4 text-white">
                            <h5 class="fw-semibold mb-3"><i class="fas fa-shopping-cart me-2"></i>Keranjang Anda</h5>
                            <ul class="list-group list-group-flush mb-3">
                                @php
                                    $totalPrice = 0;
                                    foreach (session()->get('cart') as $menuId => $item) {
                                        $totalPrice += $item['price'] * $item['quantity'];
                                    }
                                    $taxRate = 0.10;
                                    $taxAmount = $totalPrice * $taxRate;
                                    $totalWithTax = $totalPrice + $taxAmount;
                                @endphp
                                    @foreach (session()->get('cart') as $menuId => $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center bg-dark text-white border-secondary">
                                            <div>
                                                <strong>{{ $item['name'] }}</strong>
                                                <span class="text-secondary small">(x{{ $item['quantity'] }})</span>
                                            </div>
                                            <span class="fw-semibold text-warning">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                            </ul>
                            <div class="mb-2 d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span id="subtotal" class="text-warning">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span>Tax (10%)</span>
                                <span id="tax" class="text-warning">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between border-top pt-2 fw-bold text-success">
                                <span>Total Dengan Pajak</span>
                                <span id="totalWithTax" class="text-success">Rp {{ number_format($totalWithTax, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between" id="feeBox" style="display:none;">
                                <span class="text-info">Biaya Channel</span>
                                <span id="feeValue" class="text-info">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2 fw-bold text-primary" id="grandTotalBox" style="display:none;">
                                <span>Total Bayar</span>
                                <span id="grandTotal">Rp 0</span>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Kanan: Form -->
                <div class="flex-1">
                    <ul>
                        <h3 class="fw-bold text-white mb-2">Silakan lengkapi data pemesanan</h3>
                        <li class="flex justify-between mb-2 border-b pb-1">
                            <p class="text-gray-300">Isi data dengan benar untuk melanjutkan checkout</p>
                        </li>
                    </ul>
                    <div class="bg-dark rounded-3 shadow-sm p-4 text-white">
                        <form action="{{ route('menus.placeOrder') }}" method="POST" id="checkoutForm">
                            @csrf
                            <h5 class="fw-bold mb-3 text-white">Data Pemesanan</h5>
                            <div class="mb-3">
                                <label for="name" class="form-label text-white">Nama Kamu</label>
                                <input type="text" id="name" name="name" class="form-control bg-secondary text-white border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label text-white">Email Kamu</label>
                                <input type="email" id="email" name="email" class="form-control bg-secondary text-white border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label text-white">Nomor Handphone</label>
                                <input type="text" id="phone" name="phone" class="form-control bg-secondary text-white border-0" required>
                            </div>
                            <div class="mb-3">
                                <label for="table_id" class="form-label text-white">Nomor Meja</label>
                                <select id="table_id" name="table_id" class="form-select bg-secondary text-white border-0" required>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table->id }}">
                                            {{ $table->name }} - {{ $table->location }} ({{ $table->guest_number }} Tamu)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label text-white">Catatan (Opsional)</label>
                                <textarea id="note" name="note" class="form-control bg-secondary text-white border-0" rows="3" placeholder="Contoh: Tidak pedas, banyak es, dll."></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-white fw-semibold">Metode Pembayaran</label>
                                <input type="hidden" id="selected_fee_flat" name="fee_flat" value="0">
                                <input type="hidden" id="selected_fee_percent" name="fee_percent" value="0">
                                <select name="payment_channel" id="payment_channel" class="form-select bg-secondary text-white border-0" required>
                                    <option value="">-- Pilih Channel Pembayaran --</option>
                                    @if(isset($channelsPayment['success']) && $channelsPayment['success'] && isset($channelsPayment['data']))
                                        @foreach($channelsPayment['data'] as $channel)
                                            <option 
                                                value="{{ $channel['code'] }}"
                                                data-icon="{{ $channel['icon_url'] }}"
                                                data-fee-flat="{{ $channel['total_fee']['flat'] }}"
                                                data-fee-percent="{{ $channel['total_fee']['percent'] }}"
                                            >
                                                {{ $channel['name'] }} ({{ $channel['group'] }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <!-- Tempat gambar channel -->
                                <div id="channelIconBox" class="my-3 text-center" style="display:none;">
                                    <img id="channelIcon" src="" alt="Channel Icon" class="mx-auto" style="max-height:60px;">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('menus.index') }}" class="btn btn-outline-light">Kembali ke Menu</a>
                                <button type="submit" class="btn btn-warning text-dark fw-bold">Lanjut Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('payment_channel');
    const feeBox = document.getElementById('feeBox');
    const feeValue = document.getElementById('feeValue');
    const grandTotalBox = document.getElementById('grandTotalBox');
    const grandTotal = document.getElementById('grandTotal');
    const totalWithTax = {{ $totalWithTax ?? 0 }};
    const selectedFeeFlat = document.getElementById('selected_fee_flat');
    const selectedFeePercent = document.getElementById('selected_fee_percent');
    const channelIconBox = document.getElementById('channelIconBox');
    const channelIcon = document.getElementById('channelIcon');

    select.addEventListener('change', function() {
        const selectedOption = select.options[select.selectedIndex];
        const feeFlat = parseFloat(selectedOption.getAttribute('data-fee-flat') || 0);
        const feePercent = parseFloat(selectedOption.getAttribute('data-fee-percent') || 0);
        let fee = feeFlat + (totalWithTax * feePercent / 100);
        const channelText = selectedOption.textContent.toLowerCase();
        if ((channelText.includes('dana') || channelText.includes('qris') || channelText.includes('shopeepay') || channelText.includes('ovo')) && fee > 0 && fee < 1000) {
            fee = 1000;
        }
        if (select.value) {
            feeBox.style.display = 'flex';
            feeValue.textContent = 'Rp ' + fee.toLocaleString('id-ID');
            grandTotalBox.style.display = 'flex';
            grandTotal.textContent = 'Rp ' + (totalWithTax + fee).toLocaleString('id-ID');
            // Tampilkan gambar channel
            const iconUrl = selectedOption.getAttribute('data-icon');
            if (iconUrl) {
                channelIcon.src = iconUrl;
                channelIconBox.style.display = 'block';
            } else {
                channelIconBox.style.display = 'none';
            }
        } else {
            feeBox.style.display = 'none';
            grandTotalBox.style.display = 'none';
            channelIconBox.style.display = 'none';
        }
        selectedFeeFlat.value = feeFlat;
        selectedFeePercent.value = feePercent;
    });
});
</script>
