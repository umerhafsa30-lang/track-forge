<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount', 'max_discount_amount',
        'usage_limit', 'used_count', 'usage_limit_per_user',
        'is_active', 'starts_at', 'expires_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Coupon valid hai ya nahi check karne wala helper
    public function isValid(): bool
    {
        if (!$this->is_active) return false;

        if ($this->starts_at && Carbon::now()->lt($this->starts_at)) return false;
        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) return false;

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;

        return true;
    }

    // Discount amount calculate karna
    public function calculateDiscount(float $cartTotal): float
    {
        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'fixed') {
            $discount = $this->value;
        } else {
            $discount = ($cartTotal * $this->value) / 100;
            if ($this->max_discount_amount) {
                $discount = min($discount, $this->max_discount_amount);
            }
        }

        return min($discount, $cartTotal); // discount cart total se zyada na ho
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}