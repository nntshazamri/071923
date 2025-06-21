<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crop;

class CropController extends Controller
{
    public function index()
    {
        $crops = Crop::all();
        return view('crops.index', compact('crops'));
    }

    public function create()
    {
        return view('crops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'optimal_moisture_min' => 'nullable|numeric',
            'optimal_moisture_max' => 'nullable|numeric',
            'optimal_temperature_min' => 'nullable|numeric',
            'optimal_temperature_max' => 'nullable|numeric',
            'optimal_humidity_min' => 'nullable|numeric',
            'optimal_humidity_max' => 'nullable|numeric',
            'optimal_light_min' => 'nullable|numeric',
            'optimal_light_max' => 'nullable|numeric',
        ]);

        Crop::create($request->all());

        return redirect()->route('crops.index')->with('success', 'Crop created.');
    }

    public function edit(Crop $crop)
    {
        return view('crops.edit', compact('crop'));
    }

    public function update(Request $request, Crop $crop)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'optimal_moisture_min' => 'nullable|numeric',
            'optimal_moisture_max' => 'nullable|numeric',
            'optimal_temperature_min' => 'nullable|numeric',
            'optimal_temperature_max' => 'nullable|numeric',
            'optimal_humidity_min' => 'nullable|numeric',
            'optimal_humidity_max' => 'nullable|numeric',
            'optimal_light_min' => 'nullable|numeric',
            'optimal_light_max' => 'nullable|numeric',
        ]);

        $crop->update($request->all());

        return redirect()->route('crops.index')->with('success', 'Crop updated.');
    }

    public function destroy(Crop $crop)
    {
        $crop->delete();
        return redirect()->route('crops.index')->with('success', 'Crop deleted.');
    }
}
