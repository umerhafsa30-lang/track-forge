@extends('layouts.admin')
@section('title', 'Manage Reviews')

@section('content')
<h3 class="fw-bold mb-4">⭐ Manage Reviews</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-4" style="background:#000000;">
    @if($reviews->count())
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th style="width:180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->product->name ?? 'N/A' }}</td>
                            <td>{{ $review->name ?? $review->customer_name ?? 'N/A' }}</td>
                            <td>{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                            <td style="max-width:300px;">{{ Str::limit($review->comment, 80) }}</td>
                            <td>
                                @if($review->approved ?? $review->is_approved ?? false)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                @unless($review->approved ?? $review->is_approved ?? false)
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">✔ Approve</button>
                                    </form>
                                @endunless

                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    @else
        <p class="text-muted">No reviews yet.</p>
    @endif
</div>
@endsection