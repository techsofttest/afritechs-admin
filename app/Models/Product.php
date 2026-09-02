<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_desc',
        'meta_key',
        'featured_status',
        'is_active',
        'is_flagship',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_flagship' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variants(): BelongsToMany
    {
        return $this->belongsToMany(Variant::class, 'product_variant')
            ->withTimestamps();
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ProductFaq::class, 'product_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id')
            ->orderBy('sort_order');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class, 'product_id')
            ->orderBy('sort_order');
    }
}