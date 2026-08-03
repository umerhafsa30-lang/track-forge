@extends('layouts.admin')
@section('title', 'Edit Product')

@section('content')
<h3 class="fw-bold mb-4">✏️ Edit Product</h3>

<div class="card p-4" style="background:#000000;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.products._form')
    </form>
</div>

{{-- ===== PRODUCT GALLERY (Multiple Images) ===== --}}
<div class="card p-4 mt-4" style="background:#000000;">
    <h4 class="fw-bold mb-3" style="color:#D4AF37;">🖼️ Product Gallery</h4>
    <p class="small mb-3" style="color:#888;">Upload multiple images to show different angles of this product.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Upload Form --}}
    <form action="{{ route('admin.products.images.upload', $product) }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="d-flex gap-3 align-items-end flex-wrap">
            <div style="flex:1; min-width:250px;">
                <label class="form-label" style="color:#fff;">Select Images (multiple allowed)</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn-save-settings">⬆️ Upload</button>
        </div>
    </form>

    {{-- Existing Images Grid --}}
    @if($product->images->count())
        <div class="row g-3">
            @foreach($product->images as $image)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="position-relative" style="border:1px solid rgba(212,175,55,.3); border-radius:8px; overflow:hidden;">
                        <img src="{{ $image->url }}" alt="Product image" style="width:100%; height:120px; object-fit:cover;">
                        <form action="{{ route('admin.products.images.delete', $image) }}" method="POST" onsubmit="return confirm('Remove this image?')" class="position-absolute" style="top:6px; right:6px;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="padding:2px 8px; font-size:.75rem;">✕</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="small" style="color:#666;">No gallery images uploaded yet.</p>
    @endif
</div>
@endsection