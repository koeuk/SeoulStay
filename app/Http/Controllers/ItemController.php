<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Areas;
use App\Models\ItemType;
use App\Models\Amenities;
use App\Models\Attractions;
use App\Models\ItemAmenities;
use App\Models\ItemAttractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        $items = Items::with(['area', 'itemType', 'user'])->paginate(10);
        
        return Inertia::render('Items/Index', [
            'items' => $items
        ]);
    }

    public function create()
    {
        $areas = Areas::all();
        $itemTypes = ItemType::all();
        $amenities = Amenities::all();
        $attractions = Attractions::with('area')->get();
        
        return Inertia::render('Items/Create', [
            'areas' => $areas,
            'itemTypes' => $itemTypes,
            'amenities' => $amenities,
            'attractions' => $attractions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'item_type_id' => 'required|exists:item_types,id',
            'area_id' => 'required|exists:areas,id',
            'capacity' => 'required|integer|min:1',
            'number_of_beds' => 'required|integer|min:1',
            'number_of_bedrooms' => 'required|integer|min:1',
            'number_of_bathrooms' => 'required|integer|min:1',
            'approximate_address' => 'required|string',
            'exact_address' => 'required|string',
            'description' => 'required|string',
            'minimum_nights' => 'required|integer|min:1',
            'maximum_nights' => 'required|integer|min:1',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'attractions' => 'array',
            'attractions.*.id' => 'exists:attractions,id',
            'attractions.*.distance' => 'required|numeric|min:0',
            'attractions.*.duration_on_foot' => 'required|integer|min:0',
            'attractions.*.duration_by_car' => 'required|integer|min:0',
        ]);

        $item = Items::create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::id(),
            'title' => $request->title,
            'item_type_id' => $request->item_type_id,
            'area_id' => $request->area_id,
            'capacity' => $request->capacity,
            'number_of_beds' => $request->number_of_beds,
            'number_of_bedrooms' => $request->number_of_bedrooms,
            'number_of_bathrooms' => $request->number_of_bathrooms,
            'approximate_address' => $request->approximate_address,
            'exact_address' => $request->exact_address,
            'description' => $request->description,
            'minimum_nights' => $request->minimum_nights,
            'maximum_nights' => $request->maximum_nights,
            'attributes' => json_encode($request->get('attributes', [])),
        ]);

        // Sync amenities
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenityId) {
                ItemAmenities::create([
                    'uuid' => Str::uuid(),
                    'item_id' => $item->id,
                    'amenity_id' => $amenityId,
                ]);
            }
        }

        // Sync attractions with distances
        if ($request->has('attractions')) {
            foreach ($request->attractions as $attraction) {
                ItemAttractions::create([
                    'uuid' => Str::uuid(),
                    'item_id' => $item->id,
                    'attraction_id' => $attraction['id'],
                    'distance' => $attraction['distance'],
                    'duration_on_foot' => $attraction['duration_on_foot'],
                    'duration_by_car' => $attraction['duration_by_car'],
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Item created successfully!');
    }

    public function show(Items $item)
    {
        $item->load(['area', 'itemType', 'user', 'amenities', 'attractions']);
        
        return Inertia::render('Items/Show', [
            'item' => $item
        ]);
    }

    public function edit(Items $item)
    {
        $item->load(['amenities', 'attractions']);
        $areas = Areas::all();
        $itemTypes = ItemType::all();
        $amenities = Amenities::all();
        $attractions = Attractions::with('area')->get();
        
        return Inertia::render('Items/Edit', [
            'item' => $item,
            'areas' => $areas,
            'itemTypes' => $itemTypes,
            'amenities' => $amenities,
            'attractions' => $attractions,
        ]);
    }

    public function update(Request $request, Items $item)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'item_type_id' => 'required|exists:item_types,id',
            'area_id' => 'required|exists:areas,id',
            'capacity' => 'required|integer|min:1',
            'number_of_beds' => 'required|integer|min:1',
            'number_of_bedrooms' => 'required|integer|min:1',
            'number_of_bathrooms' => 'required|integer|min:1',
            'approximate_address' => 'required|string',
            'exact_address' => 'required|string',
            'description' => 'required|string',
            'minimum_nights' => 'required|integer|min:1',
            'maximum_nights' => 'required|integer|min:1',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
            'attractions' => 'array',
            'attractions.*.id' => 'exists:attractions,id',
            'attractions.*.distance' => 'required|numeric|min:0',
            'attractions.*.duration_on_foot' => 'required|integer|min:0',
            'attractions.*.duration_by_car' => 'required|integer|min:0',
        ]);

        $item->update([
            'title' => $request->title,
            'item_type_id' => $request->item_type_id,
            'area_id' => $request->area_id,
            'capacity' => $request->capacity,
            'number_of_beds' => $request->number_of_beds,
            'number_of_bedrooms' => $request->number_of_bedrooms,
            'number_of_bathrooms' => $request->number_of_bathrooms,
            'approximate_address' => $request->approximate_address,
            'exact_address' => $request->exact_address,
            'description' => $request->description,
            'minimum_nights' => $request->minimum_nights,
            'maximum_nights' => $request->maximum_nights,
            'attributes' => json_encode($request->get('attributes', [])),
        ]);

        // Sync amenities
        ItemAmenities::where('item_id', $item->id)->delete();
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenityId) {
                ItemAmenities::create([
                    'uuid' => Str::uuid(),
                    'item_id' => $item->id,
                    'amenity_id' => $amenityId,
                ]);
            }
        }

        // Sync attractions
        ItemAttractions::where('item_id', $item->id)->delete();
        if ($request->has('attractions')) {
            foreach ($request->attractions as $attraction) {
                ItemAttractions::create([
                    'uuid' => Str::uuid(),
                    'item_id' => $item->id,
                    'attraction_id' => $attraction['id'],
                    'distance' => $attraction['distance'],
                    'duration_on_foot' => $attraction['duration_on_foot'],
                    'duration_by_car' => $attraction['duration_by_car'],
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Item updated successfully!');
    }

    public function destroy(Items $item)
    {
        $item->delete();
        
        return redirect()->route('dashboard')->with('success', 'Item deleted successfully!');
    }
}