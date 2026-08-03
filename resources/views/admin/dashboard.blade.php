@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<h3 class="fw-bold mb-4">📊 Dashboard</h3>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">New Orders</div>
            <div class="stat-value">{{ $stats['new_orders'] }}</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-label">Revenue</div>
            <div class="stat-value">PKR {{ number_format($stats['total_revenue']) }}</div>
        </div>
    </div>

</div>

<h5 class="fw-bold mb-3">Recent Orders</h5>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>City</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                    <td>{{ $order->city }}</td>
                    <td>PKR {{ number_format($order->total) }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color:#8b8f9a;">
                        No Orders Found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection