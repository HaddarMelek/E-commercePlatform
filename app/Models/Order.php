<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_PARTIALLY_PREPARED = 'partially_prepared';
    const STATUS_FULLY_PREPARED = 'fully_prepared';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'user_id',

        'reference',
        'order_date',
        'status',
        'total',
        'name',
        'phone_number',
        'address',
        'admin_commission', 
        'seller_earnings', 
    ];
    
    protected $casts = [
        'order_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'reference', 'reference');
    }

    public function products()
{
    return $this->belongsToMany(Product::class, 'carts', 'reference', 'product_id', 'reference', 'id')
                ->withPivot('quantity'); 
}

    public function sellerEarnings()
    {
        return $this->hasMany(SellerEarnings::class);
    }

    public function getAdminCommissionAttribute()
    {
        return $this->total * 0.10;
    }

    public function getSellersEarningsAttribute()
    {
        return $this->total * 0.90; 
    }
    public function orderConfirmations()
    {
        return $this->hasMany(OrderConfirmation::class);
    }

    public function checkPreparationStatus()
    {
        $totalSellers = $this->orderConfirmations()->where('order_id', $this->id)->count();
            $confirmedSellers = $this->orderConfirmations()->where('order_id', $this->id)->where('confirmed', true)->count();
            if ($confirmedSellers === 0) {
            return self::STATUS_PROCESSING;
        } elseif ($confirmedSellers < $totalSellers) {
            return self::STATUS_PARTIALLY_PREPARED; 
        } elseif ($confirmedSellers === $totalSellers) {
            return self::STATUS_FULLY_PREPARED;
        }
    }
    

}
