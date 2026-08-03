<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $settings = Setting::current();
        $deliveryCharge = $subtotal >= $settings->free_delivery_threshold ? 0 : $settings->delivery_charge;
        $coupon = session('coupon'); // agar coupon already applied hai to view mein dikhane ke liye

        return view('checkout.index', compact('cart', 'subtotal', 'deliveryCharge', 'settings', 'coupon'));
    }

    /**
     * Coupon apply karna (AJAX ya normal form submit dono se kaam karega)
     */
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        if (!$coupon->isValid()) {
            return back()->with('error', 'This coupon has expired or is no longer active.');
        }

        // Per-user usage limit check (agar logged in hai)
        if ($coupon->usage_limit_per_user && auth()->check()) {
            $userUsageCount = Order::where('user_id', auth()->id())
                ->where('coupon_id', $coupon->id)
                ->count();

            if ($userUsageCount >= $coupon->usage_limit_per_user) {
                return back()->with('error', 'You have already used this coupon the maximum number of times.');
            }
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $cartTotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            return back()->with('error', "Minimum order amount for this coupon is Rs. {$coupon->min_order_amount}");
        }

        $discount = $coupon->calculateDiscount($cartTotal);

        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
            ]
        ]);

        return back()->with('success', "Coupon applied! You saved Rs. {$discount}");
    }

    /**
     * Coupon remove karna
     */
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'city' => 'required|string|max:100',
            'area' => 'required|string|max:150',
            'full_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,prepaid',
            'card_number' => 'required_if:payment_method,prepaid|nullable|string|max:19',
            'card_expiry' => 'required_if:payment_method,prepaid|nullable|string|max:5',
            'card_cvv' => 'required_if:payment_method,prepaid|nullable|string|max:4',
            'card_holder' => 'required_if:payment_method,prepaid|nullable|string|max:100',
        ]);

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $settings = Setting::current();
        $deliveryCharge = $subtotal >= $settings->free_delivery_threshold ? 0 : $settings->delivery_charge;

        // ---- Coupon discount calculate karna ----
        $discountAmount = 0;
        $couponId = null;
        $sessionCoupon = session('coupon');

        if ($sessionCoupon) {
            $coupon = Coupon::find($sessionCoupon['id']);

            // Re-validate coupon store karte waqt bhi (safety — expire ya deactivate na ho gaya ho)
            if ($coupon && $coupon->isValid()) {
                // Discount dobara calculate karo fresh subtotal ke sath (session wali value pe blindly trust mat karo)
                $discountAmount = $coupon->calculateDiscount($subtotal);
                $couponId = $coupon->id;
            }
        }

        $total = $subtotal + $deliveryCharge - $discountAmount;

        $order = Order::create([
            ...$validated,
            'order_number' => 'CT-' . strtoupper(Str::random(6)),
            'subtotal' => $subtotal,
            'delivery_charge' => $deliveryCharge,
            'coupon_id' => $couponId,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'status' => 'New',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ]);
        }

        // Coupon ka used_count increment karo (agar apply hua tha)
        if ($couponId) {
            Coupon::find($couponId)->increment('used_count');
        }

        session()->forget('cart');
        session()->forget('coupon');
        session(['last_order_id' => $order->id]);

        return redirect()->route('checkout.success');
    }

    public function success()
    {
        $order = Order::with('items')->findOrFail(session('last_order_id'));

        return view('checkout.success', compact('order'));
    }
}