<div class="col-6 col-md-3">
    <div class="card product-card h-100">
        <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark">
            <div class="d-flex align-items-center justify-content-center img-skeleton-wrap skeleton-active">
                @if($product->image_url_full)
                    <img src="{{ $product->image_url_full }}"
                         alt="{{ $product->name }}"
                         class="w-100 h-100"
                         style="object-fit:cover;"
                         loading="lazy"
                         onload="this.classList.add('loaded'); this.closest('.img-skeleton-wrap').classList.remove('skeleton-active');"
                         onerror="this.closest('.img-skeleton-wrap').classList.remove('skeleton-active');">
                @else
                    <div class="emoji-fallback loaded" style="font-size:3rem;">{{ $product->emoji }}</div>
                @endif
            </div>
            <div class="card-body">
                @if($product->badge !== 'none')
                    <span class="badge badge-sale mb-1">{{ $product->badge }}</span>
                @endif
                <h6 class="mb-1" style="color:#000000;">{{ Str::limit($product->name, 40) }}</h6>
                <div class="small text-warning mb-1">
                    {{ str_repeat('★', (int) round($product->rating)) }}{{ str_repeat('☆', 5 - (int) round($product->rating)) }}
                    <span class="text-muted">({{ $product->rating }})</span>
                </div>
                <div>
                    <span class="fw-bold" style="color:#000000;">PKR {{ number_format($product->price) }}</span>
                    @if($product->old_price)
                        <span class="text-muted text-decoration-line-through small">PKR {{ number_format($product->old_price) }}</span>
                    @endif
                </div>
            </div>
        </a>
        <div class="card-footer bg-white border-0 pb-3">
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="qty" value="1">
                <button class="btn btn-brand w-100 btn-sm" @if(!$product->in_stock) disabled @endif>
                    {{ $product->in_stock ? '🛒 Add to Cart' : 'Out of Stock' }}
                </button>
            </form>
        </div>
    </div>
</div>