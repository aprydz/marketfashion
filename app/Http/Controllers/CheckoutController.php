<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with(['items.variant.product.images', 'items.variant.product.seller'])
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang belanja Anda masih kosong.');
        }

        // Courier options
        $couriers = [
            ['code' => 'JNE-REG', 'name' => 'JNE Reguler (2-3 Hari)', 'cost' => 18000],
            ['code' => 'SICEPAT-BEST', 'name' => 'SiCepat BEST (1-2 Hari)', 'cost' => 24000],
            ['code' => 'JNT-EZ', 'name' => 'J&T Express EZ (2-3 Hari)', 'cost' => 19000],
        ];

        return view('marketplace.checkout', compact('cart', 'user', 'couriers'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:100',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_service' => 'required|string',
            'payment_method' => 'required|in:bank_transfer,ewallet,cod',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.variant.product')->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang belanja kosong.');
        }

        // Calculate shipping cost
        $shippingCosts = [
            'JNE Reguler (2-3 Hari)' => 18000,
            'SiCepat BEST (1-2 Hari)' => 24000,
            'J&T Express EZ (2-3 Hari)' => 19000,
        ];
        $shippingService = $request->input('shipping_service');
        $shippingCost = $shippingCosts[$shippingService] ?? 20000;

        $totalAmount = $cart->total_amount;

        $order = DB::transaction(function () use ($request, $user, $cart, $totalAmount, $shippingCost, $shippingService) {
            $orderNumber = 'FM-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'shipping_service' => $shippingService,
                'recipient_name' => $request->input('recipient_name'),
                'recipient_phone' => $request->input('recipient_phone'),
                'shipping_address' => $request->input('shipping_address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'postal_code' => $request->input('postal_code'),
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $variant = $item->variant;
                $product = $variant->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $variant->id,
                    'seller_id' => $product->user_id,
                    'product_name' => $product->name,
                    'size' => $variant->size,
                    'color' => $variant->color,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $product->price * $item->quantity,
                ]);

                // Reduce stock safely
                $variant->decrement('stock', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->input('payment_method'),
                'payment_status' => 'pending',
                'amount' => $order->grand_total,
            ]);

            // Clear cart
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.payment', $order->id)->with('success', 'Pesanan #' . $order->order_number . ' berhasil dibuat!');
    }

    public function showPayment(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load(['items', 'payment']);

        return view('marketplace.payment', compact('order'));
    }

    public function confirmPayment(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->update(['status' => 'paid']);
            $order->payment->update([
                'payment_status' => 'success',
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan akan segera diproses oleh penjual.');
    }
}
