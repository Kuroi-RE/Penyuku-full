<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurtleNestingLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_name',
        'month',
        'year',
        'nesting_count',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'nesting_count' => 'integer'
    ];

    // Relationship dengan User (admin penangkaran)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // Scope untuk filter berdasarkan bulan
    public function scopeByMonth($query, $month)
    {
        return $query->where('month', $month);
    }

    // Scope untuk filter berdasarkan lokasi
    public function scopeByLocation($query, $location)
    {
        return $query->where('location_name', $location);
    }

    // Get total nesting by year
    public static function getTotalByYear($year)
    {
        return self::byYear($year)->sum('nesting_count');
    }

    // Get data by location for chart
    public static function getDataByLocation($year)
    {
        return self::byYear($year)
            ->selectRaw('location_name, SUM(nesting_count) as total')
            ->groupBy('location_name')
            ->orderBy('total', 'desc')
            ->get();
    }
}