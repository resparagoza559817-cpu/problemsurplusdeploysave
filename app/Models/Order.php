<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    // Allow these fields to be filled during Order::create or $order->fill()[cite: 4]
    protected $fillable = [
        'customer_name',
        'customer_address',
        'total_amount',
        'payment_method',
        'user_id',
    ];

    /**
     * Get the clerk (user) that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}