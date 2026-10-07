<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    private function getUserWishlist()
    {
        return Wishlist::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function index()
    {
        $wishlist = $this->getUserWishlist();
        $wishlist->load(['items.product.images', 'items.product.category', 'items.product.reviews']);

        return view('marketplace.wishlist', compact('wishlist'));
    }

    public function toggle(Product $product)
    {
        $wishlist = $this->getUserWishlist();

        $existing = WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('info', 'Produk dihapus dari wishlist.');
        }

        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Produk ditambahkan ke wishlist!');
    }
}
