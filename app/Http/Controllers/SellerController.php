<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    private function checkSeller()
    {
        if (!Auth::check() || (!Auth::user()->isSeller() && !Auth::user()->isAdmin())) {
            abort(403, 'Akses khusus penjual.');
        }
    }

    public function dashboard()
    {
        $this->checkSeller();
        $sellerId = Auth::id();

        $totalRevenue = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
            })
            ->sum('subtotal');

        $totalProducts = Product::where('user_id', $sellerId)->count();

        $pendingOrdersCount = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($q) {
                $q->whereIn('status', ['paid', 'processing']);
            })
            ->distinct('order_id')
            ->count('order_id');

        $recentItems = OrderItem::where('seller_id', $sellerId)
            ->with(['order.user', 'variant.product'])
            ->latest()
            ->take(6)
            ->get();

        return view('seller.dashboard', compact(
            'totalRevenue',
            'totalProducts',
            'pendingOrdersCount',
            'recentItems'
        ));
    }

    public function products()
    {
        $this->checkSeller();
        $sellerId = Auth::id();

        $products = Product::where('user_id', $sellerId)
            ->with(['category', 'variants', 'images'])
            ->withCount('reviews')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        $this->checkSeller();
        $categories = Category::all();

        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $this->checkSeller();
        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000',
            'description' => 'required|string',
            'image_url' => 'required|url',
            'additional_images' => 'nullable|string',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string|max:20',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.stock' => 'required|integer|min:0',
        ]);

        $slug = Str::slug($request->input('name')) . '-' . Str::random(5);

        DB::transaction(function () use ($request, $slug) {
            $product = Product::create([
                'user_id' => Auth::id(),
                'category_id' => $request->input('category_id'),
                'name' => $request->input('name'),
                'slug' => $slug,
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'is_active' => true,
            ]);

            // Primary Image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $request->input('image_url'),
                'is_primary' => true,
            ]);

            // Additional Images (comma or newline separated)
            if ($additional = $request->input('additional_images')) {
                $urls = preg_split('/[\r\n,]+/', $additional);
                foreach ($urls as $url) {
                    $url = trim($url);
                    if ($url && filter_var($url, FILTER_VALIDATE_URL)) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'image_path' => $url,
                            'is_primary' => false,
                        ]);
                    }
                }
            }

            // Variants
            foreach ($request->input('variants') as $v) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $v['size'],
                    'color' => $v['color'],
                    'stock' => (int) $v['stock'],
                ]);
            }
        });

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan ke etalase toko!');
    }

    public function editProduct(Product $product)
    {
        $this->checkSeller();
        if ($product->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        $product->load(['variants', 'images']);

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->checkSeller();
        if ($product->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1000',
            'description' => 'required|string',
            'image_url' => 'required|url',
            'is_active' => 'boolean',
        ]);

        $product->update([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'is_active' => $request->boolean('is_active'),
        ]);

        // Update primary image
        $primary = $product->images()->where('is_primary', true)->first();
        if ($primary) {
            $primary->update(['image_path' => $request->input('image_url')]);
        } else {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $request->input('image_url'),
                'is_primary' => true,
            ]);
        }

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function deleteProduct(Product $product)
    {
        $this->checkSeller();
        if ($product->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk telah dihapus.');
    }

    public function orders(Request $request)
    {
        $this->checkSeller();
        $sellerId = Auth::id();
        $status = $request->input('status');

        $query = Order::whereHas('items', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })->with(['items' => function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        }, 'user', 'payment'])->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('orders', 'status'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $this->checkSeller();
        $sellerId = Auth::id();

        // Verify seller has items in this order
        $hasItem = $order->items()->where('seller_id', $sellerId)->exists();
        if (!$hasItem && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $newStatus = $request->input('status');
        if (in_array($newStatus, ['processing', 'shipped', 'delivered', 'cancelled'])) {
            $updateData = ['status' => $newStatus];
            if ($newStatus === 'shipped' && $request->filled('tracking_number')) {
                $updateData['tracking_number'] = $request->input('tracking_number');
            }
            $order->update($updateData);

            return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . ucfirst($newStatus) . '.');
        }

        return back()->with('error', 'Status tidak valid.');
    }
}
