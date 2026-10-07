@extends('layouts.app')

@section('title', 'Edit Produk ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="border-b border-zinc-200 pb-4">
        <a href="{{ route('seller.products.index') }}" class="inline-flex items-center gap-1.5 text-xs text-zinc-500 hover:text-zinc-900 mb-2 transition">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Daftar Produk
        </a>
        <h1 class="font-display text-2xl font-extrabold text-zinc-900">
            Edit Produk: {{ $product->name }}
        </h1>
    </div>

    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4 text-xs">
            <h3 class="font-display font-bold text-sm text-zinc-900 border-b border-zinc-100 pb-3">Informasi Utama Produk</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kategori Fashion *</label>
                    <select name="category_id" required class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 font-medium">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Harga Jual (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="1000" required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">URL Foto Utama Produk *</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $product->featured_image_url) }}" required
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap *</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="sm:col-span-2 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer font-bold text-zinc-800">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-brand-600 focus:ring-brand-500">
                        <span>Produk Aktif & Tampil di Katalog Publik</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('seller.products.index') }}" class="px-5 py-3 rounded-full border border-zinc-300 text-zinc-700 text-xs font-bold hover:bg-zinc-100 transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-full bg-zinc-950 hover:bg-brand-600 text-white text-xs font-bold uppercase tracking-wider transition shadow-lg">
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>
@endsection
