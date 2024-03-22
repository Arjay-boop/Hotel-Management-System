<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'lodge_id',
        'room_no',
        'room_type',
        'bed_type',
        'occupants',
        'status',
        'size',
        'price',
        'description'
    ];

    public function LodgeAreas()
    {
        return $this->belongsTo(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }

    public function Images()
    {
        return $this->hasMany(RoomImages::class, 'room_id', 'room_id');
    }

    public function Amenity()
    {
        return $this->belongsToMany(Amenity::class, 'pivots', 'room_id', 'amenity_id');
    }

    public function Books()
    {
        return $this->hasMany(Books::class, 'room_id', 'room_id');
    }

    public function Bills()
    {
        return $this->hasMany(Bills::class, 'room_id', 'room_id');
    }

    public function Rating()
    {
        return $this->hasMany(Ratings::class, 'room_id', 'room_id');
    }

    public function Cleaners()
    {
        return $this->hasMany(CleanHistory::class, 'room_id', 'room_id');
    }
}
