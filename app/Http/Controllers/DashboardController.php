<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Areas;
use App\Models\ItemType;
use App\Models\Attractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all items with relationships for traveler tab
        $allItems = Items::with(['area', 'itemType', 'user', 'amenities', 'attractions'])
            ->where('user_id', $user->id)
            ->get();
        
        // Get user's own items for owner/manager tab
        $userItems = Items::with(['area', 'itemType', 'amenities', 'attractions'])
            ->where('user_id', $user->id)
            ->get();
        
        return Inertia::render('Dashboard', [
            'items' => $allItems,
            'userItems' => $userItems,
            'auth' => [
                'user' => $user
            ]
        ]);
    }
    
    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $tab = $request->get('tab', 'traveler');
        $user = Auth::user();
        
        $query = Items::with(['area', 'itemType', 'user'])
            ->when($search, function ($q) use ($search) {
                return $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('area', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('attractions', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
            
        if ($tab === 'owner') {
            $query->where('user_id', $user->id);
        }
        
        $items = $query->get();
        
        return response()->json([
            'items' => $items,
            'count' => $items->count(),
        ]);
    }
}