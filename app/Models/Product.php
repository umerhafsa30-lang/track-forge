<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'price', 'old_price',
        'description', 'specifications', 'image_url', 'emoji', 'badge',
        'rating', 'is_bestseller', 'is_new', 'in_stock',
    ];

    protected $casts = [
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'in_stock' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }
public function images()
{
    return $this->hasMany(ProductImage::class)->orderBy('sort_order');
}

public function reviews()
{
    return $this->hasMany(Review::class)->where('is_approved', true)->latest();
}

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function specsArray(): array
    {
        if (empty($this->specifications)) {
            return [];
        }

        $specs = [];
        foreach (explode("\n", $this->specifications) as $line) {
            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $specs[trim($key)] = trim($value);
            }
        }

        return $specs;
    }

    public function getImageUrlFullAttribute()
    {
        if (empty($this->image_url)) {
            return null;
        }

      
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }

        return asset('storage/' . $this->image_url);
    }
}