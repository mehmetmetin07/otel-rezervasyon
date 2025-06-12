<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomRequestController extends Controller
{
    /**
     * Tüm oda isteklerini listele
     */
    public function index()
    {
        $roomRequests = RoomRequest::with(['room', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('room-requests.index', compact('roomRequests'));
    }

    /**
     * Yeni istek oluşturma formunu göster
     */
    public function create(Request $request)
    {
        $rooms = Room::orderBy('room_number')->get();
        $roomId = $request->query('room_id');
        
        return view('room-requests.create', compact('rooms', 'roomId'));
    }

    /**
     * Yeni isteği kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'request_content' => 'required|string|min:5',
            'notes' => 'nullable|string',
        ]);
        
        $roomRequest = new RoomRequest($validated);
        $roomRequest->user_id = Auth::id();
        $roomRequest->status = 'pending';
        $roomRequest->save();
        
        return redirect()->route('room-requests.index')
            ->with('success', 'Oda isteği başarıyla oluşturuldu.');
    }

    /**
     * İstek detaylarını göster
     */
    public function show(string $id)
    {
        $roomRequest = RoomRequest::with(['room', 'user'])->findOrFail($id);
        
        return view('room-requests.show', compact('roomRequest'));
    }

    /**
     * İstek düzenleme formunu göster
     */
    public function edit(string $id)
    {
        $roomRequest = RoomRequest::findOrFail($id);
        $rooms = Room::orderBy('room_number')->get();
        
        return view('room-requests.edit', compact('roomRequest', 'rooms'));
    }

    /**
     * İsteği güncelle
     */
    public function update(Request $request, string $id)
    {
        $roomRequest = RoomRequest::findOrFail($id);
        
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'request_content' => 'required|string|min:5',
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string',
        ]);
        
        // Eğer durum tamamlandı olarak işaretlendiyse completed_at alanını güncelle
        if ($validated['status'] === 'completed' && $roomRequest->status !== 'completed') {
            $roomRequest->completed_at = now();
        }
        
        $roomRequest->update($validated);
        
        return redirect()->route('room-requests.show', $roomRequest->id)
            ->with('success', 'Oda isteği başarıyla güncellendi.');
    }

    /**
     * İsteği sil
     */
    public function destroy(string $id)
    {
        $roomRequest = RoomRequest::findOrFail($id);
        $roomRequest->delete();
        
        return redirect()->route('room-requests.index')
            ->with('success', 'Oda isteği başarıyla silindi.');
    }
    
    /**
     * İstek durumunu güncelle (AJAX)
     */
    public function updateStatus(Request $request, string $id)
    {
        $roomRequest = RoomRequest::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);
        
        $roomRequest->updateStatus($validated['status']);
        
        return response()->json([
            'success' => true,
            'message' => 'Durum başarıyla güncellendi.',
            'status' => $roomRequest->status,
            'completed_at' => $roomRequest->completed_at ? $roomRequest->completed_at->format('d.m.Y H:i') : null
        ]);
    }
    
    /**
     * Belirli bir odaya ait istekleri listele
     */
    public function roomRequests(string $roomId)
    {
        $room = Room::findOrFail($roomId);
        $roomRequests = $room->roomRequests()->with('user')->orderBy('created_at', 'desc')->get();
        
        return view('room-requests.room', compact('room', 'roomRequests'));
    }
}
