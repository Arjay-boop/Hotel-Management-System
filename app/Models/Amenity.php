<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $primaryKey = 'amenity_id';

    protected $fillable = [
        'name',
        'price',
    ];

    public function Rooms()
    {
        return $this->belongsToMany(Rooms::class, 'pivots', 'amenity_id', 'room_id');
    }
}
