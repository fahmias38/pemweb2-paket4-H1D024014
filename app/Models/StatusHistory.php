<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'changed_by',
        'notes',
    ];

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
