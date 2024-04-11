<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    protected $primaryKey = 'bill_id';

    protected $fillable = [
        'book_id',
        'user_id',
        'cust_id',
        'room_id',
        'lodge_id',
        'damage_charge',
        'total_amount',
        'status',
    ];

    public function Books()
    {
        return $this->belongsTo(Books::class, 'book_id', 'book_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

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
}
