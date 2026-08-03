@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)

@section('content')
<h3 class="fw-bold mb-4">Order {{ $order->order_number }}</h3>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 mb-3" style="background:#1c1c1c; color:#fff; border:1px solid #333;">
            <h6 class="fw-bold">Items</h6>
            <table class="table table-sm table-dark">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>PKR {{ number_format($item->price) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>PKR {{ number_format($item->price * $item->qty) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <p class="mb-1">Subtotal: PKR {{ number_format($order->subtotal) }}</p>
                <p class="mb-1">Delivery: PKR {{ number_format($order->delivery_charge) }}</p>
                <h5>Total: PKR {{ number_format($order->total) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card p-4 mb-3" style="background:#1c1c1c; color:#fff; border:1px solid #333;">
            <h6 class="fw-bold">Customer</h6>
            <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
            <p class="mb-1">📞 {{ $order->phone }}</p>
            @if($order->email)<p class="mb-1">📧 {{ $order->email }}</p>@endif
            <p class="mb-1">📍 {{ $order->area }}, {{ $order->city }}</p>
            <p class="mb-1">{{ $order->full_address }}</p>
            @if($order->notes)<p class="mb-1" style="color:#bbb;">Notes: {{ $order->notes }}</p>@endif
            <p class="mb-0">Payment: {{ strtoupper($order->payment_method) }}</p>
        </div>

        <div class="card p-4" style="background:#1c1c1c; color:#fff; border:1px solid #333;">
            <h6 class="fw-bold">Update Status</h6>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex gap-2">
                @csrf @method('PATCH')
                <select name="status" class="form-select">
                    @foreach(['New','Processing','Shipped','Delivered','Cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="btn" style="background:#b3122e;color:#fff;">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection