<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::withCount(['rooms', 'rooms as available_rooms' => function ($query) {
            $query->where('status', 'available');
        }])->orderBy('name')->paginate(10);
        
        return view('room-types.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('room-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
        ]);
        
        RoomType::create($validated);
        
        return redirect()->route('room-types.index')
            ->with('success', 'Oda tipi başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        $roomType->load(['rooms' => function($query) {
            $query->orderBy('room_number');
        }]);
        
        $roomType->rooms_count = $roomType->rooms->count();
        $roomType->available_rooms_count = $roomType->rooms->where('status', 'available')->count();
        
        return view('room-types.show', compact('roomType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:room_types,name,' . $roomType->id,
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:10',
            'base_price' => 'required|numeric|min:0',
        ]);
        
        $roomType->update($validated);
        
        return redirect()->route('room-types.show', $roomType)
            ->with('success', 'Oda tipi başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        // İlişkili odaları da sil
        $roomType->rooms()->delete();
        
        // Oda tipini sil
        $roomType->delete();
        
        return redirect()->route('room-types.index')
            ->with('success', 'Oda tipi ve ilişkili tüm odalar başarıyla silindi.');
    }
}
