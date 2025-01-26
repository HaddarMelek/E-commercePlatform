<?php

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Fetch all categories from the database
        return view('buyer.partials.shop', compact('categories'));
    }
}
