@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<style>
    /* ---- Custom Delete Modal ---- */
    .delete-modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,.7);
        z-index: 1050;
        align-items: center;
        justify-content: center;
    }
    .delete-modal-overlay.show {
        display: flex;
    }
    .delete-modal-box {
        background: #0d0d0d;
        border: 1px solid rgba(220,53,69,.4);
        border-radius: 12px;
        padding: 28px;
        width: 100%;
        max-width: 380px;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0,0,0,.6);
    }
    .delete-modal-box h5 {
        color: #ff8080 !important;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .delete-modal-box p {
        color: #f4e9c9 !important;
        font-size: .9rem;
        margin-bottom: 20px;
    }
    .delete-modal-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
    .btn-modal-cancel {
        background: transparent !important;
        border: 1px solid rgba(212,175,55,.4) !important;
        color: #f4e9c9 !important;
        padding: 8px 20px;
        border-radius: 8px;
    }
    .btn-modal-cancel:hover {
        background: rgba(212,175,55,.1) !important;
    }
    .btn-modal-confirm {
        background: #dc3545 !important;
        border: none !important;
        color: #ffffff !important;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-modal-confirm:hover {
        background: #bb2d3b !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">🛍️ Products</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

<form method="GET" class="mb-3">
    <input type="text" name="search" class="form-control" style="max-width:300px;" placeholder="Search products..." value="{{ request('search') }}">
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
       <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Brand</th><th>Price</th><th>Badge</th><th>Stock</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td style="font-size:1.5rem;">{{ $product->emoji }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->brand->name ?? '-' }}</td>
                <td>PKR {{ number_format($product->price) }}</td>
                <td>{{ $product->badge !== 'none' ? $product->badge : '-' }}</td>
                <td>{{ $product->in_stock ? '✅' : '❌' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-light">Edit</a>

                    <button type="button" class="btn btn-sm btn-danger"
                            onclick="openDeleteModal('delete-form-{{ $product->id }}', '{{ $product->name }}')">
                        Delete
                    </button>

                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center" style="color:#8b8f9a;">No products found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $products->links() }}

{{-- ---- Delete Confirmation Modal ---- --}}
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-box">
        <h5>Delete Product?</h5>
        <p id="deleteModalText">Are you sure you want to delete this product? This cannot be undone.</p>
        <div class="delete-modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-modal-confirm" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
    let formToSubmit = null;

    function openDeleteModal(formId, name) {
        formToSubmit = document.getElementById(formId);
        document.getElementById('deleteModalText').textContent =
            `Are you sure you want to delete "${name}"? This cannot be undone.`;
        document.getElementById('deleteModalOverlay').classList.add('show');
    }

    function closeDeleteModal() {
        formToSubmit = null;
        document.getElementById('deleteModalOverlay').classList.remove('show');
    }

    function confirmDelete() {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    }

    document.getElementById('deleteModalOverlay').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endsection