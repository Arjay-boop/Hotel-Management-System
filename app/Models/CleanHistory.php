<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleanHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'clean_id';

    protected $fillable = [
        'room_id',
        'user_id',
        'clean_date',
    ];

    public function Rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id', 'room_id');
    }

    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
