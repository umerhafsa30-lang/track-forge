@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Coupon Code *</label>
        <input type="text" name="code" class="form-control" required
               value="{{ old('code', $coupon->code ?? '') }}" placeholder="e.g. SAVE20">
    </div>

    <div class="col-md-6">
        <label class="form-label">Type *</label>
        <select name="type" class="form-select">
            <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
            <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount (Rs.)</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Value *</label>
        <input type="number" step="0.01" name="value" class="form-control" required
               value="{{ old('value', $coupon->value ?? '') }}" placeholder="e.g. 10">
    </div>

    <div class="col-md-6">
        <label class="form-label">Minimum Order Amount</label>
        <input type="number" step="0.01" name="min_order_amount" class="form-control"
               value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" placeholder="Optional">
    </div>

    <div class="col-md-6">
        <label class="form-label">Max Discount Amount (for %)</label>
        <input type="number" step="0.01" name="max_discount_amount" class="form-control"
               value="{{ old('max_discount_amount', $coupon->max_discount_amount ?? '') }}" placeholder="Optional cap">
    </div>

    <div class="col-md-6">
        <label class="form-label">Total Usage Limit</label>
        <input type="number" name="usage_limit" class="form-control"
               value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" placeholder="Unlimited if empty">
    </div>

    <div class="col-md-6">
        <label class="form-label">Usage Limit Per User</label>
        <input type="number" name="usage_limit_per_user" class="form-control"
               value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? '') }}" placeholder="Unlimited if empty">
    </div>

    <div class="col-md-6">
        <label class="form-label">Starts At</label>
        <input type="datetime-local" name="starts_at" class="form-control"
               value="{{ old('starts_at', isset($coupon) && $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Expires At</label>
        <input type="datetime-local" name="expires_at" class="form-control"
               value="{{ old('expires_at', isset($coupon) && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
    </div>

    <div class="col-12">
        <div class="form-check">
           <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
       {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active" style="color:#f4e9c9 !important;">Active</label>
        </div>
    </div>
</div>