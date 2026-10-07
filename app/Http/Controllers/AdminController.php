<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Akses khusus administrator.');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

        $totalGmv = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total_amount');
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProducts = Product::count();

        $recentOrders = Order::with(['user', 'payment'])->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalGmv',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'recentOrders',
            'recentUsers'
        ));
    }

    public function users()
    {
        $this->checkAdmin();
        $users = User::latest()->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        $this->checkAdmin();
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat mengubah status akun Anda sendiri.');
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        return back()->with('success', "Status user {$user->name} berhasil diubah menjadi {$newStatus}.");
    }

    public function categories()
    {
        $this->checkAdmin();
        $categories = Category::withCount('products')->get();

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'icon' => $request->input('icon', 'fa-solid fa-tag'),
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function deleteCategory(Category $category)
    {
        $this->checkAdmin();
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
