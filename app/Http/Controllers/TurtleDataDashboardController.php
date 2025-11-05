<?php

namespace App\Http\Controllers;

use App\Models\TurtleNestFinding;
use App\Models\TurtleNestingLocation;
use Illuminate\Http\Request;

class TurtleDataDashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));

        // Statistics from findings
        $totalNests = TurtleNestFinding::byYear($year)->count();
        $totalEggs = TurtleNestFinding::byYear($year)->sum('egg_count');
        $totalHatched = TurtleNestFinding::byYear($year)->sum('hatched_count');
        $hatchingRate = $totalEggs > 0 ? round(($totalHatched / $totalEggs) * 100, 2) : 0;

        // Findings by location
        $findingsByLocation = TurtleNestFinding::byYear($year)
            ->selectRaw('location, COUNT(*) as count, SUM(egg_count) as total_eggs, SUM(hatched_count) as total_hatched')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->get();

        // Nesting locations data
        $nestingLocations = TurtleNestingLocation::byYear($year)
            ->selectRaw('location_name, SUM(nesting_count) as total')
            ->groupBy('location_name')
            ->orderBy('total', 'desc')
            ->get();

        // Monthly trends
        $monthlyData = TurtleNestFinding::byYear($year)
            ->selectRaw('MONTH(finding_date) as month, COUNT(*) as count, SUM(egg_count) as eggs, SUM(hatched_count) as hatched')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent findings
        $recentFindings = TurtleNestFinding::byYear($year)
            ->orderBy('finding_date', 'desc')
            ->take(10)
            ->get();

        // Available years
        $years = TurtleNestFinding::selectRaw('YEAR(finding_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        if ($years->isEmpty()) {
            $years = collect([date('Y')]);
        }

        return view('turtle-data.dashboard', compact(
            'year',
            'years',
            'totalNests',
            'totalEggs',
            'totalHatched',
            'hatchingRate',
            'findingsByLocation',
            'nestingLocations',
            'monthlyData',
            'recentFindings'
        ));
    }
}

