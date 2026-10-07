@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Top Back & Title -->
    <div class="flex items-center justify-between border-b border-zinc-200 pb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-1.5 text-xs text-zinc-500 hover:text-zinc-900 mb-2 transition">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Pesanan Saya
            </a>
            <h1 class="font-display text-2xl font-extrabold text-zinc-900">
                Pesanan #{{ $order->order_number }}
            </h1>
            <p class="text-xs text-zinc-500 mt-0.5">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>

        @php $badge = $order->status_badge; @endphp
        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badge['class'] }}">
            {{ $badge['label'] }}
        </span>
    </div>

    <!-- Stepper Tracker -->
    @php
        $statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered'];
        $currentIdx = array_search($order->status, $statuses);
        if ($order->status === 'cancelled') $currentIdx = -1;
    @endphp

    @if($order->status !== 'cancelled')
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm">
            <h3 class="font-display font-bold text-xs uppercase tracking-wider text-zinc-400 mb-6">Status Pengiriman</h3>
            
            <div class="grid grid-cols-5 gap-2 text-center text-xs relative">
                @php
                    $steps = [
                        ['label' => 'Pesanan Dibuat', 'icon' => 'fa-receipt'],
                        ['label' => 'Sudah Dibayar', 'icon' => 'fa-credit-card'],
                        ['label' => 'Diproses Penjual', 'icon' => 'fa-boxes-packing'],
                        ['label' => 'Dalam Pengiriman', 'icon' => 'fa-truck-fast'],
                        ['label' => 'Selesai', 'icon' => 'fa-circle-check'],
                    ];
                @endphp

                @foreach($steps as $idx => $step)
                    @php $isDone = $currentIdx >= $idx; @endphp
                    <div class="flex flex-col items-center space-y-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition 
                                    {{ $isDone ? 'bg-zinc-950 text-amber-300 shadow-md ring-4 ring-amber-100' : 'bg-zinc-100 text-zinc-400' }}">
                            <i class="fa-solid {{ $step['icon'] }}"></i>
                        </div>
                        <span class="text-[11px] font-semibold {{ $isDone ? 'text-zinc-900' : 'text-zinc-400' }}">
                            {{ $step['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        
        <!-- Recipient & Shipping Info -->
        <div class="bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-3">
            <h3 class="font-display font-bold text-sm text-zinc-900 border-b border-zinc-100 pb-2">Informasi Pengiriman</h3>
            <div class="space-y-1.5 text-zinc-600">
                <p><strong class="text-zinc-900">{{ $order->recipient_name }}</strong> ({{ $order->recipient_phone }})</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</p>
            </div>
            <div class="pt-2 border-t border-zinc-100 text-zinc-700">
                <span class="text-zinc-400 block text-[11px]">Kurir & Layanan:</span>
                <span class="font-bold">{{ $order->shipping_service }}</span>
                @if($order->tracking_number)
                    <div class="mt-1 p-2 rounded-lg bg-zinc-100 font-mono text-zinc-800 flex justify-between items-center">
                        <span>No. Resi: <strong>{{ $order->tracking_number }}</strong></span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white p-6 rounded-3xl border border-zinc-200/80 shadow-sm space-y-3">
            <h3 class="font-display font-bold text-sm text-zinc-900 border-b border-zinc-100 pb-2">Rincian Pembayaran</h3>
            <div class="space-y-2 text-zinc-600">
                <div class="flex justify-between">
                    <span>Metode Pembayaran:</span>
                    <span class="font-semibold text-zinc-900 uppercase">{{ str_replace('_', ' ', $order->payment->payment_method ?? 'Bank Transfer') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Status Pembayaran:</span>
                    <span class="font-bold {{ $order->payment && $order->payment->payment_status === 'success' ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ strtoupper($order->payment->payment_status ?? 'PENDING') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span>Subtotal Produk:</span>
                    <span class="font-semibold text-zinc-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkos Kirim:</span>
                    <span class="font-semibold text-zinc-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between pt-2 border-t border-zinc-100 text-sm font-extrabold text-zinc-950">
                    <span>Total Tagihan:</span>
                    <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="pt-3">
                    <a href="{{ route('orders.payment', $order->id) }}" class="w-full block py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-center transition">
                        Lanjut Bayar Sekarang
                    </a>
                </div>
            @endif
        </div>

    </div>

    <!-- Items List with Review Forms -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-zinc-200/80 shadow-sm space-y-6">
        <h3 class="font-display font-bold text-base text-zinc-900 border-b border-zinc-100 pb-3">Daftar Produk yang Dipesan</h3>

        <div class="space-y-6">
            @foreach($order->items as $item)
                <div class="p-4 rounded-2xl bg-zinc-50 border border-zinc-100 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->variant->product->featured_image_url ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=150&q=80' }}" 
                                 alt="{{ $item->product_name }}" 
                                 class="w-16 h-20 rounded-xl object-cover border border-zinc-200 flex-shrink-0">
                            <div>
                                <h4 class="font-bold text-sm text-zinc-900">{{ $item->product_name }}</h4>
                                <p class="text-xs text-zinc-500">Penjual: {{ $item->seller->name ?? 'Merchant' }}</p>
                                <span class="inline-block mt-1 text-[11px] bg-white px-2 py-0.5 rounded border border-zinc-200 text-zinc-700">
                                    {{ $item->size }} | {{ $item->color }} ({{ $item->quantity }}x)
                                </span>
                            </div>
                        </div>
                        <span class="font-display font-bold text-sm text-zinc-900 whitespace-nowrap">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Review Section for this Item -->
                    @if($order->status === 'delivered')
                        <div class="pt-3 border-t border-zinc-200">
                            @if($item->review)
                                <div class="bg-white p-3.5 rounded-xl border border-emerald-200 space-y-1 text-xs">
                                    <div class="flex items-center justify-between text-emerald-800 font-bold">
                                        <span><i class="fa-solid fa-circle-check text-emerald-600"></i> Ulasan Anda Telah Tersimpan</span>
                                        <div class="flex text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $item->review->rating ? 'text-amber-400' : 'text-zinc-200' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-zinc-600 italic">"{{ $item->review->comment }}"</p>
                                </div>
                            @else
                                <form action="{{ route('orders.review', $item->id) }}" method="POST" class="bg-white p-4 rounded-xl border border-zinc-200 space-y-3">
                                    @csrf
                                    <div class="flex items-center justify-between">
                                        <h5 class="font-bold text-xs text-zinc-900">Beri Ulasan untuk Produk Ini:</h5>
                                        <div class="flex items-center gap-2">
                                            <label class="text-[11px] text-zinc-500 font-medium">Rating:</label>
                                            <select name="rating" required class="text-xs bg-zinc-50 border border-zinc-200 rounded-lg px-2 py-1 font-bold text-amber-600">
                                                <option value="5">★★★★★ (5 Bintang)</option>
                                                <option value="4">★★★★☆ (4 Bintang)</option>
                                                <option value="3">★★★☆☆ (3 Bintang)</option>
                                                <option value="2">★★☆☆☆ (2 Bintang)</option>
                                                <option value="1">★☆☆☆☆ (1 Bintang)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <textarea name="comment" rows="2" placeholder="Bagikan kepuasan bahan, ukuran, dan kualitas jahitan busana ini..." 
                                              class="w-full text-xs p-2.5 bg-zinc-50 border border-zinc-200 rounded-lg focus:bg-white focus:outline-none focus:ring-1 focus:ring-brand-500"></textarea>

                                    <div class="text-right">
                                        <button type="submit" class="px-4 py-2 rounded-xl bg-zinc-950 hover:bg-brand-600 text-white font-bold text-xs transition">
                                            Kirim Ulasan & Rating
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>

</div>
@endsection
