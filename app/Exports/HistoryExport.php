<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $histories;

    public function __construct($histories)
    {
        $this->histories = $histories;
    }

    public function collection()
    {
        return $this->histories;
    }

    public function headings(): array
    {
        return [
            'Nama Warga',
            'NIK',
            'Peristiwa',
            'Tanggal Peristiwa',
            'Detail',
            'Dicatat Oleh',
            'Waktu Dicatat',
        ];
    }

    public function map($history): array
    {
        return [
            $history->warga->nama_lengkap ?? '[Data Warga Dihapus]',
            "'" . ($history->warga->nik ?? '-'),
            $history->peristiwa,
            Carbon::parse($history->tanggal_peristiwa)->format('d-m-Y'),
            $history->detail_peristiwa,
            $history->creator->name ?? 'Sistem',
            $history->created_at->format('d-m-Y H:i'),
        ];
    }
}
