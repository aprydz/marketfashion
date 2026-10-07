@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="bg-white rounded-3xl border border-zinc-200/80 shadow-xl p-8 sm:p-10 space-y-6">
        
        <div class="text-center space-y-1">
            <h1 class="font-display font-extrabold text-2xl text-zinc-900">Bergabung dengan FashionMarket</h1>
            <p class="text-xs text-zinc-500">Mulai pengalaman belanja kurasi busana atau buka toko desainer Anda</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <!-- Role Selector -->
            <div>
                <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-2">Daftar Sebagai *</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="p-3.5 rounded-2xl border cursor-pointer transition flex items-center gap-3 border-zinc-200 hover:border-zinc-400">
                        <input type="radio" name="role" value="customer" checked class="text-zinc-950 focus:ring-zinc-950">
                        <div>
                            <span class="font-bold text-zinc-900 block">Pembeli</span>
                            <span class="text-[10px] text-zinc-400">Belanja & koleksi fashion</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border cursor-pointer transition flex items-center gap-3 border-zinc-200 hover:border-zinc-400">
                        <input type="radio" name="role" value="seller" class="text-zinc-950 focus:ring-zinc-950">
                        <div>
                            <span class="font-bold text-zinc-900 block">Penjual (Seller)</span>
                            <span class="text-[10px] text-zinc-400">Buka toko busana gratis</span>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nama Lengkap atau Nama Toko *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       placeholder="cth: Rian Pratama atau Galeri Sutra"
                       class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
            </div>

            <div>
                <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Alamat Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       placeholder="nama@email.com"
                       class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
            </div>

            <div>
                <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Nomor Handphone / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       placeholder="081234567890"
                       class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Kata Sandi *</label>
                    <input type="password" name="password" required minlength="6"
                           placeholder="Minimal 6 karakter"
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>

                <div>
                    <label class="block font-bold text-zinc-700 uppercase tracking-wider mb-1.5">Konfirmasi Sandi *</label>
                    <input type="password" name="password_confirmation" required minlength="6"
                           placeholder="Ulangi kata sandi"
                           class="w-full px-3.5 py-2.5 bg-zinc-50 border border-zinc-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md mt-2">
                Daftar Akun Sekarang
            </button>
        </form>

        <div class="pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection
