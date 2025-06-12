<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservationsExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $query = Reservation::with(['customer', 'room', 'room.roomType']);

        // Filtreleri uygula
        if (isset($this->filters['status']) && $this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['start_date']) && $this->filters['start_date']) {
            $query->where('check_in_date', '>=', $this->filters['start_date']);
        }

        if (isset($this->filters['end_date']) && $this->filters['end_date']) {
            $query->where('check_out_date', '<=', $this->filters['end_date']);
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();

        return view('exports.reservations', [
            'reservations' => $reservations
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rezervasyonlar';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Başlık satırı için stil
            1 => ['font' => ['bold' => true]],
        ];
    }
}
