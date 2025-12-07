<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller_id',
        'manager_id',
        'total_items',
        'total_amount',
        'total_cost',
        'profit',
        'status',
        'payment_method',
        'sold_at',
        'client_name',
        'client_phone',
        'invoice_number',
        'created_ip',
        'created_user_agent',
    ];

    protected $dates = ['sold_at'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
