<?php

namespace App\Http\Controllers;

use App\Models\Attractions;
use App\Models\Areas;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttractionsController extends Controller
{
    public function index()
    {
        $attractions = Attractions::with('area')->orderBy('name')->get();
        $areas = Areas::orderBy('name')->get();
        
        return Inertia::render('Attractions/Index', [
            'attractions' => $attractions,
            'areas' => $areas
        ]);
    }

    public function create()
    {
        $areas = Areas::orderBy('name')->get();
        
        return Inertia::render('Attractions/Create', [
            'areas' => $areas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string|max:500',
        ]);

        Attractions::create([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'address' => $request->address,
        ]);

        return redirect()->route('attractions.index')
            ->with('success', 'Attraction created successfully.');
    }

    public function show(Attractions $attraction)
    {
        $attraction->load('area');
        
        return Inertia::render('Attractions/Show', [
            'attraction' => $attraction
        ]);
    }

    public function edit(Attractions $attraction)
    {
        $areas = Areas::orderBy('name')->get();
        
        return Inertia::render('Attractions/Edit', [
            'attraction' => $attraction,
            'areas' => $areas
        ]);
    }

    public function update(Request $request, Attractions $attraction)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string|max:500',
        ]);

        $attraction->update([
            'name' => $request->name,
            'area_id' => $request->area_id,
            'address' => $request->address,
        ]);

        return redirect()->route('attractions.index')
            ->with('success', 'Attraction updated successfully.');
    }

    public function destroy(Attractions $attraction)
    {
        $attraction->delete();

        return redirect()->route('attractions.index')
            ->with('success', 'Attraction deleted successfully.');
    }
}
