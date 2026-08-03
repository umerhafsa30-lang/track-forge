@extends('layouts.app')
@section('title', $product->name . ' | TrackForge')

@section('content')
<div class="container py-4">

    <nav class="small mb-3" style="color:#aaa;">
        Home › Shop › {{ $product->name }}
    </nav>

    <div class="row g-4">

        <div class="col-md-5">
            <div class="d-flex align-items-center justify-content-center bg-light rounded" id="mainImageBox" style="height:350px; font-size:6rem; overflow:hidden; cursor:zoom-in;">
                @if($product->image_url_full)
                    <img id="mainProductImage" src="{{ $product->image_url_full }}"
                         alt="{{ $product->name }}"
                         class="w-100 h-100 rounded"
                         style="object-fit:cover;"
                         onclick="openLightbox(0)">
                @else
                    <div id="mainProductImage" style="font-size:6rem;">{{ $product->emoji }}</div>
                @endif
            </div>

            @if($product->images->count())
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    @if($product->image_url_full)
                        <img src="{{ $product->image_url_full }}"
                             class="gallery-thumb"
                             onclick="switchMainImage(this.src, this, 0)"
                             style="width:70px; height:70px; object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid #D4AF37;">
                    @endif

                    @foreach($product->images as $i => $img)
                        <img src="{{ $img->url }}"
                             class="gallery-thumb"
                             onclick="switchMainImage(this.src, this, {{ $product->image_url_full ? $i + 1 : $i }})"
                             style="width:70px; height:70px; object-fit:cover; border-radius:6px; cursor:pointer; border:2px solid transparent;">
                    @endforeach
                </div>
            @endif

            <div class="mt-4">
                <h5 class="fw-bold text-white mb-3">⭐ Customer Reviews</h5>

                @if($product->reviews->count())
                    <div class="d-flex flex-column gap-3 mb-4">
                        @foreach($product->reviews as $review)
                            <div class="p-3" style="background:#121212; border:1px solid rgba(212,175,55,.3); border-radius:8px;">
                                <div style="color:#FFD100;">{{ str_repeat('⭐', $review->rating) }}</div>
                                <p class="mt-2 mb-2 text-white">"{{ $review->comment }}"</p>
                                <div class="fw-semibold" style="color:#D4AF37;">— {{ $review->name }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-white-50">No reviews yet. Be the first to share your experience!</p>
                @endif

                <div class="p-4" style="background:#0a0a0a; border:1px solid rgba(212,175,55,.3); border-radius:10px;">
                    <h6 class="mb-3 text-white">✍️ Leave a Review</h6>

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Your name" required
                                   style="background:#000; color:#f4e9c9; border:1px solid rgba(212,175,55,.4);">
                        </div>

                        <div class="mb-2">
                            <select name="rating" class="form-select" required>
                                <option value="">Rating</option>
                                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                <option value="4">⭐⭐⭐⭐ Good</option>
                                <option value="3">⭐⭐⭐ Average</option>
                                <option value="2">⭐⭐ Poor</option>
                                <option value="1">⭐ Bad</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <textarea name="comment" class="form-control" rows="3" placeholder="Write your review..." required
                                      style="background:#000; color:#f4e9c9; border:1px solid rgba(212,175,55,.4);"></textarea>
                        </div>

                        <button type="submit" class="btn btn-brand">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">

            @if($product->badge !== 'none')
                <span class="badge badge-sale mb-2">{{ $product->badge }}</span>
            @endif

            <h2 class="fw-bold text-white">{{ $product->name }}</h2>

            <div class="mb-2 text-white">
                Brand: {{ $product->brand->name ?? 'N/A' }}
                |
                Category: {{ $product->category->name }}
            </div>

            <div class="text-warning mb-2">
                {{ str_repeat('★', (int) round($product->rating)) }}
                {{ str_repeat('☆', 5 - (int) round($product->rating)) }}
                <span class="text-white">({{ $product->rating }})</span>
            </div>

            <h3 class="fw-bold" style="color:#ff6b00;">
                PKR {{ number_format($product->price) }}

                @if($product->old_price)
                    <small class="fs-6 text-white text-decoration-line-through">
                        PKR {{ number_format($product->old_price) }}
                    </small>
                @endif
            </h3>

            <p class="mt-3 text-white">
                {{ $product->description }}
            </p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2 mt-3">
                @csrf

                <input type="number"
                       name="qty"
                       value="1"
                       min="1"
                       class="form-control"
                       style="width:90px;">

                <button class="btn btn-brand" @if(!$product->in_stock) disabled @endif>
                    {{ $product->in_stock ? '🛒 Add to Cart' : 'Out of Stock' }}
                </button>
            </form>

            <ul class="list-unstyled mt-4 text-white">
                <li>🚀 Same-day dispatch on orders before 3 PM</li>
                <li>💵 Cash on Delivery available all over Pakistan</li>
                <li>🔄 7-day easy return — no questions asked</li>
                <li>✅ 100% original, quality-tested product</li>
            </ul>

            @if(count($product->specsArray()))

                <h5 class="fw-bold mt-4 text-white">
                    Specifications
                </h5>

                <table class="table table-bordered mt-3">

                    <tbody>

                        @foreach($product->specsArray() as $key => $value)

                            <tr style="background:#121212;">

                                <td style="background:#121212;color:white;width:35%;border:1px solid #444;">
                                    <strong>{{ $key }}</strong>
                                </td>

                                <td style="background:#121212;color:white;border:1px solid #444;">
                                    {{ $value }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    </div>

    @if($related->count())

        <h4 class="fw-bold mt-5 mb-3 text-white">
            Related Products
        </h4>

        <div class="row g-4">

            @foreach($related as $r)

                @include('shop._product-card', ['product' => $r])

            @endforeach

        </div>

    @endif

</div>

{{-- Lightbox modal --}}
<div id="lightboxOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.92); z-index:9999; align-items:center; justify-content:center;">
    <button onclick="closeLightbox()" style="position:absolute; top:20px; right:25px; background:none; border:none; color:#fff; font-size:2.2rem; cursor:pointer; z-index:2;">&times;</button>

    <button onclick="prevImage()" style="position:absolute; left:15px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,.1); border:none; color:#fff; font-size:2rem; width:50px; height:50px; border-radius:50%; cursor:pointer; z-index:2;">&#10094;</button>

    <div style="overflow:hidden; width:90vw; height:80vh; display:flex; align-items:center; justify-content:center; touch-action:none;" id="lightboxViewport">
        <img id="lightboxImage" src="" style="max-width:100%; max-height:100%; transition:transform .15s ease; cursor:grab; user-select:none;">
    </div>

    <button onclick="nextImage()" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); background:rgba(255,255,255,.1); border:none; color:#fff; font-size:2rem; width:50px; height:50px; border-radius:50%; cursor:pointer; z-index:2;">&#10095;</button>

    <div style="position:absolute; bottom:20px; left:50%; transform:translateX(-50%); display:flex; gap:10px; align-items:center; color:#fff;">
        <button onclick="zoomOut()" style="background:rgba(255,255,255,.1); border:none; color:#fff; font-size:1.3rem; width:40px; height:40px; border-radius:50%; cursor:pointer;">&minus;</button>
        <span id="zoomLevel" style="min-width:50px; text-align:center;">100%</span>
        <button onclick="zoomIn()" style="background:rgba(255,255,255,.1); border:none; color:#fff; font-size:1.3rem; width:40px; height:40px; border-radius:50%; cursor:pointer;">+</button>
    </div>
</div>

<script>
const galleryImages = [
    @if($product->image_url_full)
        "{{ $product->image_url_full }}",
    @endif
    @foreach($product->images as $img)
        "{{ $img->url }}",
    @endforeach
];

let currentIndex = 0;
let zoomScale = 1;

function switchMainImage(src, thumbEl, index) {
    const mainImg = document.getElementById('mainProductImage');
    if (mainImg.tagName === 'IMG') {
        mainImg.src = src;
    }
    currentIndex = index;

    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.style.border = '2px solid transparent';
    });
    thumbEl.style.border = '2px solid #D4AF37';
}

