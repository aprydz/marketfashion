@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - ' . $order->order_number)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12 space-y-8">
    
    <!-- Header Card -->
    <div class="bg-white p-8 rounded-3xl border border-zinc-200/80 shadow-md text-center space-y-4">
        
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 mx-auto flex items-center justify-center text-2xl">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>

        <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider">
            Menunggu Pembayaran
        </span>

        <h1 class="font-display font-extrabold text-2xl text-zinc-900">
            Selesaikan Pembayaran Pesanan
        </h1>
        <p class="text-xs text-zinc-500">
            Nomor Pesanan: <strong class="text-zinc-800 font-mono">{{ $order->order_number }}</strong>
        </p>

        <!-- Total Bill -->
        <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100 my-4">
            <span class="text-xs text-zinc-400 block font-medium">Total yang Harus Dibayar</span>
            <span class="font-display font-extrabold text-3xl text-zinc-950">
                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
            </span>
        </div>

        <!-- Payment Channel Details -->
        @if($order->payment && $order->payment->payment_method === 'bank_transfer')
            <div class="p-5 rounded-2xl bg-zinc-950 text-white text-left space-y-3">
                <div class="flex items-center justify-between text-xs text-zinc-400 border-b border-zinc-800 pb-2">
                    <span>Bank Transfer Virtual Account (BCA)</span>
                    <i class="fa-solid fa-building-columns text-amber-400"></i>
                </div>
                <div>
                    <span class="text-[11px] text-zinc-400 block">Nomor Virtual Account:</span>
                    <div class="flex items-center justify-between mt-1">
                        <span class="font-mono font-bold text-lg text-amber-300">88019 08123 45678</span>
                        <span class="text-[10px] text-zinc-400 px-2 py-0.5 rounded bg-zinc-800">Salin</span>
                    </div>
                </div>
            </div>
        @elseif($order->payment && $order->payment->payment_method === 'ewallet')
            <div class="p-6 rounded-2xl bg-white border-2 border-zinc-900 space-y-3">
                <span class="text-xs font-bold text-zinc-900 block">Scan QRIS dengan Aplikasi Apapun</span>
                <div class="w-44 h-44 mx-auto bg-zinc-100 rounded-xl flex items-center justify-center border border-zinc-200">
                    <i class="fa-solid fa-qrcode text-7xl text-zinc-800"></i>
                </div>
                <p class="text-[11px] text-zinc-500">GoPay, OVO, Dana, ShopeePay, LinkAja, Mobile Banking</p>
            </div>
        @else
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-left space-y-2">
                <h4 class="font-bold text-xs text-emerald-900">Metode Cash on Delivery (COD)</h4>
                <p class="text-xs text-emerald-700 leading-relaxed">
                    Pesanan Anda telah dicatat. Siapkan uang tunai pas sebesar <strong>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</strong> saat kurir mengantarkan paket.
                </p>
            </div>
        @endif

        <!-- Action / Simulation Confirmation Button -->
        <div class="pt-4 space-y-3">
            <form action="{{ route('orders.payment.confirm', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Simulasi Pembayaran Berhasil (Konfirmasi Instan)</span>
                </button>
            </form>

            <a href="{{ route('orders.show', $order->id) }}" class="inline-block text-xs font-semibold text-zinc-500 hover:text-zinc-900 transition">
                Lihat Detail Pesanan & Pengiriman
            </a>
        </div>

    </div>

</div>
@endsection
