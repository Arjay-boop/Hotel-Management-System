<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReports extends Model
{
    use HasFactory;

    protected $primaryKey = 'month_id';

    protected $fillable = [
        'lodge_id',
        'report_date',
        'revenue',
        'occupancy_rate',
        'damage_rate',
        'average_rate',
        'total_bookings',
        'total_customers_by_gender',
        'total_rooms',
        'total_damage',
        'event_name',
    ];

    public function LodgeAreas()
    {
        return $this->belongsTo(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }
}
