<?php

namespace App\Http\Controllers;

use App\Models\Amenities;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AmenitiesController extends Controller
{
    public function index()
    {
        $amenities = Amenities::orderBy('name')->get();
        
        return Inertia::render('Amenities/Index', [
            'amenities' => $amenities
        ]);
    }

    public function create()
    {
        return Inertia::render('Amenities/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
            'icon_name' => 'nullable|string|max:255',
        ]);

        Amenities::create([
            'name' => $request->name,
            'icon_name' => $request->icon_name,
        ]);

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity created successfully.');
    }

    public function show(Amenities $amenity)
    {
        return Inertia::render('Amenities/Show', [
            'amenity' => $amenity
        ]);
    }

    public function edit(Amenities $amenity)
    {
        return Inertia::render('Amenities/Edit', [
            'amenity' => $amenity
        ]);
    }

    public function update(Request $request, Amenities $amenity)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
            'icon_name' => 'nullable|string|max:255',
        ]);

        $amenity->update([
            'name' => $request->name,
            'icon_name' => $request->icon_name,
        ]);

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenities $amenity)
    {
        $amenity->delete();

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity deleted successfully.');
    }
}
