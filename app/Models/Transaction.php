<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['invoice_number', 'customer_name', 'total_amount', 'transaction_date'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

}
