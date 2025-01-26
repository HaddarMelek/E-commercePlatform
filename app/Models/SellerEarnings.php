<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerEarnings extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'order_id',
        'seller_id',
        'earnings',
    ];

    /**
     * Get the order that owns the seller earnings.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the seller associated with the earnings.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    
}
