<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product; 
use App\Models\Cart; 
use App\Models\Category; 

use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You need to be logged in to add items to the cart.']);
        }
    
        $user = Auth::user();
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found.']);
        }
    
        if ($product->qte_stock <= 0) {
            return response()->json(['error' => 'This product is out of stock.']);
        }
    
        $cart = Cart::where('user_id', $user->id)
                    ->where('reference', null)
                    ->where('product_id', $id)
                    ->first();
    
        if ($cart) {
            if ($cart->quantity >= $product->qte_stock) {
                return response()->json(['error' => 'Cannot add more of this product to the cart. Stock limit reached.']);
            }
            $cart->quantity += 1;
            $cart->save();
        } else {
            if (1 > $product->qte_stock) {
                return response()->json(['error' => 'Cannot add this product to the cart. Stock limit reached.']);
            }
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'quantity' => 1,
                'reference' => null
            ]);
        }
    
        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }
    
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view the cart.');
        }

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
                         ->where('reference', null)
                         ->get();

        $categories = Category::all();


        return view('cart.view', compact('cartItems' , 'categories'));
    }

  
    public function removeFromCart($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to remove items from the cart.');
        }

    
        // Hardcoded values for testing
        $testCart = Cart::find($id);
    
        if ($testCart) {
            $testCart->delete();
            return back()->with('success', 'Product removed from cart!');
        }
    
        \Log::info("Cart Item Not Found: ", ['product_id' => 3]);
        return back()->with('error', 'Product not found in the cart.');
    }
    
}
