@extends('layouts.app')

@section('title', 'Kelola Pesanan Masuk Penjual')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-200 pb-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-zinc-500 mb-1">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-zinc-900">Seller Hub</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-zinc-900 font-semibold">Pesanan Masuk</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-zinc-900">
                Kelola Pesanan Masuk
            </h1>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs">
        @php
            $currentStatus = request('status', 'all');
            $tabs = [
                'all' => 'Semua',
                'paid' => 'Perlu Diproses',
                'processing' => 'Sedang Dipacking',
                'shipped' => 'Dalam Pengiriman',
                'delivered' => 'Pesanan Selesai',
            ];
        @endphp

        @foreach($tabs as $key => $label)
            <a href="{{ route('seller.orders.index', ['status' => $key]) }}" 
               class="px-4 py-2 rounded-full font-semibold transition whitespace-nowrap 
               {{ $currentStatus === $key ? 'bg-zinc-950 text-white shadow-sm' : 'bg-white border border-zinc-200 text-zinc-600 hover:border-zinc-400' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-16 border border-zinc-200 text-center space-y-4 max-w-md mx-auto">
            <div class="w-16 h-16 rounded-full bg-zinc-100 text-zinc-400 mx-auto flex items-center justify-center text-2xl">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 class="font-display font-bold text-lg text-zinc-900">Tidak Ada Pesanan Masuk</h3>
            <p class="text-xs text-zinc-500">Belum ada pesanan dengan status yang dipilih.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                @php $badge = $order->status_badge; @endphp
                <div class="bg-white rounded-3xl border border-zinc-200/80 p-6 shadow-sm space-y-6">
                    
                    <!-- Top Info -->
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-zinc-100 pb-4 text-xs">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold text-base text-zinc-900">{{ $order->order_number }}</span>
                            <span class="text-zinc-400">•</span>
                            <span class="text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <span class="px-3.5 py-1 rounded-full text-xs font-bold border {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <!-- Grid Content: Items & Shipping Destination -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 text-xs">
                        
                        <!-- Items Belonging to Seller -->
                        <div class="lg:col-span-7 space-y-3">
                            <span class="font-bold text-zinc-500 uppercase tracking-wider block">Produk Pesanan Toko Anda:</span>
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between p-3 rounded-2xl bg-zinc-50 border border-zinc-100">
                                    <div class="space-y-0.5">
                                        <h4 class="font-bold text-zinc-900 text-xs">{{ $item->product_name }}</h4>
                                        <span class="text-[11px] text-zinc-500">Ukuran: {{ $item->size }} | Warna: {{ $item->color }} | Qty: {{ $item->quantity }} pcs</span>
                                    </div>
                                    <span class="font-bold text-zinc-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Recipient Address & Shipping Service -->
                        <div class="lg:col-span-5 p-4 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-2">
                            <span class="font-bold text-zinc-500 uppercase tracking-wider block">Tujuan Pengiriman:</span>
                            <p class="font-bold text-zinc-900">{{ $order->recipient_name }} ({{ $order->recipient_phone }})</p>
                            <p class="text-zinc-600 leading-relaxed">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
                            <div class="pt-2 border-t border-zinc-200 flex items-center justify-between">
                                <span class="text-zinc-500">Kurir:</span>
                                <span class="font-semibold text-zinc-900">{{ $order->shipping_service }}</span>
                            </div>
                        </div>

                    </div>

                    <!-- Action Controls for Seller -->
                    <div class="pt-4 border-t border-zinc-100 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            @if($order->tracking_number)
                                <div class="text-xs text-purple-700 bg-purple-50 px-3 py-1.5 rounded-xl border border-purple-200 flex items-center gap-2">
                                    <i class="fa-solid fa-truck-fast"></i>
                                    <span>Resi Terdaftar: <strong class="font-mono font-bold">{{ $order->tracking_number }}</strong></span>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Process order if paid -->
                            @if($order->status === 'paid')
                                <form action="{{ route('seller.orders.status', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition flex items-center gap-2 shadow-sm">
                                        <i class="fa-solid fa-box-archive"></i>
                                        <span>Terima & Mulai Kemas Pesanan</span>
                                    </button>
                                </form>
                            @endif

                            <!-- Input resi and ship if processing -->
                            @if($order->status === 'processing')
                                <form action="{{ route('seller.orders.status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="status" value="shipped">
                                    <input type="text" name="tracking_number" placeholder="Input No. Resi (cth: JNE8829...)" required
                                           class="text-xs px-3 py-2 bg-zinc-50 border border-zinc-300 rounded-xl focus:bg-white focus:outline-none focus:ring-1 focus:ring-zinc-900">
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs transition flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        <span>Kirimkan Pesanan</span>
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'shipped')
                                <span class="text-xs text-zinc-400 italic">Menunggu konfirmasi paket tiba oleh pembeli</span>
                            @endif
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
