@extends('layouts.admin')

@section('title', 'Reviews')

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

<h2 class="d-flex align-items-center gap-2">
    ⭐ Customer Reviews
    <span class="badge bg-danger">{{ $reviews->total() }}</span>
</h2>

<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $review->name }}</td>
                <td>{{ str_repeat('⭐', $review->rating) }}</td>
                <td style="max-width:300px;">{{ $review->comment }}</td>
                <td>
                    @if($review->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $review->created_at->format('d M Y') }}</td>
                <td class="d-flex gap-2">
                    @if(!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-primary">Approve</button>
                        </form>
                    @endif

                    <button type="button" class="btn btn-sm btn-danger"
                            onclick="openDeleteModal('delete-form-{{ $review->id }}', '{{ $review->name }}')">
                        Delete
                    </button>

                    <form id="delete-form-{{ $review->id }}" action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-none">
                        @csrf @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">No reviews yet.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $reviews->links() }}

{{-- ---- Delete Confirmation Modal ---- --}}
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-box">
        <h5>Delete Review?</h5>
        <p id="deleteModalText">Are you sure you want to delete this review? This cannot be undone.</p>
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
            `Are you sure you want to delete "${name}"'s review? This cannot be undone.`;
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