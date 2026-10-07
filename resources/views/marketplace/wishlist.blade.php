@extends('layouts.app')

@section('title', 'Wishlist Favorit Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="border-b border-zinc-200 pb-4">
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
            Wishlist Saya
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Koleksi busana impian yang Anda simpan untuk dipesan nanti
        </p>
    </div>

    @if(!$wishlist || $wishlist->items->isEmpty())
        <div class="bg-white rounded-3xl p-16 border border-zinc-200 text-center space-y-4 max-w-md mx-auto">
            <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-400 mx-auto flex items-center justify-center text-2xl">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h3 class="font-display font-bold text-lg text-zinc-900">Wishlist Masih Kosong</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">
                Tekan tombol ikon hati pada produk apa pun untuk menyimpannya ke dalam wishlist Anda.
            </p>
            <a href="{{ route('catalog') }}" class="inline-block px-6 py-2.5 rounded-full bg-zinc-950 text-white text-xs font-semibold hover:bg-brand-600 transition">
                Jelajahi Katalog Fashion
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlist->items as $item)
                @php $product = $item->product; @endphp
                <div class="group bg-white rounded-2xl border border-zinc-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    
                    <div class="relative aspect-[4/5] bg-zinc-100 overflow-hidden">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                        <div class="absolute top-3 right-3">
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-white text-rose-500 shadow-sm flex items-center justify-center text-xs hover:scale-110 transition" title="Hapus dari Wishlist">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0"></a>
                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] text-zinc-400 uppercase font-semibold block mb-1">{{ $product->category->name }}</span>
                            <h3 class="font-display font-bold text-sm text-zinc-900 hover:text-brand-600 transition truncate">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                        </div>

                        <div class="pt-4 border-t border-zinc-100 mt-3 flex items-center justify-between">
                            <span class="font-display font-extrabold text-base text-zinc-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('product.show', $product->slug) }}" class="px-3 py-1.5 rounded-full bg-zinc-950 text-white text-xs font-semibold hover:bg-brand-600 transition">
                                Lihat
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
