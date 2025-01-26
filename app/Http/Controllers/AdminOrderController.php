<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\OrderConfirmation;

use Illuminate\Support\Facades\Log;
use App\Models\SellerEarnings;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth; 

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'carts', 'products')->get();
        $notifications = Auth::user()->unreadNotifications;

        return view('admin.orders.index', compact('orders','notifications'));
    }

    public function manageOrder($orderId)
{
    try {
        // Find the order by ID
        $order = Order::findOrFail($orderId);
        $orderReference = $order->reference;

        if ($order->status === Order::STATUS_PROCESSING) {
            return response()->json(['error' => 'This order is already being processed.'], 400);
        }
        if ($order->status === Order::STATUS_PARTIALLY_PREPARED) {
            return response()->json(['error' => 'This order is already being partially prepared.'], 400);
        }
        if ($order->status === Order::STATUS_FULLY_PREPARED) {
            return response()->json(['error' => 'This order is already being fully prepared.'], 400);
        }
        if ($order->status === Order::STATUS_SHIPPED) {
            return response()->json(['error' => 'This order is already being shipped.'], 400);
        }

        // Retrieve all carts related to the order reference, with the associated product
        $carts = Cart::where('reference', $orderReference)
                    ->with('product')
                    ->get();

        // Group carts by the seller_id of the product
        $sellerCarts = $carts->filter(function($cart) {
            return $cart->product && $cart->product->seller_id; // Ensure product exists and has a seller_id
        })->groupBy('product.seller_id');

        $numberOfSellers = $sellerCarts->count();
        $notifiedSellers = 0;

        foreach ($sellerCarts as $sellerId => $sellerCartItems) {
            $productDetails = [];
            foreach ($sellerCartItems as $cartItem) {
                $productDetails[] = [
                    'product' => $cartItem->product,
                    'quantity' => $cartItem->quantity,
                ];
            }

            if (!empty($productDetails)) {
                $message = "You have products in order {$orderId} that need to be prepared.";
                $orderDetails = [
                    'products' => $productDetails,
                    'admin_commission' => $order->admin_commission,
                    'total_earnings' => $order->sellerEarnings()->where('seller_id', $sellerId)->sum('earnings'),
                ];

                // Find the seller by seller ID
                $seller = User::find($sellerId);
                if ($seller) {
                    $notification = new OrderNotification($message, $orderId, $sellerId, $orderDetails);
                    Notification::send($seller, $notification);
                    OrderConfirmation::updateOrCreate(
                        ['order_id' => $orderId, 'seller_id' => $sellerId],
                        ['confirmed' => false] 
                    );

                    $notifiedSellers++;
                }
            }
        }

        $order->status = Order::STATUS_PROCESSING;
        $order->save();

        return response()->json(['success' => "Notifications sent to {$numberOfSellers} sellers."]);

    } catch (\Exception $e) {
        Log::error('Error managing order: '.$e->getMessage());
        return response()->json(['error' => 'Something went wrong.'], 500);
    }
}

    
    public function showDiscounts()
{
    $totalCommission = Order::sum('admin_commission'); 

    return view('admin.dashboard', compact('totalCommission'));
}
public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
}
}
