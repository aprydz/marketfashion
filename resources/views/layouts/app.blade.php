<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FashionMarket') | Destinasi Belanja Fashion Eksklusif</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fbf8f5',
                            100: '#f5efe8',
                            200: '#ebdfd2',
                            300: '#dac4af',
                            400: '#c5a388',
                            500: '#b48869',
                            600: '#a37456',
                            700: '#875d45',
                            800: '#6f4d3c',
                            900: '#5b4034',
                            950: '#1a1816',
                        },
                        dark: {
                            900: '#0f1115',
                            800: '#161920',
                            700: '#212631',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f6;
            color: #1f2937;
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .luxury-gradient {
            background: linear-gradient(135deg, #18181b 0%, #27272a 50%, #09090b 100%);
        }
        .gold-gradient {
            background: linear-gradient(135deg, #d4af37 0%, #f3e5ab 50%, #aa7c11 100%);
        }
        .badge-pulse {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-brand-500 selection:text-white">

    <!-- Top Demo Quick Switcher Bar -->
    <aside aria-label="Demo Bar" class="bg-dark-900 text-xs text-zinc-300 py-1.5 px-4 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400 font-semibold border border-amber-500/30">
                    <i class="fa-solid fa-bolt text-[10px]"></i> DEMO MODE
                </span>
                <span class="hidden sm:inline text-zinc-400">Pilih peran akun untuk uji coba instan:</span>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('quick.login') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="role" value="customer">
                    <button type="submit" class="px-2.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-200 transition font-medium {{ Auth::check() && Auth::user()->isCustomer() ? 'ring-1 ring-amber-400 text-amber-300' : '' }}">
                        <i class="fa-solid fa-user text-[10px] mr-1"></i> Customer (Rian)
                    </button>
                </form>
                <form action="{{ route('quick.login') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="role" value="seller">
                    <button type="submit" class="px-2.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-200 transition font-medium {{ Auth::check() && Auth::user()->isSeller() ? 'ring-1 ring-emerald-400 text-emerald-300' : '' }}">
                        <i class="fa-solid fa-store text-[10px] mr-1"></i> Seller (Batik Queen)
                    </button>
                </form>
                <form action="{{ route('quick.login') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <button type="submit" class="px-2.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-200 transition font-medium {{ Auth::check() && Auth::user()->isAdmin() ? 'ring-1 ring-purple-400 text-purple-300' : '' }}">
                        <i class="fa-solid fa-shield-halved text-[10px] mr-1"></i> Admin Panel
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 glass-nav border-b border-zinc-200/80 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Brand Logo -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-zinc-950 text-white flex items-center justify-center font-display font-extrabold text-xl shadow-md group-hover:scale-105 transition-transform duration-300">
                            F
                        </div>
                        <div>
                            <span class="font-display font-bold text-xl tracking-tight text-zinc-900 group-hover:text-brand-600 transition">Fashion<span class="text-brand-600">Market</span></span>
                            <span class="block text-[10px] tracking-widest uppercase text-zinc-400 font-semibold -mt-1">Curated Luxury</span>
                        </div>
                    </a>

                    <!-- Main Navigation Links -->
                    <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-zinc-700">
                        <a href="{{ route('home') }}" class="hover:text-brand-600 transition {{ request()->routeIs('home') ? 'text-brand-600 font-semibold' : '' }}">Beranda</a>
                        <a href="{{ route('catalog') }}" class="hover:text-brand-600 transition {{ request()->routeIs('catalog') ? 'text-brand-600 font-semibold' : '' }}">Katalog Fashion</a>
                        <a href="{{ route('catalog', ['category' => 'pria']) }}" class="hover:text-brand-600 transition">Pria</a>
                        <a href="{{ route('catalog', ['category' => 'wanita']) }}" class="hover:text-brand-600 transition">Wanita</a>
                        <a href="{{ route('catalog', ['category' => 'streetwear']) }}" class="hover:text-brand-600 transition">Streetwear</a>
                    </nav>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-md hidden md:block">
                    <form action="{{ route('catalog') }}" method="GET" class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kemeja batik, sneakers, dress, tas..." 
                            class="w-full bg-zinc-100/80 hover:bg-zinc-100 focus:bg-white text-zinc-800 text-sm pl-11 pr-4 py-2.5 rounded-full border border-zinc-200/80 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 transition">
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-700 transition">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Wishlist, Cart & Profile -->
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $cartCount = Auth::user()->cart ? Auth::user()->cart->items()->sum('quantity') : 0;
                            $wishlistCount = Auth::user()->wishlist ? Auth::user()->wishlist->items()->count() : 0;
                        @endphp
                        
                        <!-- Wishlist Icon -->
                        <a href="{{ route('wishlist.index') }}" class="relative p-2.5 rounded-full text-zinc-700 hover:text-brand-600 hover:bg-zinc-100 transition" title="Wishlist">
                            <i class="fa-regular fa-heart text-lg"></i>
                            @if($wishlistCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Cart Icon -->
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-full text-zinc-700 hover:text-brand-600 hover:bg-zinc-100 transition" title="Keranjang Belanja">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                            @if($cartCount > 0)
                                <span class="absolute top-1 right-1 w-5 h-5 bg-zinc-900 text-amber-300 text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Menu Dropdown -->
                        <div class="relative group" id="userMenuDropdown">
                            <button class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-full border border-zinc-200 hover:border-zinc-300 bg-white transition">
                                <img src="{{ Auth::user()->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&q=80' }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-7 h-7 rounded-full object-cover">
                                <span class="text-xs font-semibold text-zinc-800 hidden sm:inline max-w-[100px] truncate">
                                    {{ Auth::user()->name }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-zinc-400 group-hover:rotate-180 transition-transform duration-200"></i>
                            </button>

                            <!-- Dropdown Box -->
                            <div class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-zinc-100 py-2 hidden group-hover:block transition-all z-50">
                                <div class="px-4 py-2.5 border-b border-zinc-100">
                                    <p class="text-xs font-semibold text-zinc-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-zinc-500 truncate">{{ Auth::user()->email }}</p>
                                    <span class="mt-1.5 inline-block text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider
                                        {{ Auth::user()->isAdmin() ? 'bg-purple-100 text-purple-700' : (Auth::user()->isSeller() ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>

                                <div class="py-1">
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-purple-600 transition">
                                            <i class="fa-solid fa-chart-line w-4 text-purple-500"></i> Admin Dashboard
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-purple-600 transition">
                                            <i class="fa-solid fa-users w-4 text-purple-500"></i> Kelola User
                                        </a>
                                    @endif

                                    @if(Auth::user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-emerald-600 transition">
                                            <i class="fa-solid fa-store w-4 text-emerald-500"></i> Seller Hub Dashboard
                                        </a>
                                        <a href="{{ route('seller.products.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-emerald-600 transition">
                                            <i class="fa-solid fa-boxes-stacked w-4 text-emerald-500"></i> Kelola Produk Saya
                                        </a>
                                        <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-emerald-600 transition">
                                            <i class="fa-solid fa-receipt w-4 text-emerald-500"></i> Pesanan Masuk
                                        </a>
                                    @endif

                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-brand-600 transition">
                                        <i class="fa-solid fa-clock-rotate-left w-4 text-zinc-400"></i> Pesanan Saya
                                    </a>
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-zinc-700 hover:bg-zinc-50 hover:text-brand-600 transition">
                                        <i class="fa-regular fa-heart w-4 text-zinc-400"></i> Wishlist Saya
                                    </a>
                                </div>

                                <div class="border-t border-zinc-100 pt-1">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 transition">
                                            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Keluar (Logout)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Auth Links -->
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-zinc-700 hover:text-brand-600 px-3 py-2 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-semibold px-4 py-2 rounded-full bg-zinc-950 text-white hover:bg-zinc-800 transition shadow-sm">
                            Daftar Sekarang
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Flash Alerts Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center justify-between p-4 mb-3 text-sm text-emerald-800 bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center justify-between p-4 mb-3 text-sm text-rose-800 bg-rose-50 rounded-2xl border border-rose-200 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div class="flex items-center justify-between p-4 mb-3 text-sm text-amber-800 bg-amber-50 rounded-2xl border border-amber-200 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg"></i>
                    <span class="font-medium">{{ session('warning') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center justify-between p-4 mb-3 text-sm text-blue-800 bg-blue-50 rounded-2xl border border-blue-200 shadow-sm" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
                    <span class="font-medium">{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Yield -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 text-zinc-400 text-sm border-t border-zinc-800 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-white text-zinc-950 flex items-center justify-center font-display font-extrabold text-lg">
                            F
                        </div>
                        <span class="font-display font-bold text-xl text-white">Fashion<span class="text-brand-400">Market</span></span>
                    </div>
                    <p class="text-zinc-400 text-xs leading-relaxed max-w-sm">
                        Platform e-commerce fashion kurasi nomor satu di Indonesia. Menghadirkan karya desainer lokal, batik kontemporer, dan tren streetwear global dengan jaminan orisinalitas 100%.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-tiktok text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-zinc-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-youtube text-xs"></i></a>
                    </div>
                </div>

                <!-- Belanja -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm uppercase tracking-wider mb-4">Kategori Populer</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('catalog', ['category' => 'pria']) }}" class="hover:text-white transition">Koleksi Pria</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'wanita']) }}" class="hover:text-white transition">Koleksi Wanita</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'hijab-muslim']) }}" class="hover:text-white transition">Hijab & Modest Wear</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'streetwear']) }}" class="hover:text-white transition">Urban Streetwear</a></li>
                        <li><a href="{{ route('catalog', ['category' => 'sepatu-sneakers']) }}" class="hover:text-white transition">Sneakers & Alas Kaki</a></li>
                    </ul>
                </div>

                <!-- Bantuan & Layanan -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm uppercase tracking-wider mb-4">Layanan Pembeli</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#" class="hover:text-white transition">Panduan Ukuran (Size Guide)</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Pengembalian</a></li>
                        <li><a href="#" class="hover:text-white transition">Konfirmasi Pembayaran</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ & Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">Lacak Pengiriman Resi</a></li>
                    </ul>
                </div>

                <!-- Seller Hub & Keamanan -->
                <div>
                    <h4 class="font-display font-semibold text-white text-sm uppercase tracking-wider mb-4">Mitra & Penjual</h4>
                    <ul class="space-y-2.5 text-xs mb-6">
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Buka Toko Gratis</a></li>
                        <li><a href="{{ route('seller.dashboard') }}" class="hover:text-white transition">Portal Seller Hub</a></li>
                        <li><a href="#" class="hover:text-white transition">Komunitas Desainer</a></li>
                    </ul>
                    <div class="pt-2">
                        <span class="text-[11px] font-semibold text-zinc-300 block mb-2">Metode Pembayaran Aman:</span>
                        <div class="flex flex-wrap gap-2 text-lg text-zinc-400">
                            <i class="fa-solid fa-building-columns" title="Transfer Bank"></i>
                            <i class="fa-solid fa-qrcode" title="QRIS"></i>
                            <i class="fa-solid fa-money-bill-wave" title="COD"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-14 pt-8 border-t border-zinc-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500">
                <p>&copy; {{ date('Y') }} FashionMarket Indonesia. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-zinc-400 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-zinc-400 transition">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-zinc-400 transition">Keamanan Bertransaksi</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
