<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Categories;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'description',
        'price',
        'category_id',
        'image',
        'is_featured',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ✅ បន្ថែម: product នេះស្ថិតក្នុងកន្ត្រកណាខ្លះ
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // ✅ បន្ថែម: product នេះត្រូវបានទិញក្នុង order ណាខ្លះ
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}