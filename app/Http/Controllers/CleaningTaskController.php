<?php

namespace App\Http\Controllers;

use App\Models\CleaningTask;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CleaningTaskController extends Controller
{
    /**
     * CleaningTaskController constructor.
     */
    public function __construct()
    {
        // Yetkilendirme kontrolleri kaldırıldı
        // $this->authorizeResource(CleaningTask::class, 'cleaningTask');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $date = $request->get('date');
        $search = $request->get('search');
        $user = Auth::user();

        $query = CleaningTask::with(['room.roomType', 'user']);

        // Temizlik görevlileri sadece kendi görevlerini görür
        if ($user->isCleaner()) {
            $query->where('user_id', $user->id);
        }

        // Durum filtreleme
        if ($status) {
            $query->where('status', $status);
        }

        // Tarih filtreleme
        if ($date) {
            $date = Carbon::parse($date);
            $query->whereDate('scheduled_at', $date);
        }
        
        // Arama filtreleme
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('room', function($q) use ($search) {
                    $q->where('room_number', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $cleaningTasks = $query->orderBy('scheduled_at', 'desc')->paginate(10);

        return view('cleaning-tasks.index', compact('cleaningTasks', 'status', 'date', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Tüm odaları göster
        $rooms = Room::orderBy('room_number')->get();

        // Temizlik görevlileri
        $cleaners = User::whereHas('role', function ($query) {
            $query->where('name', 'Cleaner');
        })->get();

        return view('cleaning-tasks.create', compact('rooms', 'cleaners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'nullable|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Tarih ve saati birleştir
        $scheduledAt = $validated['scheduled_date'] . ' ' . $validated['scheduled_time'];

        // Temizlik görevi oluştur
        $cleaningTask = new CleaningTask([
            'room_id' => $validated['room_id'],
            'user_id' => $validated['user_id'] ?? null,
            'scheduled_at' => $scheduledAt,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $cleaningTask->save();

        // Odanın durumunu güncelle
        $room = Room::findOrFail($validated['room_id']);
        $room->updateStatus('cleaning');

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Temizlik görevi başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CleaningTask $cleaningTask): View
    {
        $cleaningTask->load(['room', 'user']);

        // Değişken adını view'daki ile uyumlu hale getiriyoruz
        $task = $cleaningTask;

        return view('cleaning-tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CleaningTask $cleaningTask): View
    {
        // Temizlik için uygun odalar (mevcut oda + boş veya temizlik bekleyen odalar)
        $availableRooms = Room::whereIn('status', ['available', 'cleaning'])
            ->orderBy('room_number')
            ->get();

        $currentRoom = Room::findOrFail($cleaningTask->room_id);
        $rooms = $availableRooms->push($currentRoom)->unique('id');

        // Temizlik görevlileri
        $cleaners = User::whereHas('role', function ($query) {
            $query->where('name', 'Cleaner');
        })->get();

        return view('cleaning-tasks.edit', compact('cleaningTask', 'rooms', 'cleaners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CleaningTask $cleaningTask): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Oda değiştiriliyorsa
        if ($validated['room_id'] != $cleaningTask->room_id) {
            // Eski odanın durumunu güncelle
            $oldRoom = Room::findOrFail($cleaningTask->room_id);
            $oldRoom->updateStatus('available');

            // Yeni odanın durumunu güncelle
            $newRoom = Room::findOrFail($validated['room_id']);
            $newRoom->updateStatus('cleaning');
        }

        $cleaningTask->update($validated);

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Temizlik görevi başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CleaningTask $cleaningTask): RedirectResponse
    {
        // Görevi iptal et
        $cleaningTask->cancel();

        // Odanın durumunu güncelle
        $room = Room::findOrFail($cleaningTask->room_id);
        $room->updateStatus('available');

        return redirect()->route('cleaning-tasks.index')
            ->with('success', 'Temizlik görevi başarıyla iptal edildi.');
    }

    /**
     * Temizlik görevini tamamlandı olarak işaretle
     */
    public function complete(Request $request, CleaningTask $cleaningTask): RedirectResponse
    {
        // Yetkilendirme kontrollerini kaldırdık
        // $this->authorize('complete', $cleaningTask);

        $cleaningTask->complete(Auth::id());

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Temizlik görevi başarıyla tamamlandı.');
    }

    /**
     * Temizlik görevini devam ediyor olarak işaretle
     */
    public function inProgress(CleaningTask $cleaningTask): RedirectResponse
    {
        // Yetkilendirme kontrollerini kaldırdık
        // $this->authorize('update', $cleaningTask);

        $cleaningTask->status = 'in_progress';
        $cleaningTask->started_at = now();
        $cleaningTask->save();

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Temizlik görevi başlatıldı ve durumu güncellendi.');
    }

    /**
     * Temizlik görevini belirli bir temizlik görevlisine ata
     */
    public function assign(Request $request, CleaningTask $cleaningTask): RedirectResponse
    {
        // Yetkilendirme kontrollerini kaldırdık
        // $this->authorize('assign', $cleaningTask);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $cleaningTask->user_id = $validated['user_id'];
        $cleaningTask->save();

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Temizlik görevi başarıyla atandı.');
    }

    /**
     * Temizlik sonrası odayı boş olarak işaretle
     */
    public function verifyRoom(CleaningTask $cleaningTask): RedirectResponse
    {
        // Yetkilendirme kontrollerini kaldırdık
        // $this->authorize('update', $cleaningTask);

        // Odayı kullanılabilir olarak işaretle
        $room = Room::findOrFail($cleaningTask->room_id);
        $room->updateStatus('available');

        return redirect()->route('cleaning-tasks.show', $cleaningTask)
            ->with('success', 'Oda başarıyla boş olarak işaretlendi.');
    }
}
