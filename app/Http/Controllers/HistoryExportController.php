<?php

namespace App\Http\Controllers;

use App\Exports\HistoryExport;
use App\Models\HistoryKependudukan;
use App\Models\User;
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

        $activeFilters = [];

        if ($request->filled('search')) {
            $activeFilters['Pencarian'] = $request->input('search');
        }

        if ($request->filled('filterPeristiwa')) {
            // Mapping untuk mengubah key menjadi teks yang mudah dibaca
            $opsiPeristiwa = [
                'Kelahiran' => 'Kelahiran',
                'Kematian' => 'Kematian',
                'Pendatang' => 'Pendatang',
                'Pindah' => 'Pindah',
            ];
            $activeFilters['Jenis Peristiwa'] = $opsiPeristiwa[$request->input('filterPeristiwa')] ?? $request->input('filterPeristiwa');
        }

        if ($request->filled('filterUser')) {
            $user = User::find($request->input('filterUser'));
            $activeFilters['Dicatat Oleh'] = $user ? $user->name : 'User Tidak Ditemukan';
        }

        if ($request->filled('filterTanggalMulai') || $request->filled('filterTanggalSelesai')) {
            $tglMulai = $request->input('filterTanggalMulai', '-');
            $tglSelesai = $request->input('filterTanggalSelesai', '-');
            $activeFilters['Rentang Tanggal'] = "$tglMulai s/d $tglSelesai";
        }

        $pdf = Pdf::loadView('history.pdf', [
            'histories' => $histories,
            'activeFilters' => $activeFilters
        ]);

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

        return Excel::download(new HistoryExport($histories), $fileName);
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
