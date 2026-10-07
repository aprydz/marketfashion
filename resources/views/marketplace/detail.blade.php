@extends('layouts.app')

@section('title', $product->name . ' - Detail Produk Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-zinc-500">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('catalog') }}" class="hover:text-brand-600 transition">Katalog</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('catalog', ['category' => $product->category->slug]) }}" class="hover:text-brand-600 transition">{{ $product->category->name }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-zinc-900 font-semibold truncate max-w-xs">{{ $product->name }}</span>
    </nav>

    <!-- Main Product Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left: Image Gallery -->
        <div class="lg:col-span-6 space-y-4">
            <!-- Main Preview Container -->
            <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-zinc-100 border border-zinc-200/80 shadow-md relative group">
                <img id="mainImage" 
                     src="{{ $product->featured_image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover object-center transition-all duration-300">
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 rounded-full bg-zinc-950/80 backdrop-blur-md text-white text-xs font-semibold">
                        {{ $product->category->name }}
                    </span>
                </div>
            </div>

            <!-- Thumbnail Selector -->
            @if($product->images->count() > 1)
                <div class="flex items-center gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <button type="button" 
                                onclick="document.getElementById('mainImage').src = '{{ $img->image_path }}'"
                                class="w-20 h-24 rounded-xl overflow-hidden border-2 border-transparent hover:border-brand-500 focus:border-brand-500 transition flex-shrink-0">
                            <img src="{{ $img->image_path }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Product Information & Purchase Form -->
        <div class="lg:col-span-6 space-y-6">
            
            <!-- Seller Profile Pill -->
            <div class="flex items-center justify-between p-3.5 rounded-2xl bg-white border border-zinc-200/80 shadow-sm">
                <div class="flex items-center gap-3">
                    <img src="{{ $product->seller->avatar ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&q=80' }}" 
                         alt="{{ $product->seller->name }}" class="w-10 h-10 rounded-full object-cover border border-zinc-200">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <h4 class="font-display font-bold text-xs text-zinc-900">{{ $product->seller->name }}</h4>
                            <i class="fa-solid fa-circle-check text-brand-600 text-[10px]" title="Terverifikasi"></i>
                        </div>
                        <span class="text-[11px] text-zinc-400">Official Merchant & Designer</span>
                    </div>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-zinc-100 text-zinc-700">Toko Resmi</span>
            </div>

            <!-- Title & Rating -->
            <div>
                <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900 leading-snug">
                    {{ $product->name }}
                </h1>
                
                <div class="flex items-center gap-4 mt-3 text-xs">
                    <div class="flex items-center gap-1.5 text-amber-500 font-bold">
                        <i class="fa-solid fa-star"></i>
                        <span class="text-zinc-900">{{ $product->average_rating > 0 ? $product->average_rating : '5.0' }}</span>
                    </div>
                    <span class="text-zinc-300">|</span>
                    <span class="text-zinc-500">{{ $product->reviews->count() }} Ulasan Pembeli</span>
                    <span class="text-zinc-300">|</span>
                    <span class="text-emerald-600 font-semibold"><i class="fa-solid fa-check text-[10px]"></i> Stok Tersedia</span>
                </div>
            </div>

            <!-- Price -->
            <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-200/80 flex items-center justify-between">
                <div>
                    <span class="text-xs text-zinc-400 block font-medium">Harga Spesial</span>
                    <span class="font-display text-3xl font-extrabold text-zinc-950">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                        <i class="fa-solid fa-truck-fast"></i> Siap Kirim Hari Ini
                    </span>
                </div>
            </div>

            <!-- Variants Data JSON for JavaScript -->
            <div id="variantsData" class="hidden" data-variants="{{ json_encode($product->variants) }}"></div>

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-6" id="productForm">
                @csrf
                <input type="hidden" name="variant_id" id="selectedVariantId" value="{{ $product->variants->first()->id ?? '' }}">

                <!-- Variant Selector: Size & Color -->
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-bold text-zinc-800 uppercase tracking-wider">Pilih Varian (Ukuran & Warna):</span>
                            <span id="variantStockLabel" class="text-xs font-semibold text-zinc-500">
                                Stok: {{ $product->variants->first()->stock ?? 0 }} pcs
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="variantButtonsContainer">
                            @foreach($product->variants as $index => $variant)
                                <button type="button" 
                                        data-variant-id="{{ $variant->id }}"
                                        data-stock="{{ $variant->stock }}"
                                        onclick="selectVariant(this)"
                                        class="variant-btn p-3 rounded-xl border text-left transition flex flex-col justify-between 
                                        {{ $index === 0 ? 'border-zinc-950 bg-zinc-900 text-white shadow-md' : 'border-zinc-200 hover:border-zinc-400 bg-white text-zinc-800' }}">
                                    <span class="font-display font-bold text-xs">{{ $variant->size }}</span>
                                    <span class="text-[11px] opacity-80 mt-0.5">{{ $variant->color }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quantity Counter -->
                    <div>
                        <label class="block text-xs font-bold text-zinc-800 uppercase tracking-wider mb-2">Jumlah Pembelian</label>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center border border-zinc-200 rounded-xl bg-white overflow-hidden shadow-sm">
                                <button type="button" onclick="changeQty(-1)" class="w-10 h-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="quantity" id="quantityInput" value="1" min="1" max="99" 
                                       class="w-14 text-center font-bold text-sm text-zinc-900 border-none focus:outline-none">
                                <button type="button" onclick="changeQty(1)" class="w-10 h-10 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="text-xs text-zinc-400">Total belanja langsung terhitung di keranjang</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons: Cart & Wishlist -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" 
                            id="addToCartBtn"
                            class="flex-1 py-4 px-6 rounded-2xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-sm tracking-wide transition shadow-lg hover:shadow-zinc-950/20 flex items-center justify-center gap-2.5">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Tambah ke Keranjang</span>
                    </button>

                    <button type="button" 
                            onclick="document.getElementById('wishlistForm').submit()"
                            class="w-14 h-14 rounded-2xl border border-zinc-200 hover:border-rose-400 bg-white text-zinc-700 hover:text-rose-500 flex items-center justify-center text-lg transition shadow-sm" title="Simpan ke Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </div>
            </form>

            <form id="wishlistForm" action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="hidden">
                @csrf
            </form>

            <!-- Product Description Accordion/Box -->
            <div class="p-6 rounded-2xl bg-white border border-zinc-200/80 shadow-sm space-y-3">
                <h3 class="font-display font-bold text-sm text-zinc-900 uppercase tracking-wider">Deskripsi & Detail Bahan</h3>
                <div class="text-xs text-zinc-600 leading-relaxed space-y-2">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

        </div>

    </div>

    <!-- Customer Reviews Section -->
    <section class="p-8 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-100 pb-6">
            <div>
                <h2 class="font-display text-xl sm:text-2xl font-extrabold text-zinc-900">Ulasan & Penilaian Pelanggan</h2>
                <p class="text-xs text-zinc-500 mt-1">Ulasan nyata dari pembeli terverifikasi FashionMarket</p>
            </div>
            
            <div class="flex items-center gap-4 bg-zinc-50 px-5 py-3 rounded-2xl border border-zinc-100">
                <span class="font-display text-4xl font-extrabold text-zinc-900">{{ $product->average_rating > 0 ? $product->average_rating : '5.0' }}</span>
                <div>
                    <div class="flex items-center text-amber-400 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[11px] text-zinc-500">{{ $product->reviews->count() }} total ulasan</span>
                </div>
            </div>
        </div>

        @if($product->reviews->isEmpty())
            <div class="text-center py-8 text-zinc-400 text-xs">
                <i class="fa-regular fa-comment-dots text-3xl mb-2 block"></i>
                Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan penilaian setelah membeli!
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($product->reviews as $review)
                    <div class="p-5 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $review->user->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80' }}" 
                                     alt="{{ $review->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <h4 class="font-bold text-xs text-zinc-900">{{ $review->user->name }}</h4>
                                    <span class="text-[10px] text-zinc-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center text-amber-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-zinc-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-zinc-600 leading-relaxed italic">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <section class="space-y-6">
            <h2 class="font-display text-xl sm:text-2xl font-extrabold text-zinc-900">Koleksi Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="group bg-white rounded-2xl border border-zinc-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                        <div class="relative aspect-[4/5] bg-zinc-100 overflow-hidden">
                            <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <a href="{{ route('product.show', $rel->slug) }}" class="absolute inset-0"></a>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <h3 class="font-display font-bold text-sm text-zinc-900 group-hover:text-brand-600 transition truncate">
                                {{ $rel->name }}
                            </h3>
                            <div class="pt-3 border-t border-zinc-100 mt-2 flex items-center justify-between">
                                <span class="font-display font-extrabold text-sm text-zinc-900">
                                    Rp {{ number_format($rel->price, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('product.show', $rel->slug) }}" class="text-xs font-semibold text-brand-600 hover:underline">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function selectVariant(button) {
        // Remove active class from all buttons
        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.classList.remove('border-zinc-950', 'bg-zinc-900', 'text-white', 'shadow-md');
            btn.classList.add('border-zinc-200', 'bg-white', 'text-zinc-800');
        });

        // Add active style to selected button
        button.classList.add('border-zinc-950', 'bg-zinc-900', 'text-white', 'shadow-md');
        button.classList.remove('border-zinc-200', 'bg-white', 'text-zinc-800');

        const variantId = button.dataset.variantId;
        const stock = parseInt(button.dataset.stock) || 0;

        document.getElementById('selectedVariantId').value = variantId;
        document.getElementById('variantStockLabel').textContent = 'Stok: ' + stock + ' pcs';

        const qtyInput = document.getElementById('quantityInput');
        qtyInput.max = stock;
        if (parseInt(qtyInput.value) > stock) {
            qtyInput.value = Math.max(1, stock);
        }

        const addToCartBtn = document.getElementById('addToCartBtn');
        if (stock <= 0) {
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = 'Stok Habis';
            addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            addToCartBtn.disabled = false;
            addToCartBtn.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> <span>Tambah ke Keranjang</span>';
            addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function changeQty(delta) {
        const input = document.getElementById('quantityInput');
        let current = parseInt(input.value) || 1;
        const max = parseInt(input.max) || 99;
        let next = current + delta;
        if (next >= 1 && next <= max) {
            input.value = next;
        }
    }
</script>
@endpush
