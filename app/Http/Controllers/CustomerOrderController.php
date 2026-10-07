<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Order::where('user_id', Auth::id())
            ->with(['items.variant.product.images', 'payment'])
            ->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('customer.orders', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load(['items.variant.product.images', 'items.review', 'items.seller', 'payment']);

        return view('customer.order-detail', compact('order'));
    }

    public function markDelivered(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'shipped') {
            $order->update(['status' => 'delivered']);
            return back()->with('success', 'Terima kasih telah mengonfirmasi penerimaan pesanan!');
        }

        return back()->with('info', 'Status pesanan belum dapat diselesaikan.');
    }

    public function storeReview(Request $request, OrderItem $orderItem)
    {
        if ($orderItem->order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($orderItem->order->status !== 'delivered') {
            return back()->with('error', 'Review hanya dapat diberikan untuk pesanan yang sudah diterima.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $productId = $orderItem->variant ? $orderItem->variant->product_id : null;
        if (!$productId) {
            // Find product by seller and product name if variant deleted
            $fallback = \App\Models\Product::where('name', $orderItem->product_name)->first();
            $productId = $fallback ? $fallback->id : 1;
        }

        Review::updateOrCreate(
            ['order_item_id' => $orderItem->id],
            [
                'product_id' => $productId,
                'user_id' => Auth::id(),
                'rating' => (int) $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        return back()->with('success', 'Ulasan dan rating Anda berhasil disimpan!');
    }
}
