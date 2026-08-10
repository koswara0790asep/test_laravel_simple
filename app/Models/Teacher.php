<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;
    
    protected $table = 'teachers';
    protected $guarded = [];
    // protected $fillable = [
    //     'nip',
    //     'name',
    //     'birth_date',
    //     'address',
    //     'gender',
    //     'is_homeroom'
    // ];
}
