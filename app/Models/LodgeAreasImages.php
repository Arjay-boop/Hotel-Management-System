<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LodgeAreasImages extends Model
{
    use HasFactory;

    protected $primaryKey = 'img_id';

    protected $fillable = [
        'lodge_id',
        'img',
    ];

    public function LodgeArea()
    {
        return $this->belongsTo(LodgeAreas::class, 'lodge_id', 'lodge_id');
    }
}