function openLightbox(index) {
    if (!galleryImages.length) return;
    currentIndex = index;
    zoomScale = 1;
    updateLightboxImage();
    document.getElementById('lightboxOverlay').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightboxOverlay').style.display = 'none';
    document.body.style.overflow = '';
}

function updateLightboxImage() {
    const img = document.getElementById('lightboxImage');
    img.src = galleryImages[currentIndex];
    zoomScale = 1;
    img.style.transform = 'scale(1)';
    document.getElementById('zoomLevel').textContent = '100%';
}

function nextImage() {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    updateLightboxImage();
}

function prevImage() {
    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    updateLightboxImage();
}

function zoomIn() {
    zoomScale = Math.min(zoomScale + 0.25, 3);
    applyZoom();
}

function zoomOut() {
    zoomScale = Math.max(zoomScale - 0.25, 1);
    applyZoom();
}

function applyZoom() {
    document.getElementById('lightboxImage').style.transform = `scale(${zoomScale})`;
    document.getElementById('zoomLevel').textContent = Math.round(zoomScale * 100) + '%';
}

// keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightboxOverlay').style.display !== 'flex') return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === '+') zoomIn();
    if (e.key === '-') zoomOut();
});

// scroll wheel zoom inside lightbox
document.getElementById('lightboxViewport')?.addEventListener('wheel', function(e) {
    e.preventDefault();
    if (e.deltaY < 0) zoomIn(); else zoomOut();
});

// click outside image to close
document.getElementById('lightboxOverlay')?.addEventListener('click', function(e) {
    if (e.target.id === 'lightboxOverlay') closeLightbox();
});
</script>
@endsection