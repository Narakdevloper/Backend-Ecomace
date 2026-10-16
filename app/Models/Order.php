<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\Adress;
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'status',
        'total_amount',
        'payment_method',
        'note',
    ];

    protected $casts = [
        'total_amount' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Adress::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}