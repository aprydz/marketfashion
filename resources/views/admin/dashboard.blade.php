@extends('layouts.app')

@section('title', 'Admin Platform Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Header banner -->
    <div class="bg-gradient-to-r from-purple-950 via-zinc-900 to-black text-white p-8 rounded-3xl shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-6 border border-purple-900/40">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-semibold mb-3 border border-purple-500/30">
                <i class="fa-solid fa-shield-halved"></i> Platform Admin Control
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white">
                Pusat Kendali FashionMarket
            </h1>
            <p class="text-xs text-zinc-400 mt-1">Ringkasan analitik transaksi platform, pengguna, dan tata kelola katalog</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-full bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center gap-2">
                <i class="fa-solid fa-users"></i> Kelola Pengguna
            </a>
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-3 rounded-full bg-zinc-800 hover:bg-zinc-700 text-white font-medium text-xs transition border border-zinc-700">
                Kelola Kategori
            </a>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Gross Merchandise Value</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                Rp {{ number_format($totalGmv, 0, ',', '.') }}
            </div>
            <span class="text-[11px] text-purple-600 font-semibold">Total transaksi platform</span>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Total Pesanan</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                {{ $totalOrders }}
            </div>
            <span class="text-[11px] text-zinc-500">Akumulasi seluruh checkout</span>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Total Pengguna</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                {{ $totalUsers }}
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-[11px] text-purple-600 font-semibold hover:underline block">
                Lihat detail pengguna &rarr;
            </a>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-zinc-200/80 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-xs text-zinc-500">
                <span class="font-semibold uppercase tracking-wider">Produk Terdaftar</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <div class="font-display font-extrabold text-2xl text-zinc-900">
                {{ $totalProducts }}
            </div>
            <span class="text-[11px] text-zinc-500">Di seluruh katalog toko</span>
        </div>

    </div>

    <!-- Tables Grid: Recent Orders & Recent Users -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Orders -->
        <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm space-y-4">
            <h3 class="font-display font-bold text-base text-zinc-900 border-b border-zinc-100 pb-3">Pesanan Terbaru Platform</h3>
            <div class="space-y-3">
                @foreach($recentOrders as $ro)
                    @php $badge = $ro->status_badge; @endphp
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-zinc-50 border border-zinc-100 text-xs">
                        <div>
                            <span class="font-mono font-bold text-zinc-900">{{ $ro->order_number }}</span>
                            <p class="text-zinc-500 text-[11px]">{{ $ro->user->name ?? 'Guest' }} • {{ $ro->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-zinc-900 block">Rp {{ number_format($ro->grand_total, 0, ',', '.') }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                <h3 class="font-display font-bold text-base text-zinc-900">Pengguna Terdaftar Baru</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-purple-600 hover:underline">Semua User &rarr;</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $ru)
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-zinc-50 border border-zinc-100 text-xs">
                        <div class="flex items-center gap-3">
                            <img src="{{ $ru->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80' }}" 
                                 alt="{{ $ru->name }}" class="w-8 h-8 rounded-full object-cover">
                            <div>
                                <span class="font-bold text-zinc-900">{{ $ru->name }}</span>
                                <p class="text-zinc-400 text-[11px]">{{ $ru->email }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                            {{ $ru->isAdmin() ? 'bg-purple-100 text-purple-700' : ($ru->isSeller() ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $ru->role }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
