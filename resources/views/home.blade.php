@extends('layouts.app')
@section('title', $settings->store_name . ' | RC Cars, Die-Cast, Toy Cars')

@section('content')
    <style>
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatY {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(4deg); }
        }
        @keyframes floatYSlow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-24px) rotate(-6deg); }
        }
        @keyframes driftX {
            0% { transform: translateX(0); }
            50% { transform: translateX(20px); }
            100% { transform: translateX(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes speedStreak {
            0% { transform: translateX(-120%); opacity: 0; }
            10% { opacity: .5; }
            90% { opacity: .5; }
            100% { transform: translateX(120%); opacity: 0; }
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes driveAcross {
            0% { transform: translateX(-40px) scale(.9); opacity: 0; }
            15% { opacity: 1; }
            50% { transform: translateX(0) scale(1.1); }
            85% { opacity: 1; }
            100% { transform: translateX(40px) scale(.9); opacity: 0; }
        }
        @keyframes pulseGlow {
            0%, 100% { text-shadow: 0 0 12px rgba(212,175,55,.4); }
            50% { text-shadow: 0 0 28px rgba(212,175,55,.8), 0 0 40px rgba(255,209,0,.4); }
        }

        /* ===== GLOBAL AMBIENT FLOATING LAYER ===== */
        .global-floaters {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .gfloat {
            position: absolute;
            opacity: .33;
            filter: drop-shadow(0 0 10px rgba(212,175,55,.45));
            animation: floatY 7s ease-in-out infinite;
        }
        .gfloat.slow { animation: floatYSlow 10s ease-in-out infinite; }
        .gfloat.drift { animation: floatY 8s ease-in-out infinite, driftX 12s ease-in-out infinite; }

        @media (prefers-reduced-motion: reduce) {
            .gfloat, .speed-streak, .marquee-track, .drive-across { animation: none !important; }
        }

        .page-content {
            position: relative;
            z-index: 1;
        }

        /* ===== HERO ===== */
        .hero-lively {
            background: radial-gradient(circle at 20% 20%, #b3122e 0%, #7a0c1e 55%, #2a0508 100%);
            position: relative;
            overflow: hidden;
            border-bottom: 6px solid;
            border-image: repeating-linear-gradient(90deg, #D4AF37 0 20px, #1a0000 20px 40px) 6;
        }

        .hero-lively::before {
            content: "🏎️";
            position: absolute;
            font-size: 12rem;
            opacity: .22;
            right: -20px;
            top: -20px;
            animation: floatY 5s ease-in-out infinite, pulseGlow 3s ease-in-out infinite;
        }
        .hero-lively::after {
            content: "🎮";
            position: absolute;
            font-size: 8rem;
            opacity: .16;
            left: -10px;
            bottom: -20px;
            animation: floatY 6s ease-in-out infinite reverse;
        }

        .speed-streak {
            position: absolute;
            height: 3px;
            width: 40%;
            background: linear-gradient(90deg, transparent, #FFD100, transparent);
            transform: skewX(-20deg);
            animation: speedStreak 2.2s linear infinite;
        }

        .car-decor {
            position: absolute;
            font-size: 3rem;
            opacity: .08;
            pointer-events: none;
            animation: floatY 5s ease-in-out infinite;
            z-index: 0;
        }
        .hero-content h1 {
            animation: fadeInUp .7s ease both, pulseGlow 2.5s ease-in-out infinite 1s;
            font-style: italic;
            transform: skewX(-2deg);
        }
        .hero-content p:nth-of-type(1) { animation: fadeInUp .7s .15s ease both; }
        .hero-content p:nth-of-type(2) { animation: fadeInUp .7s .3s ease both; }
        .hero-content a { animation: fadeInUp .7s .45s ease both; }

        .btn-shine {
            background: linear-gradient(90deg, #B22222, #d4302f, #B22222);
            background-size: 200% auto;
            transition: transform .2s ease, box-shadow .2s ease, background-position .6s ease;
        }
        .btn-shine:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 24px rgba(178,34,34,.5);
            background-position: right center;
            color: #fff;
        }

        .btn-shine-gold {
            background: linear-gradient(90deg, #D4AF37, #FFD100, #D4AF37);
            background-size: 200% auto;
            color: #1a0000;
            border: none;
            transition: transform .2s ease, box-shadow .2s ease, background-position .6s ease;
            animation: pulseGlow 2s ease-in-out infinite;
        }
        .btn-shine-gold:hover {
            transform: translateY(-3px) scale(1.06);
            box-shadow: 0 10px 30px rgba(255,209,0,.6);
            background-position: right center;
            color: #1a0000;
        }

        /* ===== TRUST BADGE — Glassmorphism ===== */
        .trust-badge {
            background: rgba(212, 175, 55, 0.15) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(212, 175, 55, 0.5) !important;
            color: #FFD100 !important;
        }

        /* ===== TICKER — premium scrolling text strip ===== */
        .marquee-wrap {
            overflow: hidden;
            background: linear-gradient(90deg, #1a0000, #2a0508 50%, #1a0000);
            border-top: 2px solid rgba(212,175,55,.4);
            border-bottom: 2px solid rgba(212,175,55,.4);
            padding: 14px 0;
            position: relative;
        }
        .marquee-track {
            display: flex;
            width: max-content;
            gap: 3rem;
            animation: marquee 18s linear infinite;
        }
        .marquee-wrap:hover .marquee-track { animation-play-state: paused; }

        .ticker-track {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            font-size: 1.05rem;
            align-items: center;
            gap: 1.2rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #FFD100;
        }
        .ticker-track span:not(.dot) {
            text-shadow: 0 0 8px rgba(255,209,0,.4);
        }
        .ticker-track .dot {
    color: #ffffff;
    font-size: 1.3rem;
    opacity: .85;
}
        

        /* ===== SECTION HEADINGS ===== */
        .section-heading {
            position: relative;
            display: inline-block;
            font-style: italic;
            transform: skewX(-1deg);
        }
        .section-heading::after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background: linear-gradient(90deg, #FFD100, #D4AF37, transparent);
            margin-top: 6px;
            border-radius: 2px;
        }

        /* ===== CATEGORY CARDS ===== */
        .cat-card {
            background: #000000;
            border: 1px solid rgba(212,175,55,.25);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            overflow: hidden;
            position: relative;
        }
        .cat-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 16px 34px rgba(212,175,55,.25), 0 0 0 1px rgba(212,175,55,.5);
            border-color: #FFD100;
        }
        .cat-card .emoji-wrap {
            transition: transform .25s ease;
            font-size: 2.5rem;
        }
        .cat-card:hover .emoji-wrap {
            animation: driveAcross .6s ease;
        }
        .cat-card .fw-semibold { color: #f4e9c9 !important; }
        .cat-card small { color: rgba(244,233,201,.6) !important; }

        .fade-in-section {
            animation: fadeInUp .6s ease both;
        }
        .row.g-3 > div, .row.g-4 > div {
            animation: fadeInUp .5s ease both;
        }
        .row.g-3 > div:nth-child(1), .row.g-4 > div:nth-child(1) { animation-delay: .05s; }
        .row.g-3 > div:nth-child(2), .row.g-4 > div:nth-child(2) { animation-delay: .1s; }
        .row.g-3 > div:nth-child(3), .row.g-4 > div:nth-child(3) { animation-delay: .15s; }
        .row.g-3 > div:nth-child(4), .row.g-4 > div:nth-child(4) { animation-delay: .2s; }
        .row.g-3 > div:nth-child(5), .row.g-4 > div:nth-child(5) { animation-delay: .25s; }
        .row.g-3 > div:nth-child(6), .row.g-4 > div:nth-child(6) { animation-delay: .3s; }

        .view-all-link {
            color: #D4AF37 !important;
            font-weight: 600;
            transition: letter-spacing .2s ease, color .2s ease;
        }
        .view-all-link:hover {
            letter-spacing: 1px;
            color: #FFD100 !important;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #D4AF37, transparent);
            margin: 2.5rem 0;
            opacity: .5;
        }

        /* ===== REVIEWS SECTION ===== */
        .review-card {
            background: #000000;
            border: 1px solid rgba(212,175,55,.25);
            border-radius: 10px;
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        .review-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(212,175,55,.2);
            border-color: #FFD100;
        }
        .review-form-box {
            background: #0a0a0a;
            border: 1px solid rgba(212,175,55,.3);
            border-radius: 10px;
        }
        .review-form-box .form-control,
        .review-form-box .form-select {
            background: #000 !important;
            color: #f4e9c9 !important;
            border: 2px solid #D4AF37 !important;
        }
        .review-form-box .form-control::placeholder { color: #7a6a4a; }
    </style>

    {{-- ===== GLOBAL AMBIENT FLOATERS ===== --}}
    <div class="global-floaters" aria-hidden="true">
        <span class="gfloat"       style="top:5%;  left:8%;   font-size:3rem;">🏎️</span>
        <span class="gfloat slow"  style="top:16%; right:6%;  font-size:2.4rem;">🎮</span>
        <span class="gfloat drift" style="top:32%; left:20%;  font-size:2.8rem;">🛞</span>
        <span class="gfloat"       style="top:48%; right:14%; font-size:2.6rem;">🏁</span>
        <span class="gfloat slow"  style="top:58%; left:5%;   font-size:3rem;">🚗</span>
        <span class="gfloat drift" style="top:70%; right:22%; font-size:2.5rem;">⚡</span>
        <span class="gfloat"       style="top:82%; left:30%;  font-size:2.8rem;">🤖</span>
        <span class="gfloat slow"  style="top:92%; right:8%;  font-size:2.6rem;">🔧</span>
        <span class="gfloat drift" style="top:24%; left:48%;  font-size:2.4rem;">🕹️</span>
    </div>

    <div class="page-content">



    <section class="hero-lively py-5">
        <span class="speed-streak" style="top:22%;"></span>
        <span class="speed-streak" style="top:48%; animation-delay:.7s;"></span>
        <span class="speed-streak" style="top:74%; animation-delay:1.4s;"></span>

        <div class="hero-content text-center position-relative" style="z-index:1;">

            <span class="badge trust-badge mb-3" style="font-weight:700; letter-spacing:1px; padding:8px 18px; border-radius:30px; font-size:.85rem; animation: fadeInUp .6s ease both;">
                🔥 TRUSTED BY 5,000+ CUSTOMERS ACROSS PAKISTAN
            </span>

            <h1 class="display-4 fw-bold text-uppercase"
                style="color:#D4AF37; font-weight:900; letter-spacing:3px;">
                FUEL YOUR IMAGINATION
            </h1>

            <p class="lead fw-bold text-uppercase"
               style="color:#FFD100; font-weight:800; letter-spacing:2px;">
                🏁 PLAY MORE. DREAM BIGGER. RACE BEYOND! 🏁
            </p>

            <p class="lead mb-4 text-white">
                Pakistan's first dedicated car toy store. RC Cars, Die-Cast, Metal Cars — All in One Place.
            </p>

            <a href="{{ route('shop.index') }}"
               class="btn btn-lg px-5 py-3 fw-bold btn-shine-gold">
                🛒 Shop Now
            </a>

            <div class="row justify-content-center mt-5 pt-3" style="border-top:1px solid rgba(212,175,55,.25);">
                <div class="col-4 col-md-2 text-center">
                    <div class="stat-number" data-count="5000" style="color:#D4AF37; font-size:1.8rem; font-weight:800;">0+</div>
                    <div class="small text-white-50">Happy Customers</div>
                </div>
                <div class="col-4 col-md-2 text-center">
                    <div class="stat-number" data-count="{{ $categories->count() }}" style="color:#D4AF37; font-size:1.8rem; font-weight:800;">0+</div>
                    <div class="small text-white-50">Categories</div>
                </div>
                <div class="col-4 col-md-2 text-center">
                    <div class="stat-number" data-count="50" style="color:#D4AF37; font-size:1.8rem; font-weight:800;">0+</div>
                    <div class="small text-white-50">Cities Delivered</div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== TICKER — premium scrolling text strip ===== --}}
    <div class="marquee-wrap">
        <div class="marquee-track ticker-track">
            <span>RC CARS</span><span class="dot"> 🏁</span>
            <span>DIE-CAST COLLECTIBLES</span><span class="dot"> 🏁</span>
            <span>FREE DELIVERY NATIONWIDE</span><span class="dot"> 🏁</span>
            <span>MONSTER TRUCKS</span><span class="dot"> 🏁</span>
            <span>ELECTRIC CARS</span><span class="dot"> 🏁</span>
            <span>NEW ARRIVALS WEEKLY</span><span class="dot"> 🏁</span>
            <span>RC CARS</span><span class="dot">🏁</span>
            <span>DIE-CAST COLLECTIBLES</span><span class="dot">🏁</span>
            <span>FREE DELIVERY NATIONWIDE ON ORDERS ABOVE 3000</span><span class="dot">🏁</span>
            <span>MONSTER TRUCKS</span><span class="dot">🏁</span>
            <span>ELECTRIC CARS</span><span class="dot">🏁</span>
            <span>NEW ARRIVALS WEEKLY</span><span class="dot">🏁</span>
        </div>
    </div>

    <section class="container py-5 fade-in-section position-relative">
        <span class="car-decor" style="top:0; right:5%;">🏎️</span>
        <span class="car-decor" style="bottom:-10px; left:2%; font-size:2.2rem;">🚙</span>
        <h3 class="fw-bold mb-4 section-heading">Shop By Category</h3>
        <div class="row g-3">
            @foreach($categories as $cat)
                <div class="col-6 col-md-3">
                    <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                        <div class="card cat-card text-center p-3 h-100">
                            <div class="emoji-wrap" style="font-size:2.5rem">{{ $cat->emoji }}</div>
                            <div class="fw-semibold mt-2">{{ $cat->name }}</div>
                            <small>{{ $cat->products_count }} products</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    @if($brands->count())
    <div class="container"><div class="section-divider"></div></div>
    <section class="container py-4 fade-in-section position-relative">
        <span class="car-decor" style="top:-10px; right:6%;">🔧</span>
        <h3 class="fw-bold mb-4 section-heading">Shop By Brand</h3>
        <div class="row g-3">
            @foreach($brands as $brand)
                <div class="col-6 col-md-3">
                    <a href="{{ route('shop.index', ['brand' => $brand->id]) }}" class="text-decoration-none">
                        <div class="card cat-card text-center p-3 h-100">
                            <div class="fw-semibold">{{ $brand->name }}</div>
                            <small>{{ $brand->products_count }} products</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($bestsellers->count())
    <div class="container"><div class="section-divider"></div></div>
    <section class="container py-4 fade-in-section position-relative">
        <span class="car-decor" style="top:-10px; left:3%;">🚚</span>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 section-heading">🔥 Bestsellers</h3>
            <a href="{{ route('shop.index', ['bestsellers' => 1]) }}" class="view-all-link">View All →</a>
        </div>
        <div class="row g-4">
            @foreach($bestsellers as $product)
                @include('shop._product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    @if($newArrivals->count())
    <div class="container"><div class="section-divider"></div></div>
    <section class="container py-4 fade-in-section position-relative">
        <span class="car-decor" style="top:-10px; right:4%;">🏁</span>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 section-heading">🆕 New Arrivals</h3>
            <a href="{{ route('shop.index', ['new_arrivals' => 1]) }}" class="view-all-link">View All →</a>
        </div>
        <div class="row g-4">
            @foreach($newArrivals as $product)
                @include('shop._product-card', ['product' => $product])
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== CUSTOMER REVIEWS ===== --}}
    <div class="container"><div class="section-divider"></div></div>
    <section class="container py-4 fade-in-section position-relative">
        <span class="car-decor" style="top:-10px; left:4%;">⭐</span>
        <h3 class="fw-bold mb-4 section-heading">⭐ What Our Customers Say</h3>

        @php
            $reviews = \App\Models\Review::where('is_approved', true)->latest()->take(6)->get();
        @endphp

        @if($reviews->count())
            <div class="row g-4">
                @foreach($reviews as $review)
                    <div class="col-md-4">
                        <div class="review-card p-4 h-100">
                            <div style="color:#FFD100; font-size:1.2rem;">{{ str_repeat('⭐', $review->rating) }}</div>
                            <p class="mt-2 mb-2" style="color:#f4e9c9;">"{{ $review->comment }}"</p>
                            <div class="fw-semibold" style="color:#D4AF37;">— {{ $review->name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-white-50">No reviews yet. Be the first to share your experience!</p>
        @endif

        {{-- Submit Review Form --}}
        <div class="mt-5 p-4 review-form-box" style="max-width:600px;">
            <h5 class="mb-3">✍️ Leave a Review</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <select name="rating" class="form-select" required>
                        <option value="">Select Rating</option>
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Good</option>
                        <option value="3">⭐⭐⭐ Average</option>
                        <option value="2">⭐⭐ Poor</option>
                        <option value="1">⭐ Bad</option>
                    </select>
                </div>
                <div class="mb-3">
                    <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience..." required></textarea>
                </div>
                <button type="submit" class="btn btn-brand">Submit Review</button>
            </form>
        </div>
    </section>

    </div> {{-- /.page-content --}}

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const counters = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-count'));
                    let current = 0;
                    const duration = 1500;
                    const stepTime = 16;
                    const steps = duration / stepTime;
                    const increment = target / steps;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        el.textContent = Math.floor(current) + '+';
                    }, stepTime);

                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(el => observer.observe(el));
    });
    </script>
@endsection