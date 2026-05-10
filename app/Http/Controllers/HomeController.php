<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::with('category')->where('featured', true)->take(8)->get();
        $newArrivals = Product::with('category')->latest()->take(8)->get();
        $categories = Category::withCount('products')->get();
        $topViewed = Product::with('category')->orderBy('view', 'desc')->take(4)->get();

        return view('home', compact('featured', 'newArrivals', 'categories', 'topViewed'));
    }
}
