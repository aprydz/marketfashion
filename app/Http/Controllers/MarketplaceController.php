<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        
        $featuredProducts = Product::where('is_active', true)
            ->with(['category', 'images', 'reviews', 'variants'])
            ->latest()
            ->take(8)
            ->get();

        $trendingProducts = Product::where('is_active', true)
            ->with(['category', 'images', 'reviews', 'variants'])
            ->withCount('reviews')
            ->orderByDesc('reviews_count')
            ->take(4)
            ->get();

        return view('marketplace.home', compact('categories', 'featuredProducts', 'trendingProducts'));
    }

    public function catalog(Request $request)
    {
        $categories = Category::all();

        $query = Product::where('is_active', true)
            ->with(['category', 'images', 'reviews', 'variants']);

        // Search
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categorySlug = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Price range
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'rating' => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('marketplace.catalog', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'category',
                'images',
                'variants',
                'seller',
                'reviews.user',
                'reviews.orderItem'
            ])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['images', 'category', 'reviews'])
            ->take(4)
            ->get();

        return view('marketplace.detail', compact('product', 'relatedProducts'));
    }
}
