<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityLogsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = ActivityLog::with('user');

        // Filtreleme
        if (!empty($this->filters['action'])) {
            $query->forAction($this->filters['action']);
        }

        if (!empty($this->filters['model_type'])) {
            $query->where('model_type', $this->filters['model_type']);
        }

        if (!empty($this->filters['user_id'])) {
            $query->forUser($this->filters['user_id']);
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        return $query->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kullanıcı',
            'İşlem',
            'Model Türü',
            'Model ID',
            'Açıklama',
            'IP Adresi',
            'Tarih'
        ];
    }

    public function map($log): array
    {
        return [
            $log->id,
            $log->user ? $log->user->name : 'Sistem',
            $log->action,
            $log->model_type,
            $log->model_id,
            $log->description,
            $log->ip_address,
            $log->created_at->format('d.m.Y H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
