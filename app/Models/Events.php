<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'name',
        'lodge_id',
        'description',
        'start_date',
        'end_date',
    ];

    public function DailyReports()
    {
        return $this->belongsToMany(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }

}
