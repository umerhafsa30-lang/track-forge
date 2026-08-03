@extends('layouts.admin')
@section('title', 'Edit Coupon')

@section('content')
<style>
    .admin-dark-card { background:#000; border:1px solid rgba(212,175,55,.35); border-radius:10px; }
    .admin-dark-card label { color:#FFD100 !important; }
    .admin-dark-card .form-control, .admin-dark-card .form-select { background:#000 !important; color:#f4e9c9 !important; border:1px solid rgba(212,175,55,.4) !important; }
    .btn-coupon-create {
    background: #dc3545 !important;
    color: #ffffff !important;
    border: none !important;
    font-weight: 600;
}
.btn-coupon-create:hover {
    background: #bb2d3b !important;
    color: #ffffff !important;
}
</style>

<h4 class="fw-bold mb-4" style="color:#FFFFFF;">Edit Coupon</h4>

<div class="admin-dark-card p-4">
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.coupons._form')
   <button class="btn btn-coupon-create mt-3">Update Coupon</button>
    </form>
</div>
@endsection