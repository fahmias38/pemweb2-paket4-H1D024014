<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_id',
        'received_by',
        'received_at',
        'estimated_finish_date',
        'total_weight',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'received_at' => 'date',
        'estimated_finish_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function histories()
    {
        return $this->hasMany(StatusHistory::class);
    }
}
