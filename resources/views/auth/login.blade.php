@extends('layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl border border-zinc-200/80 shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Side: Editorial Art Banner -->
        <div class="lg:col-span-5 bg-zinc-950 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -top-20 -left-20 w-60 h-60 bg-brand-500/20 rounded-full blur-2xl"></div>
            <div class="relative z-10 space-y-4">
                <span class="text-[10px] uppercase font-bold tracking-widest text-amber-300">Welcome Back</span>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl leading-snug">
                    Pintu Menuju Koleksi Fashion Terbaik
                </h2>
                <p class="text-xs text-zinc-400 leading-relaxed">
                    Akses ribuan busana desainer lokal, lacak paket pesanan Anda, atau kelola toko busana Anda dengan mudah.
                </p>
            </div>

            <!-- Quick Demo Login Box -->
            <div class="relative z-10 mt-8 p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-3">
                <span class="text-[11px] font-bold text-amber-300 flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt"></i> Masuk Instan Akun Demo:
                </span>
                <div class="space-y-1.5">
                    <form action="{{ route('quick.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="customer">
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-zinc-900/90 hover:bg-zinc-800 text-left text-xs font-semibold text-zinc-200 flex items-center justify-between transition border border-zinc-700">
                            <span><i class="fa-solid fa-user mr-1.5 text-blue-400"></i> Akun Pembeli (Rian)</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-zinc-400"></i>
                        </button>
                    </form>

                    <form action="{{ route('quick.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="seller">
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-zinc-900/90 hover:bg-zinc-800 text-left text-xs font-semibold text-zinc-200 flex items-center justify-between transition border border-zinc-700">
                            <span><i class="fa-solid fa-store mr-1.5 text-emerald-400"></i> Akun Penjual (Batik Queen)</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-zinc-400"></i>
                        </button>
                    </form>

                    <form action="{{ route('quick.login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="admin">
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-zinc-900/90 hover:bg-zinc-800 text-left text-xs font-semibold text-zinc-200 flex items-center justify-between transition border border-zinc-700">
                            <span><i class="fa-solid fa-shield-halved mr-1.5 text-purple-400"></i> Akun Admin Platform</span>
                            <i class="fa-solid fa-arrow-right text-[10px] text-zinc-400"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Standard Form -->
        <div class="lg:col-span-7 p-8 sm:p-12 space-y-6">
            <div>
                <h1 class="font-display font-extrabold text-2xl text-zinc-900">Masuk ke Akun</h1>
                <p class="text-xs text-zinc-500 mt-1">Gunakan alamat email dan kata sandi Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Alamat Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com"
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kata Sandi *</label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-zinc-600">
                        <input type="checkbox" name="remember" class="rounded text-brand-600 focus:ring-brand-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                    <a href="#" class="text-brand-600 hover:underline font-semibold">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">
                    Masuk Sekarang
                </button>
            </form>

            <div class="pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline">Daftar sekarang gratis</a>
            </div>
        </div>

    </div>
</div>
@endsection
