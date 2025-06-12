<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationCheckController extends Controller
{
    /**
     * Oda çakışması kontrolü
     * AJAX ile çağrılacak endpoint
     */
    public function checkRoomConflict(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'room_id' => 'required|exists:rooms,id',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
                'reservation_id' => 'nullable|exists:reservations,id' // Güncelleme için
            ]);

            $room = Room::findOrFail($validated['room_id']);
            $checkIn = Carbon::parse($validated['check_in']);
            $checkOut = Carbon::parse($validated['check_out']);

            // Çakışan rezervasyon var mı kontrol et
            $query = Reservation::where('room_id', $validated['room_id'])
                ->where(function ($query) use ($checkIn, $checkOut) {
                    $query->whereBetween('check_in', [$checkIn, $checkOut])
                        ->orWhereBetween('check_out', [$checkIn, $checkOut])
                        ->orWhere(function ($q) use ($checkIn, $checkOut) {
                            $q->where('check_in', '<=', $checkIn)
                              ->where('check_out', '>=', $checkOut);
                        });
                })
                ->where('status', '!=', 'cancelled');

            // Eğer güncelleme işlemiyse, mevcut rezervasyonu hariç tut
            if (isset($validated['reservation_id'])) {
                $query->where('id', '!=', $validated['reservation_id']);
            }

            $conflictingReservation = $query->first();

            if ($conflictingReservation) {
                return response()->json([
                    'conflict' => true,
                    'room_number' => $room->room_number ?? $room->number,
                    'conflict_dates' => $conflictingReservation->check_in->format('d.m.Y') . ' - ' . $conflictingReservation->check_out->format('d.m.Y'),
                    'reservation_id' => $conflictingReservation->id
                ]);
            }

            return response()->json([
                'conflict' => false,
                'room_number' => $room->room_number ?? $room->number
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Çakışma kontrolü sırasında hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
}
