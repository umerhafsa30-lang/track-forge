@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<style>
    .filter-row {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-row .form-control,
    .filter-row .form-select {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(212,175,55,.3);
        border-radius: 0;
        padding: .5rem .25rem;
    }

    .filter-row .form-control {
        color: #fff;
    }

    .filter-row .form-control::placeholder {
        color: #5a5e68;
    }

    .filter-row .form-control:focus,
    .filter-row .form-select:focus {
        background: transparent;
        border-bottom-color: #D4AF37;
        box-shadow: none;
    }

    /* Default = All Statuses (Gray) */
    .filter-row .form-select.placeholder {
        color: #5a5e68 !important;
    }

    /* Selected Status = White */
    .filter-row .form-select.selected {
        color: #fff !important;
    }

    .btn-save-settings {
        background: #b3122e;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: .55rem 1.75rem;
        border-radius: 6px;
        transition: background .2s ease;
        white-space: nowrap;
    }

    .btn-save-settings:hover {
        background: #d70c2e;
        color: #fff;
    }
</style>

<h3 class="fw-bold mb-1">📦 Orders</h3>
<p class="mb-3" style="color:#888;">View and manage customer orders</p>

<form method="GET" class="filter-row">
    <div style="flex:1; min-width:220px;">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search order#, phone, name..."
            value="{{ request('search') }}">
    </div>

    <div style="min-width:180px;">
        <select
            name="status"
            id="statusFilter"
            class="form-select {{ request('status') ? 'selected' : 'placeholder' }}"
            onchange="updateStatusColor(); this.form.submit()">

            <option value="">All Statuses</option>

            @foreach(['New','Processing','Shipped','Delivered','Cancelled'] as $status)
                <option value="{{ $status }}"
                    {{ request('status') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn-save-settings">Filter</button>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>City</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d M, Y') }}</td>
                <td>
                    {{ $order->first_name }} {{ $order->last_name }}
                    <br>
                    <small style="color:#8b8f9a;">{{ $order->phone }}</small>
                </td>
                <td>{{ $order->city }}</td>
                <td>PKR {{ number_format($order->total) }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td>
                    <span class="badge bg-secondary">
                        {{ $order->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="btn btn-sm btn-outline-light">
                        View
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="color:#8b8f9a;">
                    No orders found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $orders->links() }}

<script>
function updateStatusColor() {
    const select = document.getElementById('statusFilter');

    if (select.value === '') {
        select.classList.remove('selected');
        select.classList.add('placeholder');
    } else {
        select.classList.remove('placeholder');
        select.classList.add('selected');
    }
}

document.addEventListener('DOMContentLoaded', updateStatusColor);
</script>

@endsection