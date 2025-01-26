<?php
namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $categories = Category::all();
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products;
        $orders = Order::where('user_id', Auth::id())->get();
        $orderId = $orders->isNotEmpty() ? $orders->first()->id : null;

        return view('categories.show', compact('category', 'categories', 'products', 'orders', 'orderId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('category_images', 'public');
            $validated['image_url'] = $imagePath;
        }

        Category::create($validated);

        return redirect()->route('categories.create')->with('success', 'Category added successfully!');
    }

    public function create()
    {
        $notifications = auth()->user()->notifications;
        return view('seller.partials.categories', compact('notifications'));
    }
}
