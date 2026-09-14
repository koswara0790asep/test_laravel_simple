<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id', 'external_product_id', 'product_title', 
        'sku', 'price', 'discount_percentage', 'quantity', 'subtotal'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
