<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'url',
        'method',
        'ip_address',
        'agent',
    ];

    /**
     * Relasi ke Model User (Many to One)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
