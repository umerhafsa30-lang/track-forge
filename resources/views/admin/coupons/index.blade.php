@extends('layouts.admin')
@section('title', 'Coupons')

@section('content')
<style>
    .admin-dark-card {
        background: #000000;
        border: 1px solid rgba(212,175,55,.35);
        border-radius: 10px;
    }
    .admin-dark-card th, .admin-dark-card td {
        color: #f4e9c9 !important;
        border-color: rgba(212,175,55,.2) !important;
    }
    .badge-active { background: rgba(40,167,69,.2); color: #7ee787; border: 1px solid rgba(40,167,69,.4); }
    .badge-inactive { background: rgba(220,53,69,.2); color: #ff8080; border: 1px solid rgba(220,53,69,.4); }
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
    <h4 class="fw-bold" style="color:#FFFFFF;">🎟️ Coupons</h4>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-coupon-create">+ New Coupon</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-dark-card p-3">
    <table class="table table-dark table-borderless align-middle mb-0">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Used</th>
                <th>Status</th>
                <th>Expires</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
                <tr>
                    <td class="fw-bold">{{ $coupon->code }}</td>
                    <td>{{ ucfirst($coupon->type) }}</td>
                    <td>
                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'Rs. ' . number_format($coupon->value) }}
                    </td>
                    <td>{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' }}</td>
                    <td>
                        @if($coupon->is_active)
                            <span class="badge badge-active">Active</span>
                        @else
                            <span class="badge badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-warning">Edit</a>

                        <button type="button" class="btn btn-sm btn-outline-danger"
                                onclick="openDeleteModal('delete-form-{{ $coupon->id }}', '{{ $coupon->code }}')">
                            Delete
                        </button>

                        <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4">No coupons yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $coupons->links() }}</div>

{{-- ---- Delete Confirmation Modal ---- --}}
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-box">
        <h5>Delete Coupon?</h5>
        <p id="deleteModalText">Are you sure you want to delete this coupon? This cannot be undone.</p>
        <div class="delete-modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-modal-confirm" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
    let formToSubmit = null;

    function openDeleteModal(formId, code) {
        formToSubmit = document.getElementById(formId);
        document.getElementById('deleteModalText').textContent =
            `Are you sure you want to delete "${code}"? This cannot be undone.`;
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

    // Overlay ke bahar click karke bhi close ho jaye
    document.getElementById('deleteModalOverlay').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endsection