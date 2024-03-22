<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'cust_id';

    protected $fillable = [
        'user_id',
        'address',
    ];

    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function Books()
    {
        return $this->hasMany(Books::class, 'cust_id', 'cust_id');
    }

    public function Bills()
    {
        return $this->hasOne(Bills::class, 'cust_id', 'cust_id');
    }
}
