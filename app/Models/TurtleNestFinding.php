<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurtleNestFinding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'finding_date',
        'nest_code',
        'egg_count',
        'location',
        'estimated_hatching_date',
        'hatched_count',
        'hatching_percentage',
        'status',
        'notes'
    ];

    protected $casts = [
        'finding_date' => 'date',
        'estimated_hatching_date' => 'date',
        'hatching_percentage' => 'decimal:2'
    ];

    // Relationship dengan User (admin penangkaran)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto-calculate hatching percentage
    public function calculateHatchingPercentage()
    {
        if ($this->egg_count > 0) {
            $this->hatching_percentage = ($this->hatched_count / $this->egg_count) * 100;
            $this->save();
        }
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeByYear($query, $year)
    {
        return $query->whereYear('finding_date', $year);
    }

    // Scope untuk filter berdasarkan lokasi
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}