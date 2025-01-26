<?php
namespace App\Http\Controllers\Auth;
use App\Models\Product;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;

use App\Models\SellerEarnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $cartItems = Cart::where('user_id', Auth::id())->whereNull('reference')->with('product')->get();

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->quantity * $item->product->price);
        }, 0);
        $categories=Category::all();
        return view('buyer.checkout', compact('cartItems', 'total','categories'));
    }
    
    
    public function placeOrder(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->whereNull('reference')->with('product')->get();
        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->quantity * $item->product->price);
        }, 0);
        $reference = uniqid();
        $user = Auth::user();
        $adminCommission = $total * 0.10;
    $sellersEarnings = $total - $adminCommission ;
        $order = Order::create([
            'user_id' => $user->id,
            'reference' => $reference,
            'order_date' => now(),
            'status' => 'Pending',
            'total' => $total,
            'name' => $user->name,
            'phone_number' => $user->phone_number,
            'address' => $user->address,
            'admin_commission' => $adminCommission,
            'seller_earnings' => $sellersEarnings,
        ]);
    
        $sellerEarnings = [];

        foreach ($cartItems as $item) {
            $product = $item->product;
            $sellerId = $product->seller_id;
            $earnings = $item->quantity * $product->price * 0.90;
    
            if (!isset($sellerEarnings[$sellerId])) {
                $sellerEarnings[$sellerId] = 0;
            }
            $sellerEarnings[$sellerId] += $earnings;
    
            $item->update(['reference' => $reference]);
        }
    
        Cart::where('user_id', Auth::id())->whereNull('reference')->delete();
    
        foreach ($sellerEarnings as $sellerId => $earnings) {
            SellerEarnings::create([
                'order_id' => $order->id,
                'seller_id' => $sellerId,
                'earnings' => $earnings,
            ]);
        }
    
        return redirect()->route('buyer.showOrder', ['userId' => $user->id])->with('success', 'Order placed successfully!');
    }
    public function placeOrderBuyNow($id)
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
    
       
        $orderRequest = new Request();
        return $this->placeOrder($orderRequest);
    }

    
    
}
