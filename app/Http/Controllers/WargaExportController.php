<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WargaExport;

class WargaExportController extends Controller
{
    /**
     * Membuat dan mengunduh file PDF berisi data warga yang telah difilter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Request $request)
    {
        // Mengambil data warga dengan filter yang diterapkan
        $wargas = $this->getFilteredQuery($request)->get();

        // Menyiapkan data filter untuk ditampilkan di laporan
        $filters = $request->only([
            'search',
            'filterJenisKelamin',
            'filterAgama',
            'filterUsiaMin',
            'filterUsiaMax',
            'filterPendidikan',
            'filterStatusPerkawinan',
        ]);

        // Data opsi untuk mengubah kunci menjadi label yang bisa dibaca
        $options = [
            'pendidikan' => config('options.pendidikan', []),
            'status_perkawinan' => config('options.status_perkawinan', []),
        ];

        // Memuat view PDF dengan data yang diperlukan
        $pdf = Pdf::loadView('warga.pdf', compact('wargas', 'filters', 'options'));

        // Mengatur orientasi kertas menjadi landscape untuk tabel yang lebar
        $pdf->setPaper('a4', 'landscape');

        // Mengunduh file PDF
        return $pdf->download('laporan-data-warga-' . date('Y-m-d') . '.pdf');
    }

    /**
     * -- METODE BARU UNTUK EKSPOR EXCEL --
     * Membuat dan mengunduh file Excel berisi data warga yang telah difilter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        // 1. Ambil data yang sudah difilter menggunakan metode yang sama
        $wargas = $this->getFilteredQuery($request)->get();

        // 2. Tentukan nama file
        $fileName = 'laporan-data-warga-' . date('Y-m-d') . '.xlsx';

        // 3. Panggil facade Excel untuk mengunduh file, menggunakan WargaExport class
        return Excel::download(new WargaExport($wargas), $fileName);
    }

    /**
     * Membuat query builder Warga dengan filter yang diterapkan dari request.
     * Logika ini diduplikasi dari Livewire component untuk konsistensi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getFilteredQuery(Request $request)
    {
        return Warga::query()
            ->when(
                $request->input('search'),
                fn($q, $search) =>
                $q->where(
                    fn($sq) =>
                    $sq->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhereHas('kartuKeluarga', fn($kq) => $kq->where('nomor_kk', 'like', "%{$search}%"))
                )
            )
            ->when($request->input('filterJenisKelamin'), fn($q, $jk) => $q->where('jenis_kelamin', $jk))
            ->when($request->input('filterAgama'), fn($q, $agama) => $q->where('agama', $agama))
            ->when($request->input('filterUsiaMin'), fn($q, $min) => $q->where('tanggal_lahir', '<=', Carbon::now()->subYears($min)))
            ->when($request->input('filterUsiaMax'), fn($q, $max) => $q->where('tanggal_lahir', '>=', Carbon::now()->subYears($max)))
            ->when($request->input('filterPendidikan'), fn($q, $pendidikan) => $q->where('pendidikan_terakhir', $pendidikan))
            ->when($request->input('filterStatusPerkawinan'), fn($q, $status) => $q->where('status_perkawinan', $status))
            ->with('kartuKeluarga'); // Eager load relasi untuk efisiensi
    }
}
