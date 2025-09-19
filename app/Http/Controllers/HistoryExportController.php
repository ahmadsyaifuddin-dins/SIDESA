<?php

namespace App\Http\Controllers;

use App\Exports\HistoryExport;
use App\Models\HistoryKependudukan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HistoryExportController extends Controller
{
    /**
     * Membuat dan mengunduh file PDF.
     */
    public function exportPdf(Request $request)
    {
        $histories = $this->getFilteredQuery($request)->get();
        $filters = $request->all();
        
        $pdf = Pdf::loadView('history.pdf', compact('histories', 'filters'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-histori-kependudukan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Membuat dan mengunduh file Excel.
     */
    public function exportExcel(Request $request)
    {
        $histories = $this->getFilteredQuery($request)->get();
        $fileName = 'laporan-histori-kependudukan-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new HistoryKependudukan($histories), $fileName);
    }

    /**
     * Metode terpusat untuk membangun query berdasarkan filter dari request.
     */
    private function getFilteredQuery(Request $request)
    {
        return HistoryKependudukan::query()
            ->with(['warga', 'creator'])
            ->when($request->input('search'), function ($query, $search) {
                $query->whereHas('warga', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($request->input('filterPeristiwa'), fn($q, $p) => $q->where('peristiwa', $p))
            ->when($request->input('filterUser'), fn($q, $u) => $q->where('created_by', $u))
            ->when($request->input('filterTanggalMulai'), fn($q, $t) => $q->whereDate('tanggal_peristiwa', '>=', $t))
            ->when($request->input('filterTanggalSelesai'), fn($q, $t) => $q->whereDate('tanggal_peristiwa', '<=', $t))
            ->latest();
    }
}
