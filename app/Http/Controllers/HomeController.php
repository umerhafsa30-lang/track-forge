<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $brands = \App\Models\Brand::withCount('products')->get();
        $bestsellers = Product::where('is_bestseller', true)->latest()->take(8)->get();
        $newArrivals = Product::where('is_new', true)->latest()->take(8)->get();
        $settings = Setting::current();

        return view('home', compact('categories', 'brands', 'bestsellers', 'newArrivals', 'settings'));
    }
}