@extends('layouts.app')

@section('title', 'Tambah Produk Busana Baru')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Header -->
    <div class="border-b border-zinc-200 pb-4">
        <a href="{{ route('seller.products.index') }}" class="inline-flex items-center gap-1.5 text-xs text-zinc-500 hover:text-zinc-900 mb-2 transition">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Daftar Produk
        </a>
        <h1 class="font-display text-2xl font-extrabold text-zinc-900">
            Tambah Produk Busana Baru
        </h1>
        <p class="text-xs text-zinc-500 mt-0.5">Isi detail busana dan tentukan variasi ukuran serta warna</p>
    </div>

    <form action="{{ route('seller.products.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- General Info Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4 text-xs">
            <h3 class="font-display font-bold text-sm text-zinc-900 border-b border-zinc-100 pb-3">Informasi Utama Produk</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Kemeja Denim Vintage Oversized" required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kategori Fashion *</label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 font-medium">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Harga Jual (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="Contoh: 350000" min="1000" required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">URL Foto Utama Produk (High-Res) *</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    <span class="text-[10px] text-zinc-400 mt-1 block">Gunakan tautan gambar Unsplash atau CDN gambar format JPG/PNG/WebP</span>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap, Bahan & Detail Ukuran *</label>
                    <textarea name="description" rows="4" required placeholder="Jelaskan jenis material kain, potongan pola, furing, dan keunggulan busana..."
                              class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Variants Matrix Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4 text-xs">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <div>
                    <h3 class="font-display font-bold text-sm text-zinc-900">Variasi Ukuran & Warna Produk</h3>
                    <p class="text-[11px] text-zinc-400">Tentukan kombinasi ukuran (Size), warna (Color), dan stok masing-masing</p>
                </div>
                <button type="button" onclick="addVariantRow()" class="px-3.5 py-1.5 rounded-lg bg-zinc-100 hover:bg-zinc-200 text-zinc-800 font-bold text-[11px] transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah Varian
                </button>
            </div>

            <div id="variantsContainer" class="space-y-3">
                <!-- Variant Row 0 -->
                <div class="variant-row grid grid-cols-1 sm:grid-cols-12 gap-3 items-center p-3.5 rounded-2xl bg-zinc-50 border border-zinc-200">
                    <div class="sm:col-span-4">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Ukuran / Size (cth: S, M, L, XL, 41)</label>
                        <input type="text" name="variants[0][size]" value="M" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Warna (cth: Hitam, Navy, Beige)</label>
                        <input type="text" name="variants[0][color]" value="Hitam Pekat" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Jumlah Stok</label>
                        <input type="number" name="variants[0][stock]" value="25" min="0" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-1 text-center pt-4 sm:pt-0">
                        <button type="button" onclick="removeVariantRow(this)" class="text-zinc-400 hover:text-rose-500 p-1" title="Hapus varian">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>

                <!-- Variant Row 1 -->
                <div class="variant-row grid grid-cols-1 sm:grid-cols-12 gap-3 items-center p-3.5 rounded-2xl bg-zinc-50 border border-zinc-200">
                    <div class="sm:col-span-4">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Ukuran / Size</label>
                        <input type="text" name="variants[1][size]" value="L" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Warna</label>
                        <input type="text" name="variants[1][color]" value="Hitam Pekat" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Jumlah Stok</label>
                        <input type="number" name="variants[1][stock]" value="20" min="0" required
                               class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
                    </div>
                    <div class="sm:col-span-1 text-center pt-4 sm:pt-0">
                        <button type="button" onclick="removeVariantRow(this)" class="text-zinc-400 hover:text-rose-500 p-1" title="Hapus varian">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('seller.products.index') }}" class="px-5 py-3 rounded-full border border-zinc-300 text-zinc-700 text-xs font-bold hover:bg-zinc-100 transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-full bg-zinc-950 hover:bg-brand-600 text-white text-xs font-bold uppercase tracking-wider transition shadow-lg">
                Publikasikan Produk ke Etalase
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    let variantCount = 2;

    function addVariantRow() {
        const container = document.getElementById('variantsContainer');
        const row = document.createElement('div');
        row.className = 'variant-row grid grid-cols-1 sm:grid-cols-12 gap-3 items-center p-3.5 rounded-2xl bg-zinc-50 border border-zinc-200';
        row.innerHTML = `
            <div class="sm:col-span-4">
                <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Ukuran / Size</label>
                <input type="text" name="variants[${variantCount}][size]" placeholder="XL" required
                       class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
            </div>
            <div class="sm:col-span-4">
                <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Warna</label>
                <input type="text" name="variants[${variantCount}][color]" placeholder="Hitam" required
                       class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
            </div>
            <div class="sm:col-span-3">
                <label class="block text-[10px] uppercase font-bold text-zinc-500 mb-1">Jumlah Stok</label>
                <input type="number" name="variants[${variantCount}][stock]" value="10" min="0" required
                       class="w-full px-3 py-1.5 bg-white border border-zinc-200 rounded-lg focus:outline-none">
            </div>
            <div class="sm:col-span-1 text-center pt-4 sm:pt-0">
                <button type="button" onclick="removeVariantRow(this)" class="text-zinc-400 hover:text-rose-500 p-1" title="Hapus varian">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        variantCount++;
    }

    function removeVariantRow(btn) {
        const rows = document.querySelectorAll('.variant-row');
        if (rows.length <= 1) {
            alert('Minimal produk harus memiliki 1 varian.');
            return;
        }
        btn.closest('.variant-row').remove();
    }
</script>
@endpush
