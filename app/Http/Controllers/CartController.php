<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'emoji' => $product->emoji,
                'image_url' => $product->image_url,
                'qty' => $qty,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', $product->name . ' added to cart!');
    }

    public function update(Request $request, int $productId)
    {
        $cart = session('cart', []);
        $qty = max(1, (int) $request->input('qty', 1));

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = $qty;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(int $productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart successfully.');
    }
}
