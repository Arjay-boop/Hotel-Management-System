<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';

    protected $fillable = [
        'cust_id',
        'room_id',
        'lodge_id',
        'start_date',
        'end_date'
    ];

    public function Customers()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    public function Rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }

    public function LodgeAreas()
    {
        return $this->belongsTo(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }

    public function Bills()
    {
        return $this->hasOne(Bills::class, 'book_id', 'book_id');
    }
}
