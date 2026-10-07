@extends('layouts.app')

@section('title', 'Katalog Produk Toko Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-zinc-500 mb-1">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-zinc-900">Seller Hub</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-zinc-900 font-semibold">Produk Toko</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
                Kelola Inventaris Produk
            </h1>
        </div>

        <a href="{{ route('seller.products.create') }}" class="px-5 py-2.5 rounded-full bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk Baru
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm">
        @if($products->isEmpty())
            <div class="text-center py-16 text-zinc-400 text-xs space-y-4">
                <i class="fa-solid fa-boxes-packing text-4xl block"></i>
                <h3 class="font-display font-bold text-base text-zinc-800">Toko Anda Belum Memiliki Produk</h3>
                <p>Mulai tambahkan produk busana pertama Anda sekarang juga untuk dilihat ribuan pembeli!</p>
                <a href="{{ route('seller.products.create') }}" class="inline-block px-6 py-2.5 rounded-full bg-zinc-950 text-white font-semibold">
                    Tambah Produk Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 text-zinc-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">Produk</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Harga Jual</th>
                            <th class="pb-3">Varian & Total Stok</th>
                            <th class="pb-3">Ulasan</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-4 font-medium text-zinc-800">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" 
                                             class="w-12 h-14 rounded-xl object-cover border border-zinc-100 flex-shrink-0">
                                        <div>
                                            <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="font-bold text-zinc-900 hover:text-brand-600 transition block truncate max-w-xs">
                                                {{ $product->name }}
                                            </a>
                                            <span class="text-[10px] text-zinc-400 font-mono">{{ $product->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-zinc-600">
                                    <span class="px-2.5 py-1 rounded-full bg-zinc-100 text-[10px] font-semibold text-zinc-700">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="py-4 font-bold text-zinc-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4 text-zinc-600">
                                    <span class="font-bold text-zinc-900">{{ $product->total_stock }} pcs</span>
                                    <span class="text-[10px] text-zinc-400 block">({{ $product->variants->count() }} variasi)</span>
                                </td>
                                <td class="py-4 text-zinc-600">
                                    <div class="flex items-center gap-1 text-amber-500 font-bold">
                                        <i class="fa-solid fa-star text-[10px]"></i>
                                        <span>{{ $product->average_rating > 0 ? $product->average_rating : '5.0' }}</span>
                                        <span class="text-[10px] text-zinc-400 font-normal">({{ $product->reviews_count }})</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    @if($product->is_active)
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-zinc-100 text-zinc-600 text-[10px] font-bold">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('seller.products.edit', $product->id) }}" class="p-2 rounded-lg bg-zinc-100 hover:bg-zinc-200 text-zinc-700 transition" title="Edit Produk">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('seller.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition" title="Hapus Produk">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-4 border-t border-zinc-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
