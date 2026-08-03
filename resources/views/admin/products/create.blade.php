@extends('layouts.admin')
@section('title', 'Add Product')

@section('content')

<h3 class="fw-bold mb-4">+ Add New Product</h3>

<div class="card p-4" style="background:#000000;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.products._form')
    </form>
</div>

@endsection