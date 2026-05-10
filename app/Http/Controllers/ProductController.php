<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $products = collect();

        if ($query) {
            $products = Product::with('category')
                ->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->paginate(12)->appends($request->query());
        }

        return view('search', compact('products', 'query'));
    }

    public function explore()
    {
        // Get sale products for Explore page
        $saleProducts = Product::whereNotNull('sale_price')->take(10)->get();
        // Featured products for slider
        $featuredProducts = Product::where('featured', true)->take(5)->get();

        return view('explore', compact('saleProducts', 'featuredProducts'));
    }

    /**
     * Hiển thị trang chi tiết sản phẩm.
     * Route Model Binding tự động resolve Product từ slug.
     */
    public function show(Product $product)
    {
        $product->increment('view');

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        return view('product', compact('product', 'related'));
    }
}

