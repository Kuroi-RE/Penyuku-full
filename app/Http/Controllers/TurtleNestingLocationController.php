<?php

namespace App\Http\Controllers;

use App\Models\TurtleNestingLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurtleNestingLocationController extends Controller
{
    // List all nesting locations with matrix view
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        // Get all data for selected year
        $nestingData = TurtleNestingLocation::byYear($year)
            ->orderBy('month')
            ->get();

        // Beach locations
        $locations = [
            'SODONG',
            'SRANDIL',
            'WELAHAN WETAN',
            'WIDARAPAYUNG KULON',
            'SIDAYU',
            'WIDARAPAYUNG WETAN',
            'SIDAURIP',
            'PAGUBUGAN KULON',
            'PAGUBUGAN',
            'KARANGTAWANG',
            'KARANGPAKIS',
            'JETIS'
        ];

        // Months
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Create matrix data
        $matrixData = [];
        foreach ($months as $month) {
            $matrixData[$month] = [];
            foreach ($locations as $location) {
                $data = $nestingData->where('month', $month)
                    ->where('location_name', $location)
                    ->first();
                $matrixData[$month][$location] = $data ? $data->nesting_count : 0;
            }
        }

        // Calculate totals
        $locationTotals = [];
        foreach ($locations as $location) {
            $locationTotals[$location] = $nestingData->where('location_name', $location)
                ->sum('nesting_count');
        }

        $monthTotals = [];
        foreach ($months as $month) {
            $monthTotals[$month] = $nestingData->where('month', $month)
                ->sum('nesting_count');
        }

        $grandTotal = $nestingData->sum('nesting_count');

        // Available years for filter
        $years = TurtleNestingLocation::selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('turtle-eggs.locations.index', compact(
            'matrixData',
            'locations',
            'months',
            'locationTotals',
            'monthTotals',
            'grandTotal',
            'year',
            'years'
        ));
    }

    // Show bulk input form
    public function create()
    {
        $locations = [
            'SODONG',
            'SRANDIL',
            'WELAHAN WETAN',
            'WIDARAPAYUNG KULON',
            'SIDAYU',
            'WIDARAPAYUNG WETAN',
            'SIDAURIP',
            'PAGUBUGAN KULON',
            'PAGUBUGAN',
            'KARANGTAWANG',
            'KARANGPAKIS',
            'JETIS'
        ];

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('turtle-eggs.locations.create', compact('locations', 'months'));
    }

    // Store bulk data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'data' => 'required|array',
            'data.*.*' => 'required|integer|min:0'
        ]);

        $year = $validated['year'];
        $data = $validated['data'];

        foreach ($data as $month => $locations) {
            foreach ($locations as $location => $count) {
                // Check if data already exists
                $existing = TurtleNestingLocation::where([
                    'year' => $year,
                    'month' => $month,
                    'location_name' => $location
                ])->first();

                if ($existing) {
                    $existing->update([
                        'nesting_count' => $count,
                        'user_id' => Auth::id()
                    ]);
                } else {
                    TurtleNestingLocation::create([
                        'user_id' => Auth::id(),
                        'location_name' => $location,
                        'month' => $month,
                        'year' => $year,
                        'nesting_count' => $count
                    ]);
                }
            }
        }

        return redirect()->route('turtle-eggs.locations.index', ['year' => $year])
            ->with('success', 'Data wilayah peneluran berhasil disimpan!');
    }

    // Show edit form for specific entry
    public function edit(TurtleNestingLocation $location)
    {
        $locations = [
            'SODONG',
            'SRANDIL',
            'WELAHAN WETAN',
            'WIDARAPAYUNG KULON',
            'SIDAYU',
            'WIDARAPAYUNG WETAN',
            'SIDAURIP',
            'PAGUBUGAN KULON',
            'PAGUBUGAN',
            'KARANGTAWANG',
            'KARANGPAKIS',
            'JETIS'
        ];

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('turtle-eggs.locations.edit', compact('location', 'locations', 'months'));
    }

    // Update specific entry
    public function update(Request $request, TurtleNestingLocation $location)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:100',
            'month' => 'required|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
            'year' => 'required|integer|min:2000|max:2100',
            'nesting_count' => 'required|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $location->update($validated);

        return redirect()->route('turtle-eggs.locations.index', ['year' => $location->year])
            ->with('success', 'Data berhasil diupdate!');
    }

    // Delete specific entry
    public function destroy(TurtleNestingLocation $location)
    {
        $year = $location->year;
        $location->delete();

        return redirect()->route('turtle-eggs.locations.index', ['year' => $year])
            ->with('success', 'Data berhasil dihapus!');
    }
}

