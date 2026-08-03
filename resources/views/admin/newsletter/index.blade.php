@extends('layouts.admin')
@section('title', 'Newsletter')

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

<h3 class="fw-bold mb-1">📩 Newsletter Subscribers</h3>
<p class="mb-4" style="color:#888;">{{ $subscribers->total() }} total subscribers</p>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Subscribed On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscribers as $sub)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sub->email }}</td>
                    <td>{{ $sub->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger"
                                onclick="openDeleteModal('delete-form-{{ $sub->id }}', '{{ $sub->email }}')">
                            Delete
                        </button>

                        <form id="delete-form-{{ $sub->id }}" action="{{ route('admin.newsletter.destroy', $sub) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center" style="color:#8b8f9a;">No subscribers yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $subscribers->links() }}

{{-- ---- Delete Confirmation Modal ---- --}}
<div class="delete-modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-box">
        <h5>Remove Subscriber?</h5>
        <p id="deleteModalText">Are you sure you want to remove this subscriber? This cannot be undone.</p>
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
            `Are you sure you want to remove "${name}"? This cannot be undone.`;
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