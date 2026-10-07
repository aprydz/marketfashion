@extends('layouts.app')

@section('title', 'Kelola Kategori Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-zinc-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-zinc-900">Admin Control</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-zinc-900 font-semibold">Kategori Platform</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
                Kelola Kategori Fashion
            </h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Add Category Form -->
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-4 text-xs">
            <h3 class="font-display font-bold text-sm text-zinc-900 border-b border-zinc-100 pb-3">Tambah Kategori Baru</h3>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Kategori *</label>
                    <input type="text" name="name" required placeholder="cth: Aksesoris Pria" 
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Icon FontAwesome</label>
                    <input type="text" name="icon" placeholder="cth: fa-solid fa-glasses" 
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                    <span class="text-[10px] text-zinc-400 mt-1 block">Class icon FontAwesome (v6)</span>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">
                    Simpan Kategori Baru
                </button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 text-zinc-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">Icon</th>
                            <th class="pb-3">Nama Kategori</th>
                            <th class="pb-3">Slug</th>
                            <th class="pb-3">Jumlah Produk</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($categories as $cat)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-4 text-purple-600 text-base">
                                    <i class="{{ $cat->icon ?? 'fa-solid fa-tag' }}"></i>
                                </td>
                                <td class="py-4 font-bold text-zinc-900">{{ $cat->name }}</td>
                                <td class="py-4 font-mono text-zinc-500">{{ $cat->slug }}</td>
                                <td class="py-4 font-semibold text-zinc-800">{{ $cat->products_count }} produk</td>
                                <td class="py-4 text-right">
                                    @if($cat->products_count === 0)
                                        <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Hapus Kategori">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] text-zinc-400 italic">Memiliki produk</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
