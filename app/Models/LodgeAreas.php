<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LodgeAreas extends Model
{
    use HasFactory;

    protected $primaryKey = 'lodge_id';

    protected $fillable = [
        'area',
        'total_rooms',
        'status',
        'available_rooms',
        'location',
    ];

    public function Users()
    {
        return $this->hasMany(User::class, 'lodge_id', 'lodge_id');
    }

    public function Images()
    {
        return $this->hasMany(LodgeAreasImages::class, 'lodge_id', 'lodge_id');
    }

    public function Rooms()
    {
        return $this->hasMany(Rooms::class, 'lodge_id', 'lodge_id');
    }

    public function Books()
    {
        return $this->hasMany(Books::class, 'lodge_id', 'lodge_id');
    }

    public function Bills()
    {
        return $this->hasMany(Bills::class, 'lodge_id', 'lodge_id');
    }

    public function DailyReports()
    {
        return $this->hasMany(DailyReports::class, 'lodge_id', 'lodge_id');
    }

    public function Events()
    {
        return $this->hasMany(Events::class, 'lodge_id', 'lodge_id');
    }

    public function MonthlyReports()
    {
        return $this->hasMany(MonthlyReports::class, 'lodge_id', 'lodge_id');
    }
}
