<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'brand', 'images']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', (float) $request->rating);
        }

        if ($request->boolean('on_sale')) {
            $query->whereNotNull('old_price');
        }

        if ($request->boolean('new_arrivals')) {
            $query->where('is_new', true);
        }

        if ($request->boolean('bestsellers')) {
            $query->where('is_bestseller', true);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        match ($request->get('sort')) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'rating' => $query->orderBy('rating', 'desc'),
            'newest' => $query->latest(),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $brands = \App\Models\Brand::withCount('products')->get();

        return view('shop.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
    
$product = Product::with(['category', 'brand', 'images', 'reviews'])->where('slug', $slug)->firstOrFail();
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}