@extends('layouts.app')

@section('title', 'Koleksi Fashion Terkurasi & Tren Busana Modern')

@section('content')
<div class="space-y-16 lg:space-y-24">

    <!-- Hero Editorial Banner -->
    <section class="relative overflow-hidden bg-zinc-950 text-white rounded-3xl mx-4 sm:mx-6 lg:mx-8 mt-4 shadow-2xl">
        <!-- Background subtle glow -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 sm:px-12 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Headline -->
            <div class="lg:col-span-7 space-y-6 z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-amber-300 font-semibold tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> New Season 2026 Collection
                </div>

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] text-white">
                    Definisikan Gaya Anda dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-brand-300 to-amber-400">Elegansi Modern</span>
                </h1>

                <p class="text-zinc-300 text-base sm:text-lg max-w-xl font-normal leading-relaxed">
                    Eksplorasi ribuan busana terkurasi dari desainer lokal terbaik—mulai dari batik sutra kontemporer, streetwear premium, hingga sneakers eksklusif.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('catalog') }}" class="px-8 py-4 rounded-full bg-white text-zinc-950 font-bold text-sm hover:bg-brand-100 transition shadow-lg hover:shadow-white/20 hover:-translate-y-0.5 duration-200 flex items-center gap-2.5">
                        <span>Belanja Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('catalog', ['category' => 'streetwear']) }}" class="px-8 py-4 rounded-full bg-zinc-900 text-white font-medium text-sm hover:bg-zinc-800 border border-zinc-700 transition">
                        Lihat Streetwear
                    </a>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-zinc-800/80">
                    <div>
                        <span class="font-display text-2xl lg:text-3xl font-extrabold text-white block">1.500+</span>
                        <span class="text-xs text-zinc-400">Koleksi Terverifikasi</span>
                    </div>
                    <div>
                        <span class="font-display text-2xl lg:text-3xl font-extrabold text-white block">100%</span>
                        <span class="text-xs text-zinc-400">Garansi Orisinal</span>
                    </div>
                    <div>
                        <span class="font-display text-2xl lg:text-3xl font-extrabold text-white block">4.9 / 5</span>
                        <span class="text-xs text-zinc-400">Kepuasan Pelanggan</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual Collage -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md lg:max-w-none">
                    <!-- Main Card -->
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10 group relative">
                        <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80" 
                             alt="Fashion Spotlight" 
                             class="w-full h-[460px] object-cover object-center group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        
                        <!-- Floating Glass Pill -->
                        <div class="absolute bottom-6 left-6 right-6 p-4 rounded-xl bg-white/15 backdrop-blur-md border border-white/20 text-white flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold tracking-widest text-amber-300">Editor's Pick</span>
                                <h4 class="text-sm font-semibold">Batik Silk Modern Peplum</h4>
                                <p class="text-xs text-zinc-300">Rp 389.000</p>
                            </div>
                            <a href="{{ route('product.show', 'batik-silk-modern-peplum-blouse') }}" class="w-9 h-9 rounded-full bg-white text-zinc-950 flex items-center justify-center text-xs hover:scale-110 transition">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Value Propositions -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex items-center gap-4 p-5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm hover:border-zinc-300 transition">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-display font-bold text-sm text-zinc-900">100% Produk Original</h4>
                    <p class="text-xs text-zinc-500">Dari butik & kurasi resmi</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm hover:border-zinc-300 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-display font-bold text-sm text-zinc-900">Pengiriman Cepat</h4>
                    <p class="text-xs text-zinc-500">JNE, SiCepat, & J&T Express</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm hover:border-zinc-300 transition">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </div>
                <div>
                    <h4 class="font-display font-bold text-sm text-zinc-900">Garansi Tukar Ukuran</h4>
                    <p class="text-xs text-zinc-500">Jaminan retur 7 hari kerja</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm hover:border-zinc-300 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-display font-bold text-sm text-zinc-900">Layanan Pelanggan</h4>
                    <p class="text-xs text-zinc-500">Dukungan ramah & responsif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block">Kategori Fashion</span>
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">Pilih Berdasarkan Gaya Anda</h2>
            </div>
            <a href="{{ route('catalog') }}" class="text-xs font-semibold text-zinc-600 hover:text-brand-600 flex items-center gap-1.5 transition">
                Lihat Semua Kategori <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('catalog', ['category' => $category->slug]) }}" 
                   class="group p-5 rounded-2xl bg-white border border-zinc-200/80 hover:border-brand-500/60 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center justify-center">
                    <div class="w-14 h-14 rounded-2xl bg-zinc-100 group-hover:bg-brand-50 text-zinc-700 group-hover:text-brand-600 flex items-center justify-center text-2xl transition-transform duration-300 group-hover:scale-110 mb-3">
                        <i class="{{ $category->icon ?? 'fa-solid fa-tag' }}"></i>
                    </div>
                    <h3 class="font-display font-bold text-sm text-zinc-900 group-hover:text-brand-600 transition">{{ $category->name }}</h3>
                    <span class="text-[11px] text-zinc-400 mt-0.5">{{ $category->products_count }} Produk</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Curated Featured Drops -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block">Koleksi Terpopuler</span>
                <h2 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">Produk Paling Dicari Pekan Ini</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('catalog') }}" class="px-4 py-2 rounded-full border border-zinc-300 hover:border-zinc-900 text-xs font-semibold text-zinc-800 transition">
                    Jelajahi Semua Produk
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-2xl border border-zinc-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    
                    <!-- Product Image Container -->
                    <div class="relative aspect-[4/5] bg-zinc-100 overflow-hidden">
                        <img src="{{ $product->featured_image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

                        <!-- Top Badges -->
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            <span class="px-2.5 py-0.5 rounded-full bg-zinc-950/80 backdrop-blur-md text-white text-[10px] font-semibold tracking-wide">
                                {{ $product->category->name }}
                            </span>
                        </div>

                        <!-- Wishlist Toggle -->
                        <div class="absolute top-3 right-3">
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-zinc-700 hover:text-rose-500 hover:bg-white flex items-center justify-center text-xs shadow-sm transition">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Quick view link overlay button -->
                        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0"></a>
                    </div>

                    <!-- Product Details -->
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between text-xs text-zinc-500 mb-1">
                                <span class="truncate max-w-[140px]">{{ $product->seller->name ?? 'Official Store' }}</span>
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
                                Detail
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    <!-- Curated Brand Showcase Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-br from-brand-950 via-zinc-900 to-black text-white p-8 sm:p-12 relative overflow-hidden">
            <div class="relative z-10 max-w-2xl space-y-4">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400">Kolaborasi Eksklusif</span>
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold leading-tight">
                    Batik Tulis Warisan Nusantara x Modern Silhouettes
                </h2>
                <p class="text-zinc-300 text-sm leading-relaxed">
                    Setiap helai kain ditenun dengan presisi tradisi, dipadukan siluet modern yang dirancang untuk generasi muda yang bangga berkarya.
                </p>
                <div class="pt-4">
                    <a href="{{ route('catalog', ['category' => 'wanita']) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand-500 hover:bg-brand-400 text-white font-bold text-xs uppercase tracking-wider transition">
                        <span>Lihat Koleksi Batik Queen</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
