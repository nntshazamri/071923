<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Farm;
use App\Models\Plot;

class PlotController extends Controller
{
    /**
     * Show form to create a new plot under a specific farm.
     */
   public function create(Farm $farm)
    {
    $user = Auth::user();
    
    if (! $user->farms()->where('farms.farmID', $farm->farmID)->exists()) {
        abort(403);
    }

    return view('farmdetails.plots.create', compact('farm'));
    }

    /**
     * Store a new plot for the given farm.
     */
   public function store(Request $request, Farm $farm)
    {
    $user = Auth::user();
    
    // Fix ambiguous column name by specifying table
    if (! $user->farms()->where('farms.farmID', $farm->farmID)->exists()) {
        abort(403);
    }

    $request->validate([
        'name'           => 'nullable|string|max:100',
        'min_latitude'   => 'required|numeric',
        'max_latitude'   => 'required|numeric|gte:min_latitude',
        'min_longitude'  => 'required|numeric',
        'max_longitude'  => 'required|numeric|gte:min_longitude',
    ]);

    Plot::create([
        'farmID'        => $farm->farmID,
        'name'          => $request->input('name'),
        'min_latitude'  => $request->input('min_latitude'),
        'max_latitude'  => $request->input('max_latitude'),
        'min_longitude' => $request->input('min_longitude'),
        'max_longitude' => $request->input('max_longitude'),
    ]);

    return redirect()->route('farms.show', $farm->farmID)
                     ->with('success', 'Plot created successfully.');
    }


    /**
     * Show form to edit a plot.
     */
    public function edit(Farm $farm, Plot $plot)
    {
    $user = Auth::user();

    // Fix ambiguous column by specifying farms.farmID
    if (! $user->farms()->where('farms.farmID', $farm->farmID)->exists()) {
        abort(403);
    }

    return view('farmdetails.plots.edit', compact('farm', 'plot'));
    }


    /**
     * Update a plot.
     */
    public function update(Request $request, Farm $farm, Plot $plot)
    {
        $user = Auth::user();
        if (! $user->farms()->where('farms.farmID', $farm->farmID)->exists()) {
            abort(403);
        }
        if ($plot->farmID !== $farm->farmID) {
            abort(404);
        }
        $request->validate([
            'name'           => 'nullable|string|max:100',
            'min_latitude'   => 'required|numeric',
            'max_latitude'   => 'required|numeric|gte:min_latitude',
            'min_longitude'  => 'required|numeric',
            'max_longitude'  => 'required|numeric|gte:min_longitude',
        ]);

        $plot->update([
            'name'          => $request->input('name'),
            'min_latitude'  => $request->input('min_latitude'),
            'max_latitude'  => $request->input('max_latitude'),
            'min_longitude' => $request->input('min_longitude'),
            'max_longitude' => $request->input('max_longitude'),
        ]);

        return redirect()->route('farms.show', $farm->farmID)
                         ->with('success', 'Plot updated successfully.');
    }

    /**
     * Delete a plot.
     */
    public function destroy(Farm $farm, Plot $plot)
    {
        $user = Auth::user();
        if (! $user->farms()->where('farms.farmID', $farm->farmID)->exists()) {
            abort(403);
        }
        if ($plot->farmID !== $farm->farmID) {
            abort(404);
        }

        $plot->delete();

        return redirect()->route('farms.show', $farm->farmID)
                         ->with('success', 'Plot deleted successfully.');
    }
}
