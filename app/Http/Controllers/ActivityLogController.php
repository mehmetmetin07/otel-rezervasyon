<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
        /**
     * Aktivite loglarını listele
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filtreleme
        $action = $request->get('action');
        $modelType = $request->get('model_type');
        $userId = $request->get('user_id');
        $search = $request->get('search');
        $export = $request->get('export');

        if ($action) {
            $query->forAction($action);
        }

        if ($modelType) {
            $query->where('model_type', $modelType);
        }

        if ($userId) {
            $query->forUser($userId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

                // Excel dışa aktarma (CSV formatında)
        if ($export === 'excel') {
            // Filtrelenmiş verileri al
            $logsData = $query->get();

            // CSV başlıkları
            $headers = [
                'ID',
                'Kullanıcı',
                'Görev',
                'İşlem',
                'Model Türü',
                'Model ID',
                'Açıklama',
                'IP Adresi',
                'Tarih'
            ];

            // CSV içeriğini oluştur
            $callback = function() use ($logsData, $headers) {
                $file = fopen('php://output', 'w');

                // UTF-8 BOM ekle (Excel'de Türkçe karakterleri düzgün göstermek için)
                fputs($file, "\xEF\xBB\xBF");

                // Başlıkları yaz
                fputcsv($file, $headers);

                // Verileri yaz
                foreach ($logsData as $log) {
                    fputcsv($file, [
                        $log->id,
                        $log->user ? $log->user->name : 'Sistem',
                        $log->user && $log->user->role ? $log->user->role->name : '-',
                        $log->action,
                        $log->model_type,
                        $log->model_id,
                        $log->description ?? '-',
                        $log->ip_address ?? '-',
                        $log->created_at->format('d.m.Y H:i:s')
                    ]);
                }

                fclose($file);
            };

            // CSV dosyasını indir
            $filename = 'aktivite_loglari_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            return response()->stream($callback, 200, $headers);
        }

        $activityLogs = $query->orderByDesc('created_at')->paginate(15);
        $uniqueActions = ActivityLog::distinct()->pluck('action');
        $uniqueModelTypes = ActivityLog::distinct()->pluck('model_type');

        return view('activity_logs.index', compact('activityLogs', 'uniqueActions', 'uniqueModelTypes', 'action', 'modelType', 'userId', 'search'));
    }

    /**
     * Günlük detayını göster
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return response()->json($activityLog);
    }

    /**
     * Günlük kaydını sil
     */
    public function destroy(ActivityLog $activityLog)
    {
        try {
            $activityLog->delete();
            return response()->json(['success' => true, 'message' => 'Günlük kaydı başarıyla silindi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Silme işlemi başarısız oldu.'], 500);
        }
    }

    /**
     * Tüm günlük kayıtlarını temizle
     */
    public function clear()
    {
        try {
            ActivityLog::truncate();
            return response()->json(['success' => true, 'message' => 'Tüm günlük kayıtları başarıyla temizlendi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Temizleme işlemi başarısız oldu.'], 500);
        }
    }
}
