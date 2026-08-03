@extends('layouts.app')
@section('title', 'Checkout | TrackForge')

@section('content')
<style>
    .checkout-dark {
        background: #000000;
        border: 1px solid rgba(212,175,55,.35);
        border-radius: 10px;
    }
    .checkout-dark h5 {
        color: #FFD100 !important;
    }
    .checkout-dark .form-check-label {
        color: #f4e9c9 !important;
    }
    .checkout-dark .form-control,
    .checkout-dark .form-select {
        background: #000000 !important;
        color: #f4e9c9 !important;
        border: 1px solid rgba(212,175,55,.4) !important;
    }
    .checkout-dark .form-control::placeholder {
        color: #e8cfa0 !important;
        opacity: .9 !important;
    }
    .checkout-dark option {
        background: #000000 !important;
        color: #f4e9c9 !important;
    }
    .checkout-dark hr {
        border-color: rgba(212,175,55,.3);
        opacity: 1;
    }
    .checkout-dark span {
        color: #f4e9c9 !important;
    }
    .coupon-applied-box {
        background: rgba(40, 167, 69, .15);
        border: 1px solid rgba(40, 167, 69, .5);
        border-radius: 8px;
        padding: 10px 14px;
    }
    .coupon-applied-box span {
        color: #7ee787 !important;
        font-size: .9rem;
    }
    .coupon-remove-btn {
        background: none;
        border: none;
        color: #ff8080 !important;
        font-size: .85rem;
        text-decoration: underline;
        padding: 0;
    }
    .coupon-error {
        color: #ff8080 !important;
        font-size: .85rem;
    }
</style>

<div class="container py-4">
    <nav class="small mb-3" style="color:#aaa;">Home › Cart › Checkout</nav>
    <div class="row g-4">
        <div class="col-md-7">
            <form action="{{ route('checkout.store') }}" method="POST" class="checkout-dark p-4">
                @csrf
                <h5 class="fw-bold">1. Contact Info</h5>
                <div class="row g-2 mb-3">
                    <div class="col-6"><input type="text" name="first_name" class="form-control" placeholder="First Name *" required value="{{ old('first_name') }}"></div>
                    <div class="col-6"><input type="text" name="last_name" class="form-control" placeholder="Last Name *" required value="{{ old('last_name') }}"></div>
                    <div class="col-6"><input type="text" name="phone" class="form-control" placeholder="Phone *" required value="{{ old('phone') }}"></div>
                    <div class="col-6"><input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"></div>
                </div>

                <h5 class="fw-bold">2. Delivery Address</h5>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <select name="city" class="form-select" required>
                            <option value="">Select City</option>
                            @foreach(['Lahore','Karachi','Islamabad','Rawalpindi','Faisalabad','Multan','Peshawar','Quetta','Sialkot','Gujranwala','Hyderabad','Other'] as $city)
                                <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6"><input type="text" name="area" class="form-control" placeholder="Area *" required value="{{ old('area') }}"></div>
                    <div class="col-12"><textarea name="full_address" class="form-control" placeholder="Full Address *" required>{{ old('full_address') }}</textarea></div>
                    <div class="col-12"><textarea name="notes" class="form-control" placeholder="Notes (optional)">{{ old('notes') }}</textarea></div>
                </div>

               <h5 class="fw-bold">3. Payment Method</h5>
<div class="mb-3">
    <div class="form-check"><input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked onchange="document.getElementById('cardFields').style.display='none'"><label class="form-check-label" for="cod">💵 Cash on Delivery</label></div>
    <div class="form-check"><input class="form-check-input" type="radio" name="payment_method" value="prepaid" id="prepaid" onchange="document.getElementById('cardFields').style.display='block'"><label class="form-check-label" for="prepaid">💳 Prepaid (Card)</label></div>
</div>

<div id="cardFields" class="row g-2 mb-3" style="display:none;">
    <div class="col-12"><input type="text" name="card_number" class="form-control" placeholder="Card Number *" maxlength="19" value="{{ old('card_number') }}"></div>
    <div class="col-6"><input type="text" name="card_expiry" class="form-control" placeholder="MM/YY *" maxlength="5" value="{{ old('card_expiry') }}"></div>
    <div class="col-6"><input type="text" name="card_cvv" class="form-control" placeholder="CVV *" maxlength="4" value="{{ old('card_cvv') }}"></div>
    <div class="col-12"><input type="text" name="card_holder" class="form-control" placeholder="Name on Card *" value="{{ old('card_holder') }}"></div>
</div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <button class="btn btn-brand btn-lg w-100">🛒 Place Order →</button>
                <script>
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('prepaid').checked) {
        document.getElementById('cardFields').style.display = 'block';
    }
});
</script>
            </form>
        </div>

        <div class="col-md-5">
            <div class="checkout-dark p-4">
                <h5 class="fw-bold">Your Order</h5>
                @foreach($cart as $item)
                    <div class="d-flex justify-content-between small mb-1">
                        <span>{{ $item['name'] }} × {{ $item['qty'] }}</span>
                        <span>PKR {{ number_format($item['price'] * $item['qty']) }}</span>
                    </div>
                @endforeach
                <hr>

                {{-- ---- Coupon Box ---- --}}
                @if(session('coupon'))
                    <div class="coupon-applied-box d-flex justify-content-between align-items-center mb-3">
                        <span>✓ "{{ session('coupon')['code'] }}" applied — Rs. {{ number_format(session('coupon')['discount'], 0) }} off</span>
                        <form action="{{ route('checkout.remove-coupon') }}" method="POST" class="mb-0">
                            @csrf
                            <button type="submit" class="coupon-remove-btn">Remove</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="code" class="form-control form-control-sm" placeholder="Coupon code">
                        <button type="submit" class="btn btn-brand btn-sm">Apply</button>
                    </form>
                @endif

                @if(session('error'))
                    <div class="coupon-error mb-3">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="coupon-error mb-3" style="color:#7ee787 !important;">{{ session('success') }}</div>
                @endif
                {{-- ---- End Coupon Box ---- --}}

                <div class="d-flex justify-content-between"><span>Subtotal</span><span>PKR {{ number_format($subtotal) }}</span></div>
                <div class="d-flex justify-content-between"><span>Delivery</span><span>PKR {{ number_format($deliveryCharge) }}</span></div>
                @if(session('coupon'))
                    <div class="d-flex justify-content-between" style="color:#7ee787 !important;">
                        <span>Discount</span>
                        <span>- PKR {{ number_format(session('coupon')['discount']) }}</span>
                    </div>
                @endif
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span style="color:#FFD100 !important;">Total</span>
                    <span style="color:#FFD100 !important;">
                        PKR {{ number_format($subtotal + $deliveryCharge - (session('coupon')['discount'] ?? 0)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection