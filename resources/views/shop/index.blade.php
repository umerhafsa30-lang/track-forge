@extends('layouts.app')
@section('title', 'Shop | TrackForge')

@section('content')
<style>
    .filter-card {
        background: #000000;
        border: 1px solid rgba(212,175,55,.35);
        border-radius: 10px;
    }
    .filter-card h6 {
        color: #FFD100 !important;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: .85rem;
    }
    .filter-card label,
    .filter-card .form-check-label {
        color: #f4e9c9 !important;
        opacity: 1 !important;
    }
    .filter-card .form-check-input {
        accent-color: #D4AF37;
        border-color: #D4AF37;
    }
    .filter-card hr {
        border-color: rgba(212,175,55,.3);
        opacity: 1;
    }
    .filter-card .form-control,
    .filter-card .form-select {
        background: #1a0000 !important;
        color: #f4e9c9 !important;
        border: 1px solid rgba(212,175,55,.4);
    }
    .filter-card input[type="number"] {
        color: #f4e9c9 !important;
    }
    .filter-card .form-control::placeholder {
        color: #e8cfa0 !important;
        opacity: .9 !important;
    }
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #FFD100;
        box-shadow: 0 0 0 .2rem rgba(212,175,55,.25);
        background: #1a0000 !important;
        color: #f4e9c9 !important;
    }
    .btn-clear-gold {
        background: transparent !important;
        border: 1px solid #D4AF37 !important;
        color: #D4AF37 !important;
        opacity: 1 !important;
        transition: all .2s ease;
    }
    .btn-clear-gold:hover {
        background: #D4AF37 !important;
        color: #1a0000 !important;
    }
    .sort-select-themed {
        background: #1a0000 !important;
        color: #f4e9c9 !important;
        border: 1px solid rgba(212,175,55,.4) !important;
    }
    .filter-card option {
        background: #1a0000 !important;
        color: #f4e9c9 !important;
    }
</style>

<div class="container py-4">
   <nav class="small mb-3" style="color:#aaa;">Home › Shop</nav>
    <div class="row">
        <div class="col-md-3 mb-4">
            <form method="GET" action="{{ route('shop.index') }}">
                <div class="card filter-card p-3">
                    <h6 class="fw-bold">Categories</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category" value="" id="cat-all" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label" for="cat-all">All</label>
                    </div>
                    @foreach($categories as $cat)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="cat-{{ $cat->id }}">{{ $cat->emoji }} {{ $cat->name }} ({{ $cat->products_count }})</label>
                        </div>
                    @endforeach
                    <hr>
                    <h6 class="fw-bold">Brands</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="brand" value="" id="brand-all" {{ !request('brand') ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label" for="brand-all">All</label>
                    </div>
                    @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="brand" value="{{ $brand->id }}" id="brand-{{ $brand->id }}" {{ request('brand') == $brand->id ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="brand-{{ $brand->id }}">{{ $brand->name }} ({{ $brand->products_count }})</label>
                        </div>
                    @endforeach

                    <hr>
                    <h6 class="fw-bold">Price Range</h6>
                    <div class="d-flex gap-2 mb-2">
                        <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                    </div>

                    <hr>
                    <h6 class="fw-bold">Rating</h6>
                    <select name="rating" class="form-select form-select-sm mb-2">
                        <option value="">All</option>
                        <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4★ & above</option>
                        <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3★ & above</option>
                    </select>

                    <hr>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="on_sale" value="1" id="onsale" {{ request('on_sale') ? 'checked' : '' }}>
                        <label class="form-check-label" for="onsale">On Sale Only</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="new_arrivals" value="1" id="newarr" {{ request('new_arrivals') ? 'checked' : '' }}>
                        <label class="form-check-label" for="newarr">New Arrivals</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="bestsellers" value="1" id="best" {{ request('bestsellers') ? 'checked' : '' }}>
                        <label class="form-check-label" for="best">Bestsellers</label>
                    </div>

                    <button class="btn btn-brand btn-sm">Apply Filters</button>
                    <a href="{{ route('shop.index') }}" class="btn btn-clear-gold btn-sm mt-1">Clear All</a>
                </div>
            </form>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div style="color: #ffffff;">{{ $products->total() }} products</div>
                <form method="GET">
                    @foreach(request()->except('sort') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <select name="sort" class="form-select form-select-sm sort-select-themed" onchange="this.form.submit()">
                        <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>Default</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Best Rating</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    </select>
                </form>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    @include('shop._product-card', ['product' => $product])
                @empty
                   <p style="color:#ccc;">No products found.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection