<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method_id',
        'shipping_post_code',
        'shipping_address',
        'shipping_building',
    ];

    //PurchaseとTradeのリレーション
    public function Condition()
    {
        return $this->belongsTo(Trade::class);
    }
}
