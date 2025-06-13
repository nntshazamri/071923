<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Farm;

class FarmController extends Controller
{
    /**
     * List all farms of the authenticated user.
     */
    
    public function index()
    {
        $user = Auth::user();
        // Eager-load plots for each farm
        $farms = $user->farms()->with('plots')->get();
        return view('farmdetails.index', compact('farms'));
    }

    /**
     * Show form to create a new farm.
     */
    public function create()
    {
        return view('farmdetails.create');
    }

    /**
     * Store a new farm and attach to user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'size'     => 'nullable|string|max:100', // if you added size
        ]);

        // Create farm
        $farm = Farm::create([
            'location' => $request->input('location'),
            // 'size'     => $request->input('size'),
        ]);

        // Attach to user
        Auth::user()->farms()->attach($farm->farmID);

        return redirect()->route('farms.index')
                         ->with('success', 'Farm created successfully.');
    }

    /**
     * Show details of a single farm, including its plots.
     */
    public function show(Farm $farm)
    {
        // Ensure the authenticated user owns this farm via pivot
        $user = Auth::user();
        if (! $user->farms()->where('farmID', $farm->farmID)->exists()) {
            abort(403);
        }

        // Eager-load plots
        $farm->load('plots');
        return view('farmdetails.show', compact('farm'));
    }

    /**
     * Show form to edit a farm.
     */
    public function edit(Farm $farm)
    {
        $user = Auth::user();
        if (! $user->farms()->where('farmID', $farm->farmID)->exists()) {
            abort(403);
        }
        return view('farmdetails.edit', compact('farm'));
    }

    /**
     * Update a farm.
     */
    public function update(Request $request, Farm $farm)
    {
        $user = Auth::user();
        if (! $user->farms()->where('farmID', $farm->farmID)->exists()) {
            abort(403);
        }

        $request->validate([
            'location' => 'required|string|max:255',
            'size'     => 'nullable|string|max:100', // if added
        ]);

        $farm->update([
            'location' => $request->input('location'),
            // 'size'     => $request->input('size'),
        ]);

        return redirect()->route('farms.index')
                         ->with('success', 'Farm updated successfully.');
    }

    /**
     * Delete a farm (and cascades delete its plots if FK ON DELETE CASCADE).
     */
    public function destroy(Farm $farm)
    {
        $user = Auth::user();
        if (! $user->farms()->where('farmID', $farm->farmID)->exists()) {
            abort(403);
        }

        // Detach pivot first
        $user->farms()->detach($farm->farmID);

        // Delete the farm; plots will be deleted if FK cascade is set
        $farm->delete();

        return redirect()->route('farms.index')
                         ->with('success', 'Farm deleted successfully.');
    }
}
