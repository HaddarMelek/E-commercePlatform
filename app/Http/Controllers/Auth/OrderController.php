<?php
namespace App\Http\Controllers\Auth;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;

use App\Models\Order;
use App\Models\Cart;



class OrderController extends Controller
{
   
public function index()
    {
        $orders = Order::where('seller_id', auth()->id())->get(); 
        return view('seller.partials.orders', compact('orders'));
    }

   
    
    public function cancel($id)
{
    $order = Order::findOrFail($id);

    if ($order->status == 'Pending') {
        $order->status = 'Canceled';
        $order->save();

        return redirect()->back()->with('success', 'Order has been canceled.');
    }

    return redirect()->back()->with('error', 'Order cannot be canceled.');
}
public function showOrder($userId)
    {
        $orders = Order::where('user_id', $userId)
            ->with('carts.product')
            ->get();
        
        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No orders found for this user.');
        }
        $categories = Category::all();

        return view('order.show', compact('orders','categories'));
    }
    public function updateDetails(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:15',
        'address' => 'required|string|max:255',
    ]);

    $order = Order::findOrFail($id);
    $order->update([
        'name' => $request->name,
        'phone_number' => $request->phone_number,
        'address' => $request->address,
    ]);

    return redirect()->back()->with('success', 'Order details updated successfully.');
}

public function changeStatus($id, Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'status' => 'required|string|in:' . implode(',', [
            Order::STATUS_PENDING,
            Order::STATUS_PROCESSING,
            Order::STATUS_PARTIALLY_PREPARED,
            Order::STATUS_FULLY_PREPARED,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED,
            Order::STATUS_CANCELED
        ]),
    ]);

    
    // Find and update the order
    $order = Order::findOrFail($id);
    $status = $validatedData['status'];

    // Determine the order's preparation status
    $preparationStatus = $order->checkPreparationStatus();

    if ($preparationStatus !== Order::STATUS_FULLY_PREPARED) {
        
        return response()->json([
            'status' => 'info',
            'message' => 'Order is not fully prepared.'
        ], 200);
    }

    // Update the order status
    $order->status = $status;
    $order->save();

    return response()->json([
        'status' => 'success',
        'message' => "Order status changed to: {$status}."
    ], 200);
}


}
