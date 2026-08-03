@csrf
<style>
    .settings-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
        padding: 1.5rem 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
        flex-wrap: wrap;
    }
    .settings-row:last-of-type { border-bottom: none; }
    .settings-row .label-col { flex: 0 0 260px; }
    .settings-row .label-col .title { color: #fff; font-weight: 600; font-size: 1rem; margin-bottom: 2px; }
    .settings-row .label-col .hint { color: #888; font-size: .8rem; }
    .settings-row .input-col { flex: 1; min-width: 220px; }
    .settings-row .form-control,
    .settings-row .form-select {
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(212,175,55,.3);
        color: #fff;
        border-radius: 0;
        padding: .5rem .25rem;
        font-size: 1.05rem;
        text-align: right;
    }
    .settings-row .form-control:focus,
    .settings-row .form-select:focus {
        background: transparent;
        border-bottom-color: #D4AF37;
        box-shadow: none;
        color: #fff;
    }
    .settings-row textarea.form-control { text-align: left; }
    .settings-row .form-check { text-align: right; }
    .btn-save-settings {
        background: #b3122e;
        border: none;
        color: #fff;
        font-weight: 600;
        padding: .75rem 2.5rem;
        border-radius: 6px;
        transition: background .2s ease;
    }
    .btn-save-settings:hover { background: #d70c2e; color: #fff; }

    .btn-ai-generate {
        background: transparent;
        border: 1px solid #D4AF37;
        color: #D4AF37;
        font-size: .8rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        transition: all .2s ease;
    }
    .btn-ai-generate:hover {
        background: #D4AF37;
        color: #000;
    }
    .btn-ai-generate:disabled {
        opacity: .5;
        cursor: not-allowed;
    }
</style>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Product Name</div>
        <div class="hint">Required — shown to customers</div>
    </div>
    <div class="input-col">
        <input type="text" name="name" id="productNameField" class="form-control" required value="{{ old('name', $product->name ?? '') }}">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Brand</div>
        <div class="hint">Optional — assign a brand</div>
    </div>
    <div class="input-col">
        <select name="brand_id" class="form-select">
            <option value="">-- None --</option>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Category</div>
        <div class="hint">Required</div>
    </div>
    <div class="input-col">
        <select name="category_id" class="form-select" required>
            <option value="">-- Select --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Emoji</div>
        <div class="hint">Fallback icon if no image is uploaded</div>
    </div>
    <div class="input-col">
        <input type="text" name="emoji" class="form-control" value="{{ old('emoji', $product->emoji ?? '🏎️') }}">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Price</div>
        <div class="hint">In PKR</div>
    </div>
    <div class="input-col">
        <input type="number" name="price" class="form-control" required value="{{ old('price', $product->price ?? '') }}">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Old Price</div>
        <div class="hint">Optional — shown as strikethrough</div>
    </div>
    <div class="input-col">
        <input type="number" name="old_price" class="form-control" value="{{ old('old_price', $product->old_price ?? '') }}">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Rating</div>
        <div class="hint">Between 1 and 5</div>
    </div>
    <div class="input-col">
        <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control" value="{{ old('rating', $product->rating ?? 5) }}">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Badge</div>
        <div class="hint">Highlight tag on product card</div>
    </div>
    <div class="input-col">
        <select name="badge" class="form-select">
            @foreach(['none' => 'None', 'NEW' => 'NEW', 'HOT' => 'HOT', 'SALE' => 'SALE'] as $val => $label)
                <option value="{{ $val }}" {{ old('badge', $product->badge ?? 'none') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Product Image</div>
        <div class="hint">
            @if(!empty($product->image_url))
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="Current" style="height:50px;border-radius:6px;margin-top:6px;">
            @else
                No image uploaded yet
            @endif
        </div>
    </div>
    <div class="input-col">
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Specifications</div>
        <div class="hint">One per line: Key: Value</div>
    </div>
    <div class="input-col">
        <textarea name="specifications" id="specificationsField" class="form-control" rows="4" placeholder="Scale: 1:18&#10;Battery: Rechargeable">{{ old('specifications', $product->specifications ?? '') }}</textarea>
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Description</div>
        <div class="hint">
            Required — full product details<br>
            <button type="button" id="generateDescBtn" class="btn-ai-generate mt-2">✨ Generate with AI</button>
            <div id="aiLoadingText" class="text-warning mt-1" style="display:none; font-size:.75rem;">⏳ Generating...</div>
        </div>
    </div>
    <div class="input-col">
        <textarea name="description" id="descriptionField" class="form-control" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

<div class="settings-row">
    <div class="label-col">
        <div class="title">Flags</div>
        <div class="hint">Toggle product status</div>
    </div>
    <div class="input-col">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="is_bestseller" value="1" id="bestseller" {{ old('is_bestseller', $product->is_bestseller ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="bestseller">Bestseller</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="is_new" value="1" id="isnew" {{ old('is_new', $product->is_new ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="isnew">New Arrival</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="instock" {{ old('in_stock', $product->in_stock ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="instock">In Stock</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn-save-settings">💾 Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light ms-2">Cancel</a>
</div>

<script>
document.getElementById('generateDescBtn').addEventListener('click', function () {
    const name = document.getElementById('productNameField').value;
    const specs = document.getElementById('specificationsField').value;

    if (!name) {
        alert('Pehle product name likho.');
        return;
    }

    const btn = this;
    const loadingText = document.getElementById('aiLoadingText');
    const descField = document.getElementById('descriptionField');

    btn.disabled = true;
    loadingText.style.display = 'block';

    fetch('{{ route("admin.products.generate-description") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name: name, specs: specs })
    })
    .then(res => res.json())
    .then(data => {
        if (data.description) {
            descField.value = data.description;
        } else {
            alert(data.error || 'Kuch masla ho gaya.');
        }
    })
    .catch(() => alert('Request fail ho gayi.'))
    .finally(() => {
        btn.disabled = false;
        loadingText.style.display = 'none';
    });
});
</script>