<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getUserCart()
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function index()
    {
        $cart = $this->getUserCart();
        $cart->load(['items.variant.product.images', 'items.variant.product.seller']);

        return view('marketplace.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($request->input('variant_id'));
        $quantity = (int) $request->input('quantity', 1);

        if ($variant->stock < $quantity) {
            return back()->with('error', 'Maaf, stok yang tersedia tersisa ' . $variant->stock . ' item.');
        }

        $cart = $this->getUserCart();

        $item = CartItem::firstOrNew([
            'cart_id' => $cart->id,
            'product_variant_id' => $variant->id,
        ]);

        if ($item->exists) {
            $newQuantity = $item->quantity + $quantity;
            if ($newQuantity > $variant->stock) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $item->quantity = $newQuantity;
        } else {
            $item->quantity = $quantity;
        }

        $item->save();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang belanja!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $action = $request->input('action');
        if ($action === 'increase') {
            if ($cartItem->quantity < $cartItem->variant->stock) {
                $cartItem->increment('quantity');
            }
        } elseif ($action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
            }
        }

        return back()->with('success', 'Keranjang belanja berhasil diperbarui.');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
