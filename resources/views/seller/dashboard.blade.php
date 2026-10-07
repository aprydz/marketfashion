@extends('layouts.app')

@section('title', 'Seller Hub Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Header banner -->
    <div class="bg-gradient-to-r from-zinc-950 via-zinc-900 to-zinc-950 text-white p-8 rounded-3xl shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-6 border border-zinc-800">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 border border-emerald-500/30">
                <i class="fa-solid fa-store"></i> Seller Hub Portal
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white">
                Dashboard Toko: {{ Auth::user()->name }}
            </h1>
            <p class="text-xs text-zinc-400 mt-1">Pantau performa penjualan, ketersediaan stok, dan proses pesanan masuk secara real-time</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('seller.products.create') }}" class="px-5 py-3 rounded-full bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </a>
            <a href="{{ route('seller.orders.index') }}" class="px-5 py-3 rounded-full bg-zinc-800 hover:bg-zinc-700 text-white font-medium text-xs transition border border-zinc-700">
                Lihat Pesanan Masuk
            </a>
        </div>
    </div>

    <!-- Statistics Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Total Pendapatan</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> Penjualan terkonfirmasi
            </span>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Katalog Produk</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                {{ $totalProducts }}
            </div>
            <a href="{{ route('seller.products.index') }}" class="text-[11px] text-brand-600 font-semibold hover:underline block">
                Kelola inventaris produk &rarr;
            </a>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Perlu Diproses</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                {{ $pendingOrdersCount }}
            </div>
            <span class="text-[11px] text-amber-600 font-semibold">
                Pesanan yang menunggu pengiriman
            </span>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Status Toko</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-xl text-emerald-600 flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span> Aktif & Terverifikasi
            </div>
            <span class="text-[11px] text-zinc-400">Badge Merchant Fashion</span>
        </div>

    </div>

    <!-- Recent Incoming Order Items -->
    <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-zinc-100 pb-4">
            <div>
                <h3 class="font-display font-bold text-lg text-zinc-900">Aktivitas Pesanan Terbaru</h3>
                <p class="text-xs text-zinc-500">Pesanan pembeli yang memuat produk dari toko Anda</p>
            </div>
            <a href="{{ route('seller.orders.index') }}" class="text-xs font-semibold text-brand-600 hover:underline">
                Lihat Semua &rarr;
            </a>
        </div>

        @if($recentItems->isEmpty())
            <div class="text-center py-12 text-zinc-400 text-xs">
                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                Belum ada pesanan masuk untuk toko Anda saat ini.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 text-zinc-400 uppercase tracking-wider font-semibold">
                            <th class="pb-3">No. Order</th>
                            <th class="pb-3">Produk & Varian</th>
                            <th class="pb-3">Pembeli</th>
                            <th class="pb-3">Total Subtotal</th>
                            <th class="pb-3">Status Order</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach($recentItems as $item)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="py-4 font-mono font-bold text-zinc-900">
                                    {{ $item->order->order_number }}
                                </td>
                                <td class="py-4 font-medium text-zinc-800">
                                    <div>{{ $item->product_name }}</div>
                                    <span class="text-[10px] text-zinc-400">{{ $item->size }} | {{ $item->color }} ({{ $item->quantity }}x)</span>
                                </td>
                                <td class="py-4 text-zinc-600">
                                    {{ $item->order->recipient_name }}
                                </td>
                                <td class="py-4 font-bold text-zinc-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="py-4">
                                    @php $badge = $item->order->status_badge; @endphp
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $badge['class'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('seller.orders.index') }}" class="px-3 py-1.5 rounded-lg bg-zinc-900 text-white text-[11px] font-semibold hover:bg-brand-600 transition">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
