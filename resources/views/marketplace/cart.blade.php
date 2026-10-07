@extends('layouts.app')

@section('title', 'Keranjang Belanja Anda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="border-b border-zinc-200 pb-4">
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
            Keranjang Belanja
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Periksa pilihan busana Anda sebelum melanjutkan ke proses pembayaran aman
        </p>
    </div>

    @if(!$cart || $cart->items->isEmpty())
        <div class="bg-white rounded-3xl p-16 border border-zinc-200 text-center space-y-5 max-w-xl mx-auto">
            <div class="w-20 h-20 rounded-full bg-zinc-100 text-zinc-400 mx-auto flex items-center justify-center text-3xl">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <h3 class="font-display font-bold text-xl text-zinc-900">Keranjang Belanja Masih Kosong</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">
                Anda belum menambahkan busana atau aksesori apa pun. Temukan tren busana terbaru dari desainer lokal sekarang!
            </p>
            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-zinc-950 text-white font-bold text-xs uppercase tracking-wider hover:bg-brand-600 transition shadow-md">
                <span>Eksplor Koleksi Fashion</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Cart Items List -->
            <div class="lg:col-span-8 space-y-4">
                @foreach($cart->items as $item)
                    <div class="p-5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                        
                        <div class="flex items-center gap-4">
                            <img src="{{ $item->variant->product->featured_image_url }}" 
                                 alt="{{ $item->variant->product->name }}" 
                                 class="w-20 h-24 rounded-xl object-cover border border-zinc-100 flex-shrink-0">
                            
                            <div class="space-y-1">
                                <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">
                                    {{ $item->variant->product->seller->name ?? 'Toko Fashion' }}
                                </span>
                                <h3 class="font-display font-bold text-sm text-zinc-900 hover:text-brand-600 transition">
                                    <a href="{{ route('product.show', $item->variant->product->slug) }}">
                                        {{ $item->variant->product->name }}
                                    </a>
                                </h3>
                                <div class="inline-flex items-center gap-2 text-xs text-zinc-500 bg-zinc-50 px-2.5 py-1 rounded-lg border border-zinc-100">
                                    <span>Ukuran: <strong class="text-zinc-800">{{ $item->variant->size }}</strong></span>
                                    <span>•</span>
                                    <span>Warna: <strong class="text-zinc-800">{{ $item->variant->color }}</strong></span>
                                </div>
                                <div class="text-xs font-bold text-zinc-900 pt-1">
                                    Rp {{ number_format($item->variant->product->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Controls & Subtotal -->
                        <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto gap-6 pt-3 sm:pt-0 border-t sm:border-t-0 border-zinc-100">
                            
                            <!-- Qty buttons -->
                            <div class="flex items-center border border-zinc-200 rounded-xl bg-zinc-50 overflow-hidden">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-zinc-500 hover:bg-zinc-200 transition">
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                </form>

                                <span class="w-10 text-center font-bold text-xs text-zinc-900">
                                    {{ $item->quantity }}
                                </span>

                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-zinc-500 hover:bg-zinc-200 transition" 
                                            {{ $item->quantity >= $item->variant->stock ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Subtotal Item -->
                            <div class="text-right">
                                <span class="text-[10px] text-zinc-400 block font-medium">Subtotal</span>
                                <span class="font-display font-extrabold text-sm text-zinc-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Delete Item -->
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-zinc-400 hover:text-rose-600 transition p-1" title="Hapus dari keranjang">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-6">
                <h3 class="font-display font-bold text-base text-zinc-900 border-b border-zinc-100 pb-3">
                    Ringkasan Belanja
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between text-zinc-600">
                        <span>Total Kuantitas Barang</span>
                        <span class="font-semibold text-zinc-800">{{ $cart->total_quantity }} item</span>
                    </div>
                    <div class="flex justify-between text-zinc-600">
                        <span>Total Harga Barang</span>
                        <span class="font-semibold text-zinc-800">Rp {{ number_format($cart->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-zinc-600">
                        <span>Estimasi Ongkos Kirim</span>
                        <span class="text-emerald-600 font-semibold">Dihitung di checkout</span>
                    </div>
                </div>

                <div class="border-t border-zinc-100 pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-zinc-500 block font-medium">Total Tagihan</span>
                        <span class="font-display font-extrabold text-2xl text-zinc-950">
                            Rp {{ number_format($cart->total_amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="w-full py-4 rounded-2xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-2">
                    <span>Lanjut ke Checkout</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>

                <div class="text-[11px] text-zinc-400 text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock text-emerald-600"></i>
                    <span>Transaksi terenkripsi & 100% aman</span>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
