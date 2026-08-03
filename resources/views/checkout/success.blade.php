@extends('layouts.app')
@section('title', 'Order Placed | TrackForge')

@section('content')
<div class="container py-5 text-center">
    <div style="font-size:4rem;">✅</div>
    <h2 class="fw-bold">Order Placed! 🎉</h2>
    <p class="lead">Thankyou for your order!</p>

    <div class="card p-4 mx-auto text-start" style="max-width:500px; background: #000000 !important; border: 1px solid rgba(212,175,55,.35);">
        <p style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">Order ID:</strong> {{ $order->order_number }}</p>
        <p style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
        <p style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">City:</strong> {{ $order->city }}</p>
        <p style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">Payment:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">Total:</strong> PKR {{ number_format($order->total) }}</p>
        <p class="mb-0" style="color:#ffffff !important;"><strong style="color:#FFD100 !important;">Estimated Delivery:</strong> 24–48 Hours</p>
    </div>

    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn" style="border:1px solid #D4AF37; color:#D4AF37 !important; background:transparent;">🏠 Continue Shopping</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    confetti({
        particleCount: 150,
        spread: 90,
        origin: { y: 0.6 },
        colors: ['#D4AF37', '#FFD100', '#910a21', '#ffffff']
    });

    setTimeout(() => {
        confetti({
            particleCount: 80,
            angle: 60,
            spread: 70,
            origin: { x: 0 },
            colors: ['#D4AF37', '#FFD100']
        });
        confetti({
            particleCount: 80,
            angle: 120,
            spread: 70,
            origin: { x: 1 },
            colors: ['#D4AF37', '#FFD100']
        });
    }, 400);
});
</script>
@endsection