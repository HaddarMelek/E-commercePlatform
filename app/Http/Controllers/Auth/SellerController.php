<?php 
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\OrderConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 

        $products = Product::where('seller_id', $userId)->get();

        $categories = Category::all();
        $seller = Auth::user();
        $notifications = $seller->notifications; 

        return view('seller.dashboard', compact('products', 'categories','notifications'));
    }

   
    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->route('seller.dashboard')->with('success', 'Category added successfully');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->route('seller.dashboard')->with('success', 'Category updated successfully');
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Category deleted successfully');
    }
   
   

public function viewOrderProducts($orderId)
{
    $order = Order::findOrFail($orderId);
    $orderReference = $order->reference;
    $carts = Cart::where('reference', $orderReference)
                ->with('product') 
                ->get();

    $sellerCarts = $carts->groupBy('product.seller_id');
    $orderDetails = [];
    $authenticatedSellerId = auth()->user()->id;
    foreach ($sellerCarts as $sellerId => $sellerCartItems) {
        if ($sellerId == $authenticatedSellerId) {
            $productDetails = [];
            foreach ($sellerCartItems as $cartItem) {
                if ($cartItem->product->seller_id == $sellerId) {
                    $productDetails[] = [
                        'products' => $cartItem->product,
                        'quantity' => $cartItem->quantity,
                    ];
                }
            }

            if (!empty($productDetails)) {
                $orderDetails[$sellerId] = [
                    'products' => $productDetails,
                    'admin_commission' => $order->admin_commission,
                    'total_earnings' => $order->sellerEarnings()->where('seller_id', $sellerId)->sum('earnings'),
                ];
            }
        }
    }

    $notifications = auth()->user()->notifications;

    return view('seller.order-products', compact('orderDetails', 'notifications', 'orderId'));
}


    public function showOrders()
    {
        $orders = Order::whereHas('products', function ($query) {
            $query->where('seller_id', Auth::id());
        })->get();
    
        $products = Product::where('seller_id', Auth::id())->get();

        return view('seller.dashboard', compact('orders', 'products'));    }


        public function confirmOrder($orderId)
        {
            $order = Order::with('products')->findOrFail($orderId);
        
            $sellerId = auth()->id(); // Get the authenticated seller's ID
            $seller = User::findOrFail($sellerId);
            $sellerName = $seller->name;

            $existingConfirmation = OrderConfirmation::where('order_id', $orderId)
                                             ->where('seller_id', $sellerId)
                                             ->where('confirmed', true)
                                             ->first();
    
    if ($existingConfirmation) {
        return response()->json(['error' => 'You have already confirmed the preparation for this order.'], 400);
    }
            // Record or update the seller's confirmation status
            OrderConfirmation::updateOrCreate(
                ['order_id' => $orderId, 'seller_id' => $sellerId],
                ['confirmed' => true]
            );
        
            // Notify the admin about the confirmation request
            $message = "{$sellerName} with ID {$sellerId} has confirmed their part for order {$orderId}.";
            $adminEmail = 'admin@example.com'; 
            $admin = User::where('email', $adminEmail)->first(); 
        
            
        
            DB::beginTransaction();
            try {
                foreach ($order->products as $product) {
                    if ($product->seller_id == $sellerId) {
                        $requiredQuantity = $product->pivot->quantity;
                        $currentStock = $product->qte_stock;
        
                        if ($currentStock >= $requiredQuantity) {
                            $product->qte_stock -= $requiredQuantity;
                            $product->save();
                        } else {
                            DB::rollBack();
                            return response()->json(['error' => 'Not enough stock for product: ' . $product->name], 400);
                        }
                    }
                }
                $totalSellers = OrderConfirmation::where('order_id', $orderId)->count();
        $confirmedSellers = OrderConfirmation::where('order_id', $orderId)->where('confirmed', true)->count();
        
        if ($totalSellers === $confirmedSellers) {
            // Update order status to fully prepared if all sellers have confirmed
            $order->status = Order::STATUS_FULLY_PREPARED;
        } elseif ($confirmedSellers > 0) {
            // Update status to partially prepared if some sellers have confirmed
            $order->status = Order::STATUS_PARTIALLY_PREPARED;
        }
        $order->save();
                
        
                DB::commit();
                if ($admin) {
                    $notification = new AdminNotification($message, $orderId, $sellerId);
                    Notification::send($admin, $notification);
                    Log::info('Notification sent to admin:', $notification->toArray($admin));
                }
                return response()->json(['success' => 'Order has been confirmed and stock has been updated.']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error confirming order: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to confirm the order. Please try again later.'], 500);
            }
        }
        
        
}




