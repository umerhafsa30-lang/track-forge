<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'new_orders' => Order::where('status', 'New')->count(),
            'total_products' => Product::count(),
            'total_revenue' => Order::whereIn('status', ['Delivered', 'Shipped', 'Processing'])->sum('total'),
        ];

        $recentOrders = Order::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
