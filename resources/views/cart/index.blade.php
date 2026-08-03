@extends('layouts.app')
@section('title', 'Cart | TrackForge')


@section('content')
<style>
    .cart-table {
        background: #000000;
        border: 1px solid rgba(212,175,55,.35);
        border-radius: 10px;
        overflow: hidden;
    }
    .cart-table table thead,
    .cart-table table thead tr {
        background: #000000 !important;
    }
    .cart-table table thead th {
        background: #000000 !important;
        color: #FFD100 !important;
        border-bottom: 1px solid rgba(212,175,55,.3) !important;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-size: .85rem;
    }
    .cart-table tbody td {
        color: #f4e9c9 !important;
        border-bottom: 1px solid rgba(212,175,55,.15) !important;
        background: #000000 !important;
    }
    .cart-table .form-control {
        background: #000000 !important;
        color: #f4e9c9 !important;
        border: 1px solid rgba(212,175,55,.4) !important;
    }
</style>

<div class="container py-4">
    <nav class="small mb-3" style="color:#aaa;">Home › Cart</nav>
    <h3 class="fw-bold mb-4">Your Cart</h3>

    @if(empty($cart))
        <p style="color:#ccc;">Cart is empty. <a href="{{ route('shop.index') }}" style="color:#D4AF37;">Shop now →</a></p>
    @else
        <div class="table-responsive cart-table p-2">
            <table class="table align-middle mb-0" style="background:transparent;">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr></thead>
                <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['emoji'] ?? '🚗' }} {{ $item['name'] }}</td>
                        <td>PKR {{ number_format($item['price']) }}</td>
                        <td style="width:120px;">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex">
                                @csrf @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" class="form-control form-control-sm" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>PKR {{ number_format($item['price'] * $item['qty']) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <h5 style="color:#f4e9c9;">Subtotal: PKR {{ number_format($subtotal) }}</h5>
            <a href="{{ route('checkout.index') }}" class="btn btn-brand btn-lg mt-2">Proceed to Checkout →</a>
        </div>
    @endif
</div>
@endsection