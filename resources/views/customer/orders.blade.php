@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="border-b border-zinc-200 pb-4">
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
            Pesanan Saya
        </h1>
        <p class="text-xs text-zinc-500 mt-1">
            Pantau status proses pengiriman dan riwayat belanja busana Anda
        </p>
    </div>

    <!-- Status Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs">
        @php
            $currentStatus = request('status', 'all');
            $tabs = [
                'all' => 'Semua Pesanan',
                'pending' => 'Menunggu Pembayaran',
                'paid' => 'Sudah Dibayar',
                'processing' => 'Diproses',
                'shipped' => 'Dalam Pengiriman',
                'delivered' => 'Selesai',
            ];
        @endphp

        @foreach($tabs as $key => $label)
            <a href="{{ route('orders.index', ['status' => $key]) }}" 
               class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap 
               {{ $currentStatus === $key ? 'bg-zinc-950 text-white shadow-sm' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-zinc-400' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-16 border border-zinc-200 text-center space-y-4 max-w-md mx-auto">
            <div class="w-16 h-16 rounded-full bg-zinc-100 text-zinc-400 mx-auto flex items-center justify-center text-2xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="font-display font-bold text-lg text-zinc-900">Belum Ada Pesanan</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">
                Anda belum memiliki pesanan dengan filter status ini.
            </p>
            <a href="{{ route('catalog') }}" class="inline-block px-6 py-2.5 rounded-full bg-zinc-950 text-white text-xs font-semibold hover:bg-brand-600 transition">
                Mulai Belanja Sekarang
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                @php $badge = $order->status_badge; @endphp
                <div class="bg-white rounded-2xl border border-zinc-200/80 p-5 shadow-sm space-y-4">
                    
                    <!-- Card Top Header -->
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 pb-3 text-xs">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold text-zinc-900">{{ $order->order_number }}</span>
                            <span class="text-zinc-400">•</span>
                            <span class="text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <!-- Items Preview -->
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between gap-4 text-xs">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->variant->product->featured_image_url ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=150&q=80' }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="w-14 h-16 rounded-xl object-cover border border-zinc-100 flex-shrink-0">
                                    <div>
                                        <h4 class="font-bold text-zinc-900">{{ $item->product_name }}</h4>
                                        <p class="text-zinc-500 text-[11px]">Varian: {{ $item->size }} | {{ $item->color }} ({{ $item->quantity }} pcs)</p>
                                    </div>
                                </div>
                                <span class="font-bold text-zinc-900 whitespace-nowrap">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tracking Number alert if shipped -->
                    @if($order->tracking_number)
                        <div class="p-3 rounded-xl bg-purple-50 border border-purple-200 text-xs text-purple-900 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>No. Resi Pengiriman: <strong class="font-mono">{{ $order->tracking_number }}</strong> ({{ $order->shipping_service }})</span>
                            </div>
                        </div>
                    @endif

                    <!-- Card Footer Actions -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-3 border-t border-zinc-100">
                        <div>
                            <span class="text-[11px] text-zinc-400 block">Total Tagihan (termasuk ongkir):</span>
                            <span class="font-display font-extrabold text-base text-zinc-950">
                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2.5">
                            @if($order->status === 'pending')
                                <a href="{{ route('orders.payment', $order->id) }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs transition">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if($order->status === 'shipped')
                                <form action="{{ route('orders.markDelivered', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                        Konfirmasi Terima Pesanan
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 rounded-xl border border-zinc-300 hover:border-zinc-900 text-xs font-semibold text-zinc-800 transition">
                                Detail Pesanan
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="pt-4">
                {{ $orders->links() }}
            </div>
        </div>
    @endif

</div>
@endsection
