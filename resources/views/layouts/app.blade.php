<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TrackForge')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #f4e02d;
            --red: #910a21;
            --red-dark: #d70c2e;
            --black: #000000;
        }
        
        body { font-family: 'Segoe UI', sans-serif; background: #000000; }
        .navbar {
            background: var(--black) !important;
            border-bottom: none;
            background-image: linear-gradient(var(--black), var(--black)), repeating-linear-gradient(90deg, #FFD700 0 20px, #000000 20px 40px);
            background-size: 100% calc(100% - 4px), 100% 4px;
            background-position: top, bottom;
            background-repeat: no-repeat;
        }
        .navbar-brand { font-weight: 800; color: #fff !important; letter-spacing: .5px; }
        .nav-link { color: #ddd !important; }
        .nav-link:hover { color: var(--red) !important; }
        .btn-brand { background: var(--red); border-color: var(--red); color: #fff; font-weight: 600; }
        .btn-brand:hover { background: var(--red-dark); border-color: var(--gold); color: #fff; }
        .product-card { transition: transform .15s; border-radius: 10px; overflow: hidden; border: 1px solid #e2e2e2; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(15, 11, 11, 0.98); border-color: var(--red); }
        .badge-sale { background: var(--red); color: var(--gold); font-weight: 700; border: 1px solid var(--gold); }
      .hero { background: var(--red); color: #fff; }
        .hero .badge { background: var(--black); color: var(--gold); font-weight: 600; border: 1px solid var(--gold); }
        .hero h1 span { color: var(--gold); }
        .hero .lead { color: #f0d9d9; }
        section h3, section h4, section h5 { color: #ffffff; border-left: 4px solid var(--red); padding-left: 10px; }
        footer { background: var(--black); color: #ccc; border-top: 3px solid var(--gold); }
        footer a { color: #ccc; text-decoration: none; }
        footer a:hover { color: var(--red); }
        footer h5, footer h6 { color: #fff !important; position: relative; display: inline-block; }
        footer h5::after, footer h6::after { content: ''; display: block; width: 40px; height: 2px; background: var(--gold); margin-top: 6px; }
        a { color: var(--red); }
        .text-warning { color: var(--gold) !important; }
        .fw-bold, h1, h2, h3 { color: #ffffff; }
       .top-banner{
    background:#212529;
    color:#FFD700;
    overflow:hidden;
    white-space:nowrap;
    width:100%;
    height:45px;
    line-height:45px;
}

.scroll-text{
    display:inline-block;
    white-space:nowrap;
    padding-left:100%;
    animation:scroll 15s linear infinite;
}

@keyframes scroll{
    from{
        transform:translateX(0);
    }
    to{
        transform:translateX(-200%);
    }
}

/* Global text fix — white text by default */
body, p, span, li, label, small, td, th, h1, h2, h3, h4, h5, h6 {
    color: #ffffff;
}

.footer-newsletter .form-control {
    background: #000 !important;
    color: #f4e9c9 !important;
    border: 2px solid #D4AF37 !important;
}
.footer-newsletter .form-control::placeholder {
    color: #7a6a4a !important;
}



/* Links stay red as per your theme, not white */
a {
    color: var(--red);
}

/* ===== THEMED FORM ELEMENTS ===== */
.form-select {
    background-color: #000000 !important;
    color: #f4e9c9 !important;
    border: 2px solid #D4AF37 !important;
}
.form-select:focus {
    border-color: #FFD100 !important;
    box-shadow: 0 0 0 .25rem rgba(212,175,55,.25) !important;
}
.form-select option {
    background: #000000;
    color: #f4e9c9;
}

.navbar .form-control::placeholder {
    color: #7a6a4a;
}

/* ===== ENHANCED FOOTER ===== */
footer.site-footer {
    background: #000000;
    position: relative;
    overflow: hidden;
}
footer.site-footer::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: repeating-linear-gradient(90deg, #f4e02d 0 20px, #000000 20px 40px);
}
.footer-newsletter {
    background: #0a0a0a;
    border: 1px solid rgba(212,175,55,.3);
    border-radius: 10px;
    padding: 24px;
}
.footer-newsletter input[type="email"] {
    background: #000;
    border: 2px solid #D4AF37;
    color: #f4e9c9;
    border-radius: 4px;
}
.footer-newsletter input[type="email"]::placeholder { color: #7a6a4a; }
.footer-newsletter .btn-brand { border-radius: 4px; }

.footer-social a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(212,175,55,.1);
    border: 1px solid rgba(212,175,55,.4);
    margin-right: 10px;
    font-size: 18px;
    transition: all .25s ease;
    text-decoration: none;
}
.footer-social a:hover {
    background: var(--gold);
    color: #000 !important;
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(244,224,45,.4);
}

.footer-links a {
    display: inline-block;
    transition: transform .2s ease, color .2s ease;
    position: relative;
}
.footer-links a:hover {
    color: var(--gold) !important;
    transform: translateX(4px);
}

.payment-badge {
    background: #111;
    border: 1px solid rgba(212,175,55,.3);
    color: #f4e9c9;
    font-size: .75rem;
    padding: 4px 10px;
    border-radius: 4px;
    margin: 3px;
    display: inline-block;
}

.footer-bottom-strip {
    background: #0a0a0a;
    border-top: 1px solid rgba(212,175,55,.25);
}

/* ===== BACK BUTTON STRIP ===== */
.back-strip {
    background-image: repeating-linear-gradient(90deg, #FFD700 0 20px, #000000 20px 40px);
    background-size: 100% 4px;
    background-position: bottom;
    background-repeat: no-repeat;
    padding-top: 10px;
    padding-bottom: 14px;
    margin-bottom: 0;
}

/* ===== IMAGE LOADING SKELETON ===== */
.img-skeleton-wrap {
    position: relative;
    height: 160px;
    background: #111;
    overflow: hidden;
}
.img-skeleton-wrap.skeleton-active::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, #111 25%, #222 50%, #111 75%);
    background-size: 200% 100%;
    animation: skeletonShimmer 1.4s infinite;
    z-index: 1;
}
@keyframes skeletonShimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
.img-skeleton-wrap img,
.img-skeleton-wrap .emoji-fallback {
    opacity: 0;
    transition: opacity .4s ease;
    position: relative;
    z-index: 2;
}
.img-skeleton-wrap img.loaded,
.img-skeleton-wrap .emoji-fallback.loaded {
    opacity: 1;
}
    </style>
</head>
<body>

<div class="top-banner">
    <div class="scroll-text">
       🏁 Welcome to TrackForge | 🚚 FREE DELIVERY ON ORDERS ABOVE PKR 3,000 | 🚗 Premium RC Cars, Die-Cast & Metal Cars | ⭐ Order Now & Race Into Fun!
    </div>
</div>
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold d-flex align-items-center"
   href="{{ route('home') }}"
   style="color:#FFD700 !important;font-size:28px;">
    <img src="{{ asset('images/trackforge-logo.png') }}" alt="TrackForge Logo" style="height:40px; margin-right:8px;">
    TrackForge
</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.index') }}">Shop</a>
                </li>
            </ul>

            <form class="d-flex mx-auto align-items-center gap-2"
                  action="{{ route('shop.index') }}"
                  method="GET"
                  style="width:600px;">

                <div style="position:relative; flex:1;">
                    <input
                        class="form-control"
                        type="search"
                        name="search"
                        placeholder="Search"
                        style="height:50px;
                               width:100%;
                               border:2px solid #D4AF37;
                               border-radius:0;
                               background:#fff;
                               color:#000;
                               font-size:16px;
                               font-weight:600;
                               padding-right:50px;
                               box-shadow:0 0 12px rgba(212,175,55,.35);">

                    <button type="submit"
                            style="position:absolute;
                                   right:6px;
                                   top:50%;
                                   transform:translateY(-50%);
                                   background:transparent;
                                   border:none;
                                   font-size:20px;
                                   cursor:pointer;
                                   line-height:1;
                                   padding:6px;">
                        🔍
                    </button>
                </div>

                <select name="brand" class="form-select" style="height:50px; max-width:160px; border:2px solid #D4AF37; border-radius:0;">
                    <option value="">All Brands</option>
                    @foreach(\App\Models\Brand::orderBy('name')->get() as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-brand" style="height:50px; border-radius:0;">
                    Go
                </button>

            </form>

            <button type="button" class="btn btn-brand position-relative" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">

                🛒 Cart

                @php
                    $cartCount = collect(session('cart', []))->sum('qty');
                @endphp

                @if($cartCount > 0)
                    <span class="badge position-absolute top-0 start-100 translate-middle rounded-pill"
                          style="background:#D4AF37;color:#000;">
                        {{ $cartCount }}
                    </span>
                @endif

            </button>

        </div>
    </div>
</nav>

    @if(session('success'))
        <div class="alert alert-success mb-0 text-center rounded-0">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-0 text-center rounded-0">{{ session('error') }}</div>
    @endif

    <main>
        <div class="back-strip">
            <div class="container">
                <button onclick="history.back()" class="btn btn-sm btn-outline-light">← Back</button>
            </div>
        </div>
        @yield('content')
    </main>

    <footer class="site-footer pt-5 pb-0 mt-5">
        <div class="container">

            {{-- Newsletter Strip --}}
            <div class="footer-newsletter mb-5">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <h5 class="mb-1">📩 Join the Race — Get Exclusive Deals</h5>
                        <p class="mb-0 small" style="color:#ccc;">Subscribe for new arrivals, discounts &amp; giveaways.</p>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex gap-2">
    @csrf
    <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
    <button type="submit" class="btn btn-brand px-4">Subscribe</button>
</form>
@error('email')
    <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
@enderror
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <h5>🚗 TrackForge</h5>
                    <p class="mt-2">Pakistan's first dedicated car toy store. RC cars, die-cast, metal cars — all in one place.</p>
                    <div class="footer-social mt-3">
                        <a href="#" title="Facebook">📘</a>
                        <a href="#" title="Instagram">📸</a>
                        <a href="https://wa.me/923000000000" title="WhatsApp">💬</a>
                        <a href="#" title="YouTube">▶️</a>
                    </div>
                </div>

                <div class="col-md-3 footer-links">
                    <h6>Quick Links</h6>
                    <p class="mt-2"><a href="{{ route('home') }}">🏠 Home</a></p>
                    <p><a href="{{ route('shop.index') }}">🛍️ Shop</a></p>
                    <p><a href="{{ route('cart.index') }}">🛒 Cart</a></p>
                </div>

                <div class="col-md-3 footer-links">
                    <h6>Categories</h6>
                    <p class="mt-2"><a href="{{ route('shop.index') }}">🏎️ RC Cars</a></p>
                    <p><a href="{{ route('shop.index') }}">🚙 Die-Cast</a></p>
                    <p><a href="{{ route('shop.index') }}">🚚 Monster Trucks</a></p>
                </div>

                <div class="col-md-3">
                    <h6>Contact &amp; Trust</h6>
                    <p class="mt-2">📞 0300-TrackForge</p>
                    <p>📍 Islamabad, Pakistan</p>
                    <p>✉️ support@trackforge.pk</p>
                    <div class="mt-3">
                        <span class="payment-badge">💳 Cards</span>
                        <span class="payment-badge">💵 COD</span>
                        <span class="payment-badge">🏦 Bank Transfer</span>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h6>❓ FAQs</h6>

                    <div class="row mt-3 g-3">
                        <div class="col-md-6">
                            <strong style="color:#FFD100;">How long does delivery take?</strong>
                            <p class="small mb-0" style="color:#ccc;">Orders are delivered within 3-5 working days across Pakistan. Orders placed before 3 PM get same-day dispatch.</p>
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#FFD100;">Is Cash on Delivery available?</strong>
                            <p class="small mb-0" style="color:#ccc;">Yes, COD is available, along with card payments and bank transfer.</p>
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#FFD100;">What is your return policy?</strong>
                            <p class="small mb-0" style="color:#ccc;">We offer a 7-day easy return, no questions asked — the product must be in its original condition.</p>
                        </div>
                        <div class="col-md-6">
                            <strong style="color:#FFD100;">Are the products original?</strong>
                            <p class="small mb-0" style="color:#ccc;">Yes, all products are 100% original and quality-tested.</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-secondary mt-5">
        </div>

        <div class="footer-bottom-strip py-3">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <p class="mb-0 small"style="color:#7a6a4a;">© {{ date('Y') }} TrackForge | Race Beyond, Play Bigger 🏎️💨</p>
                <p class="mb-0 small" style="color:#7a6a4a;">🔒 Secure Checkout &nbsp;|&nbsp; 🚚 Nationwide Delivery</p>
            </div>
             <div class="container text-center mt-2">
        <p class="mb-0 small" style="color:#7a6a4a;">Developed by Hafsa</p>
    </div>
        </div>
    </footer>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel" style="background:#000000; color:#f4e9c9; border-left:1px solid rgba(212,175,55,.4); width:380px;">
        <div class="offcanvas-header" style="border-bottom:1px solid rgba(212,175,55,.3);">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel" style="color:#FFD100;">🛒 Your Cart</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            @php
                $miniCart = session('cart', []);
                $miniSubtotal = collect($miniCart)->sum(fn($item) => $item['price'] * $item['qty']);
            @endphp

            @if(empty($miniCart))
                <p style="color:#ccc;">Your cart is empty.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-brand mt-2">Start Shopping</a>
            @else
                <div class="flex-grow-1" style="overflow-y:auto;">
                    @foreach($miniCart as $item)
                        <div class="d-flex align-items-center gap-2 mb-3 pb-3" style="border-bottom:1px solid rgba(212,175,55,.15);">
                            <div style="font-size:1.8rem;">{{ $item['emoji'] ?? '🚗' }}</div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="color:#f4e9c9;">{{ $item['name'] }}</div>
                                <div class="small" style="color:#D4AF37;">PKR {{ number_format($item['price']) }}</div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf @method('PATCH')
                                        <button type="submit" name="qty" value="{{ max(1, $item['qty'] - 1) }}" class="btn btn-sm" style="background:#000000;color:#D4AF37;border:1px solid rgba(212,175,55,.4);width:28px;padding:0;">−</button>
                                        <span style="min-width:20px;text-align:center;color:#f4e9c9;">{{ $item['qty'] }}</span>
                                        <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="btn btn-sm" style="background:#000000;color:#D4AF37;border:1px solid rgba(212,175,55,.4);width:28px;padding:0;">+</button>
                                    </form>
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="padding:2px 8px;">🗑️</button>
                                    </form>
                                </div>
                            </div>
                            <div class="fw-bold" style="color:#f4e9c9;">PKR {{ number_format($item['price'] * $item['qty']) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="pt-3" style="border-top:1px solid rgba(212,175,55,.3);">
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span style="color:#f4e9c9;">Subtotal</span>
                        <span style="color:#FFD100;">PKR {{ number_format($miniSubtotal) }}</span>
                    </div>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light w-100 mb-2">View Full Cart</a>
                    <a href="{{ route('checkout.index') }}" class="btn btn-brand w-100">Checkout →</a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>