<?php 
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
   
    public function createForm()
    {
        $categories = Category::all(); 
        $products = Product::where('seller_id', Auth::id())->get(); 
        $notifications = auth()->user()->notifications; 
        return view('seller.partials.products', compact('categories','products','notifications'));
    }
    
    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'qte_stock' => 'required|integer|min:0',
            'image' => 'nullable|image'
        ]);
        try {
           
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'You need to be logged in to add a product.');
            }
        $category = Category::where('name', $request->category)->first();

        if (!$category) {
            return redirect()->back()->withErrors(['category' => 'Category not found.'])->withInput();
        }
        if ($request->qte_stock <= 0) {
            return redirect()->back()->withErrors(['qte_stock' => 'Quantity in stock must be greater than zero.'])->withInput();
        }
    
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $category->id; 
        $product->qte_stock = $request->qte_stock;
    
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('images',"public");
        }
        $product->seller_id = Auth::id();

    
        $product->save();
        return redirect()->route('products.create')->with('success', 'Product added successfully!');
    }
 catch (\Exception $e) {
    \Log::error('Error adding product: '.$e->getMessage());
    return redirect()->back()->withErrors(['error' => 'An error occurred while adding the product.'])->withInput();
}
}  

public function editProduct($id)
{
    $product = Product::find($id);
    $categories = Category::all(); 

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 400);

    }

    
    $notifications = auth()->user()->notifications; 

    return view('products.edit', compact('product','notifications','categories'));
}

public function updateProduct(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        'qte_stock' => 'required|integer|min:1',
        'image' => 'nullable|image'
    ], [
        'qte_stock.min' => 'The quantity in stock must be greater than zero.',
    ]);
    
    // Find the product
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }
    if ($validatedData['qte_stock'] <= 0) {
        return response()->json(['error' => 'Quantity in stock must be greater than zero'], 422);

    }
    // Update product details
    $product->name = $validatedData['name'];
    $product->description = $validatedData['description'];
    $product->price = $validatedData['price'];
    $product->category_id = $validatedData['category_id'];
    $product->qte_stock = $validatedData['qte_stock'];

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('images');
    }

    // Save the product
    $product->save();

    return response()->json(['success' => 'Product updated successfully']);
}

public function destroy($id)
{
    $product = Product::find($id);

    if ($product) {
        $product->delete();
        return redirect()->route('products.create')->with('success', 'Product deleted successfully');
    }

    return redirect()->route('products.create')->with('error', 'Product not found');
}

   
    public function searchProduct(Request $request)
    {
        $searchTerm = $request->input('query'); 
    
        $products = Product::where('seller_id', Auth::id())
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            })
            ->get();
            $notifications = auth()->user()->notifications; 
        return view('seller.partials.searchResults', compact('products', 'searchTerm','notifications')); 
    }
    
public function showProduct($id)
{
    $product = Product::findOrFail($id);
    $notifications = auth()->user()->notifications; 

    return view('products.show', compact('product','notifications'));
}




}