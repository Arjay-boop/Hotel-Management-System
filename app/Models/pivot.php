<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pivot extends Model
{
    use HasFactory;

    protected $table = "pivot";
    public $timestamp = false;

    protected $fillable = [
        'room_id',
        'amenity_id',
    ];

    public function Rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }

    public function Amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id', 'amenity_id');
    }

}
