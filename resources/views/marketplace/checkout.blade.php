@extends('layouts.app')

@section('title', 'Checkout Pesanan Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="border-b border-zinc-200 pb-4">
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
            Pengiriman & Pembayaran
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Lengkapi alamat tujuan pengiriman dan pilih metode pembayaran favorit Anda
        </p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Address & Payment Form -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Section 1: Alamat Penerima -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-zinc-100 pb-4">
                        <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-xs">
                            1
                        </div>
                        <h2 class="font-display font-bold text-base text-zinc-900">Alamat Pengiriman</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Lengkap Penerima *</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required
                                   class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        </div>

                        <div>
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nomor Handphone / WhatsApp *</label>
                            <input type="text" name="recipient_phone" value="{{ old('recipient_phone', $user->phone ?? '081234567890') }}" required
                                   class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Alamat Lengkap (Nama Jalan, No. Rumah, RT/RW, Patokan) *</label>
                            <textarea name="shipping_address" rows="2" required
                                      class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">{{ old('shipping_address', 'Jl. Senopati No. 45, Kebayoran Baru') }}</textarea>
                        </div>

                        <div>
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kota / Kabupaten *</label>
                            <input type="text" name="city" value="{{ old('city', 'Jakarta Selatan') }}" required
                                   class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        </div>

                        <div>
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Provinsi *</label>
                            <input type="text" name="province" value="{{ old('province', 'DKI Jakarta') }}" required
                                   class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        </div>

                        <div>
                            <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kode Pos *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', '12190') }}" required
                                   class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Opsi Kurir -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-zinc-100 pb-4">
                        <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-xs">
                            2
                        </div>
                        <h2 class="font-display font-bold text-base text-zinc-900">Pilih Ekspedisi Pengiriman</h2>
                    </div>

                    <div class="space-y-3">
                        @foreach($couriers as $idx => $courier)
                            <label class="flex items-center justify-between p-4 rounded-2xl border cursor-pointer transition 
                                          {{ $idx === 0 ? 'border-zinc-950 bg-zinc-50 shadow-sm' : 'border-zinc-200 hover:border-zinc-300' }}">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_service" value="{{ $courier['name'] }}" 
                                           data-cost="{{ $courier['cost'] }}"
                                           {{ $idx === 0 ? 'checked' : '' }} 
                                           onchange="updateShipping(this)"
                                           class="text-zinc-950 focus:ring-zinc-950">
                                    <div>
                                        <h4 class="font-bold text-xs text-zinc-900">{{ $courier['name'] }}</h4>
                                        <span class="text-[11px] text-zinc-500">Estimasi tiba tepat waktu & asuransi penuh</span>
                                    </div>
                                </div>
                                <span class="font-display font-bold text-xs text-zinc-900">
                                    Rp {{ number_format($courier['cost'], 0, ',', '.') }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Section 3: Metode Pembayaran -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-zinc-100 pb-4">
                        <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-xs">
                            3
                        </div>
                        <h2 class="font-display font-bold text-base text-zinc-900">Metode Pembayaran</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="p-4 rounded-2xl border border-zinc-200 hover:border-zinc-900 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div class="flex items-center justify-between">
                                <i class="fa-solid fa-building-columns text-xl text-zinc-700"></i>
                                <input type="radio" name="payment_method" value="bank_transfer" checked class="text-zinc-950 focus:ring-zinc-950">
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-zinc-900">Transfer Bank VA</h4>
                                <span class="text-[10px] text-zinc-500">BCA, Mandiri, BNI, BRI</span>
                            </div>
                        </label>

                        <label class="p-4 rounded-2xl border border-zinc-200 hover:border-zinc-900 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div class="flex items-center justify-between">
                                <i class="fa-solid fa-qrcode text-xl text-zinc-700"></i>
                                <input type="radio" name="payment_method" value="ewallet" class="text-zinc-950 focus:ring-zinc-950">
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-zinc-900">QRIS / E-Wallet</h4>
                                <span class="text-[10px] text-zinc-500">GoPay, OVO, ShopeePay</span>
                            </div>
                        </label>

                        <label class="p-4 rounded-2xl border border-zinc-200 hover:border-zinc-900 cursor-pointer transition flex flex-col justify-between space-y-3">
                            <div class="flex items-center justify-between">
                                <i class="fa-solid fa-money-bill-wave text-xl text-zinc-700"></i>
                                <input type="radio" name="payment_method" value="cod" class="text-zinc-950 focus:ring-zinc-950">
                            </div>
                            <div>
                                <h4 class="font-bold text-xs text-zinc-900">COD (Bayar di Tempat)</h4>
                                <span class="text-[10px] text-zinc-500">Bayar saat kurir sampai</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-6">
                <h3 class="font-display font-bold text-base text-zinc-900 border-b border-zinc-100 pb-3">
                    Pesanan Anda ({{ $cart->total_quantity }} item)
                </h3>

                <!-- Small Items List -->
                <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                    @foreach($cart->items as $item)
                        <div class="flex items-center gap-3 text-xs">
                            <img src="{{ $item->variant->product->featured_image_url }}" alt="{{ $item->variant->product->name }}" 
                                 class="w-12 h-14 rounded-lg object-cover flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-zinc-900 truncate">{{ $item->variant->product->name }}</h4>
                                <span class="text-[10px] text-zinc-400">{{ $item->variant->size }} | {{ $item->variant->color }} x {{ $item->quantity }}</span>
                            </div>
                            <span class="font-bold text-zinc-900 whitespace-nowrap">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Price Breakdown -->
                <div class="border-t border-zinc-100 pt-4 space-y-2.5 text-xs">
                    <div class="flex justify-between text-zinc-600">
                        <span>Subtotal Produk</span>
                        <span class="font-semibold text-zinc-900">Rp {{ number_format($cart->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-zinc-600">
                        <span>Ongkos Kirim</span>
                        <span id="shippingCostLabel" class="font-semibold text-zinc-900">Rp 18.000</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="border-t border-zinc-100 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-zinc-400 block font-medium">Total Pembayaran</span>
                        <span id="grandTotalLabel" class="font-display font-extrabold text-2xl text-zinc-950">
                            Rp {{ number_format($cart->total_amount + 18000, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-2xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock"></i>
                    <span>Bayar Sekarang</span>
                </button>

                <p class="text-[11px] text-zinc-400 text-center leading-relaxed">
                    Dengan mengeklik tombol di atas, Anda menyetujui Syarat & Ketentuan Pembelian FashionMarket.
                </p>
            </div>

        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    const subtotal = {{ (float) $cart->total_amount }};

    function updateShipping(radio) {
        const cost = parseInt(radio.dataset.cost) || 0;
        document.getElementById('shippingCostLabel').textContent = 'Rp ' + cost.toLocaleString('id-ID');
        document.getElementById('grandTotalLabel').textContent = 'Rp ' + (subtotal + cost).toLocaleString('id-ID');
    }
</script>
@endpush
