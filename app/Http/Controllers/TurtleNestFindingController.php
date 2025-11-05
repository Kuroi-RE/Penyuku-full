<?php

namespace App\Http\Controllers;

use App\Models\TurtleNestFinding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurtleNestFindingController extends Controller
{
    // List all findings
    public function index(Request $request)
    {
        $query = TurtleNestFinding::with('user')->orderBy('finding_date', 'desc');

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by location
        if ($request->has('location') && $request->location) {
            $query->byLocation($request->location);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        $findings = $query->paginate(15);

        // Get unique years and locations for filters
        $years = TurtleNestFinding::selectRaw('YEAR(finding_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $locations = TurtleNestFinding::select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        // Statistics
        $totalEggs = TurtleNestFinding::sum('egg_count');
        $totalHatched = TurtleNestFinding::sum('hatched_count');
        $averageHatchingRate = $totalEggs > 0 ? ($totalHatched / $totalEggs) * 100 : 0;
        $totalNests = TurtleNestFinding::count();

        return view('turtle-eggs.findings.index', compact(
            'findings',
            'years',
            'locations',
            'totalEggs',
            'totalHatched',
            'averageHatchingRate',
            'totalNests'
        ));
    }

    // Show create form
    public function create()
    {
        // List of beach locations in Cilacap
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
            'JETIS',
            'GLEMPANGPASIR'
        ];

        return view('turtle-eggs.findings.create', compact('locations'));
    }

    // Store new finding
    public function store(Request $request)
    {
        $validated = $request->validate([
            'finding_date' => 'required|date',
            'nest_code' => 'nullable|string|max:50',
            'egg_count' => 'required|integer|min:0',
            'location' => 'required|string|max:100',
            'estimated_hatching_date' => 'nullable|date|after:finding_date',
            'hatched_count' => 'nullable|integer|min:0',
            'status' => 'required|in:monitoring,hatched,taken_by_fisherman',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();

        // Calculate hatching percentage if hatched_count is provided
        if ($request->has('hatched_count') && $validated['egg_count'] > 0) {
            $validated['hatching_percentage'] = ($validated['hatched_count'] / $validated['egg_count']) * 100;
        }

        TurtleNestFinding::create($validated);

        return redirect()->route('turtle-eggs.findings.index')
            ->with('success', 'Data temuan sarang berhasil ditambahkan!');
    }

    // Show single finding
    public function show(TurtleNestFinding $finding)
    {
        $finding->load('user');
        return view('turtle-eggs.findings.show', compact('finding'));
    }

    // Show edit form
    public function edit(TurtleNestFinding $finding)
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
            'JETIS',
            'GLEMPANGPASIR'
        ];

        return view('turtle-eggs.findings.edit', compact('finding', 'locations'));
    }

    // Update finding
    public function update(Request $request, TurtleNestFinding $finding)
    {
        $validated = $request->validate([
            'finding_date' => 'required|date',
            'nest_code' => 'nullable|string|max:50',
            'egg_count' => 'required|integer|min:0',
            'location' => 'required|string|max:100',
            'estimated_hatching_date' => 'nullable|date|after:finding_date',
            'hatched_count' => 'nullable|integer|min:0',
            'status' => 'required|in:monitoring,hatched,taken_by_fisherman',
            'notes' => 'nullable|string'
        ]);

        // Recalculate hatching percentage
        if ($request->has('hatched_count') && $validated['egg_count'] > 0) {
            $validated['hatching_percentage'] = ($validated['hatched_count'] / $validated['egg_count']) * 100;
        }

        $finding->update($validated);

        return redirect()->route('turtle-eggs.findings.index')
            ->with('success', 'Data temuan sarang berhasil diupdate!');
    }

    // Delete finding
    public function destroy(TurtleNestFinding $finding)
    {
        $finding->delete();

        return redirect()->route('turtle-eggs.findings.index')
            ->with('success', 'Data temuan sarang berhasil dihapus!');
    }
}
