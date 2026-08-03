@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

<style>
    .settings-row {
        display: flex;
        align-items: center;
        gap: 2rem;
        padding: 1.25rem 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .settings-row .input-col { flex: 1; }
    .settings-row .form-control {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(212,175,55,.3);
        color: #fff;
        border-radius: 0;
        padding: .5rem .25rem;
        font-size: 1.05rem;
    }
    .settings-row .form-control:focus {
        background: transparent;
        border-bottom-color: #D4AF37;
        box-shadow: none;
        color: #fff;
    }
    .btn-save-settings {
        background: #b3122e;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: .6rem 2rem;
        border-radius: 6px;
        transition: background .2s ease;
        white-space: nowrap;
    }
    .btn-save-settings:hover { background: #d70c2e; color: #fff; }
    .table .form-control {
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(212,175,55,.25);
        color: #fff;
        border-radius: 0;
    }

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

<h3 class="fw-bold mb-1">📂 Categories</h3>
<p class="mb-4" style="color:#888;">Manage the categories customers can browse</p>

<div class="settings-row">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex align-items-center gap-3 w-100">
        @csrf
        <div class="input-col">
            <input type="text" name="name" class="form-control" placeholder="Category Name" required>
        </div>
        <div class="input-col" style="max-width:180px;">
            <input type="text" name="emoji" class="form-control" placeholder="Emoji (Optional)">
        </div>
        <button type="submit" class="btn-save-settings">Add Category</button>
    </form>
</div>

@error('name')
    <small class="text-danger d-block mb-3">{{ $message }}</small>
@enderror

<div class="table-responsive mt-4">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Emoji</th>
                <th>Products</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="emoji" value="{{ $category->emoji }}" class="form-control">
                    </td>
                    <td>{{ $category->products_count }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Save</button>
                </form>

                <button type="button" class="btn btn-sm btn-danger"
                        onclick="openDeleteModal('delete-form-{{ $category->id }}', '{{ $category->name }}')">
                    Delete
                </button>

                <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
                    </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center" style="color:#8b8f9a;">No Categories Found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- ---- Delete Confirmation Modal ---- --}}
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-box">
        <h5>Delete Category?</h5>
        <p id="deleteModalText">Are you sure you want to delete this category? This cannot be undone.</p>
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