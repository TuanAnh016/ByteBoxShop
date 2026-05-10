<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị trang danh mục.
     * Route Model Binding tự động resolve Category từ slug.
     */
    public function show(Category $category, Request $request)
    {
        $query = $category->products();

        // Sorting
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'popular'    => $query->orderBy('view', 'desc'),
            default      => $query->latest(),
        };

        $products   = $query->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('categories.show', compact('category', 'products', 'categories', 'sort'));
    }
}

