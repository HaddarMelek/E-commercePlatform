<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

use Illuminate\Support\Facades\Auth;
class BuyerController extends Controller
{
   
   
    public function index()
    {
        $categories = Category::with('products')->get();
        Order::where('status', 'canceled')->delete();

        $products = Product::all();
      

    return view('buyer.index', compact('products', 'categories'));

    }
    public function dashboard()
    {
        return view('buyer.dashboard');
    }

    public function profile()
    {
        return view('user.profile');
    }

   

    public function cart()
    {
        return view('buyer.partials.cart');
    }

    

    
    public function orders()
    {
        $categories = Category::all();

        $orders = Order::where('user_id', Auth::id())->get();
        return view('order.show', compact('orders','categories'));
    }
}

