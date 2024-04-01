<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReports extends Model
{
    use HasFactory;

    protected $primaryKey = 'daily_id';

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
    ];

    public function LodgeAreas()
    {
        return $this->belongsTo(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }

    public static function generateReport($reportType, $lodgeId, $startDate, $endDate)
    {
        $query = self::query()->whereBetween('report_date', [$startDate, $endDate]);

        if ($lodgeId !== 'all') {
            $query->where('lodge_id', $lodgeId);
        }

        switch ($reportType) {
            case 'revenue':
                $query->selectRaw('SUM(revenue) as total');
                break;
            case 'occupancy_rate':
                $query->selectRaw('AVG(occupancy_rate) as average');
                break;
            case 'damage_rate':
                $query->selectRaw('AVG(damage_rate) as average');
                break;
            case 'average_rate':
                $query->selectRaw('AVG(average_rate) as average');
                break;
            case 'total_bookings':
                $query->selectRaw('SUM(total_bookings) as total');
                break;
            case 'total_customers_by_gender':
                $query->selectRaw('SUM(total_customers_by_gender) as total');
                break;
            case 'total_rooms':
                $query->selectRaw('SUM(total_rooms) as total');
                break;
            case 'total_damage':
                $query->selectRaw('SUM(total_damage) as total');
                break;
            case 'all':
                // No specific report type, get all fields
                break;
            default:
                // Invalid report type
                return null;
        }

        return $query->first()->toArray();
    }
}
