@extends('layouts.app')

@section('title', 'Katalog Busana & Aksesoris Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Breadcrumb & Title -->
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-zinc-500 mb-2">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-zinc-900 font-medium">Katalog Fashion</span>
            @if(request('category'))
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-brand-600 font-semibold capitalize">{{ request('category') }}</span>
            @endif
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
                    Koleksi Busana & Aksesoris
                </h1>
                <p class="text-xs text-zinc-500 mt-1">
                    Menampilkan {{ $products->total() }} pilihan busana fashion eksklusif
                </p>
            </div>

            <!-- Sorting Select in Header -->
            <form id="sortForm" action="{{ route('catalog') }}" method="GET" class="flex items-center gap-2">
                @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

                <label for="sort" class="text-xs text-zinc-500 font-medium whitespace-nowrap">Urutkan:</label>
                <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit()" 
                        class="bg-white border border-zinc-200 text-xs font-semibold text-zinc-800 rounded-full px-3.5 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
        
        <!-- Filter Sidebar -->
        <aside class="lg:col-span-1 bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
                <h3 class="font-display font-bold text-base text-zinc-900">Filter Produk</h3>
                <a href="{{ route('catalog') }}" class="text-[11px] font-semibold text-rose-500 hover:underline">Reset</a>
            </div>

            <form action="{{ route('catalog') }}" method="GET" class="space-y-6">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <!-- Search Input in Filter -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Kata Kunci</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama barang..."
                           class="w-full text-xs px-3 py-2 bg-zinc-50 border border-zinc-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <!-- Categories List -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Kategori</label>
                    <div class="space-y-1.5 text-xs">
                        <label class="flex items-center gap-2 cursor-pointer hover:text-brand-600 transition">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-500">
                            <span class="text-zinc-700 font-medium">Semua Kategori</span>
                        </label>
                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2 cursor-pointer hover:text-brand-600 transition">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-brand-600 focus:ring-brand-500">
                                <span class="text-zinc-700 font-medium">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-xs font-bold text-zinc-700 uppercase tracking-wider mb-2">Rentang Harga (Rp)</label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                               class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-brand-500">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maks"
                               class="w-full px-2.5 py-1.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-brand-500">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-zinc-950 hover:bg-zinc-800 text-white text-xs font-bold uppercase tracking-wider transition">
                    Terapkan Filter
                </button>
            </form>
        </aside>

        <!-- Product Grid Results -->
        <main class="lg:col-span-3 space-y-6">
            
            @if($products->isEmpty())
                <div class="bg-white rounded-3xl p-12 border border-zinc-200 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-zinc-100 text-zinc-400 mx-auto flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="font-display font-bold text-lg text-zinc-900">Produk Tidak Ditemukan</h3>
                    <p class="text-xs text-zinc-500 max-w-sm mx-auto">
                        Maaf, tidak ada produk busana yang sesuai dengan kriteria pencarian Anda. Coba sesuaikan filter atau reset kata kunci.
                    </p>
                    <a href="{{ route('catalog') }}" class="inline-block px-5 py-2.5 rounded-full bg-zinc-900 text-white text-xs font-semibold hover:bg-zinc-800 transition">
                        Reset Semua Filter
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl border border-zinc-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                            
                            <!-- Product Image -->
                            <div class="relative aspect-[4/5] bg-zinc-100 overflow-hidden">
                                <img src="{{ $product->featured_image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-0.5 rounded-full bg-zinc-950/80 backdrop-blur-md text-white text-[10px] font-semibold tracking-wide">
                                        {{ $product->category->name }}
                                    </span>
                                </div>

                                <div class="absolute top-3 right-3">
                                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-zinc-700 hover:text-rose-500 hover:bg-white flex items-center justify-center text-xs shadow-sm transition">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                </div>

                                <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0"></a>
                            </div>

                            <!-- Info -->
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between text-xs text-zinc-500 mb-1">
                                        <span class="truncate max-w-[130px]">{{ $product->seller->name ?? 'Official Store' }}</span>
                                        <div class="flex items-center gap-1 text-amber-500">
                                            <i class="fa-solid fa-star text-[11px]"></i>
                                            <span class="font-semibold text-zinc-800">{{ $product->average_rating > 0 ? $product->average_rating : '5.0' }}</span>
                                        </div>
                                    </div>

                                    <h3 class="font-display font-bold text-sm text-zinc-900 group-hover:text-brand-600 transition line-clamp-2 leading-snug">
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                </div>

                                <div class="pt-4 border-t border-zinc-100 mt-3 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-zinc-400 block uppercase font-medium">Harga</span>
                                        <span class="font-display font-extrabold text-base text-zinc-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <a href="{{ route('product.show', $product->slug) }}" class="px-3.5 py-1.5 rounded-full bg-zinc-950 text-white text-xs font-semibold hover:bg-brand-600 transition">
                                        Lihat
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $products->links() }}
                </div>
            @endif

        </main>

    </div>

</div>
@endsection
