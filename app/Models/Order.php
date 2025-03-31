<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_address',
        'payment_method',
        'total_amount',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => $this->customer_name,
            'email' => $this->customer_email
        ]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
        return $this->hasMany(OrderItem::class)->with('product');
    }
}