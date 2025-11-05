<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurtleEggLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'logger_user_id',
        'species',
        'nest_location',
        'date_found',
        'quantity_found',
        'estimated_hatch_date',
        'quantity_hatched',
        'notes',
    ];

    protected $casts = [
        'date_found' => 'date',
        'estimated_hatch_date' => 'date',
    ];

    public function logger()
    {
        return $this->belongsTo(User::class, 'logger_user_id');
    }
}