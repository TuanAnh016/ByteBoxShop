<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $product = Product::findOrFail($request->product_id);
        $qty = $request->get('quantity', 1);

        $cart = $this->getCart();
        $key = $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'slug'     => $product->slug,
                'image'    => $product->getFirstMediaUrl('images') ?: $product->image,
                'price'    => $product->sale_price ?? $product->price,
                'quantity' => $qty,
            ];
        }

        $this->saveCart($cart);
        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, int $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            $this->saveCart($cart);
        }

        if ($request->wantsJson()) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            return response()->json([
                'success' => true,
                'itemTotal' => isset($cart[$id]) ? $cart[$id]['price'] * $cart[$id]['quantity'] : 0,
                'cartTotal' => $total,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request, int $id)
    {
        $cart = $this->getCart();
        unset($cart[$id]);
        $this->saveCart($cart);
        
        if ($request->wantsJson()) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            return response()->json([
                'success' => true,
                'cartTotal' => $total,
                'isEmpty' => empty($cart)
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xoá sản phẩm!');
    }

    public function clear(Request $request)
    {
        session()->forget('cart');
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cartTotal' => 0,
                'isEmpty' => true
            ]);
        }
        
        return redirect()->route('cart.index');
    }
}
