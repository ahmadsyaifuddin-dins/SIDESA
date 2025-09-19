<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Kependudukan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 6px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Riwayat Kependudukan</h1>
        <p>Desa Anjir Muara Kota Tengah</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Warga</th>
                <th>NIK</th>
                <th>Peristiwa</th>
                <th>Tgl Peristiwa</th>
                <th>Detail</th>
                <th>Dicatat Oleh</th>
                <th>Waktu Dicatat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td>{{ $history->warga->nama_lengkap ?? '[Data Dihapus]' }}</td>
                    <td>{{ $history->warga->nik ?? '-' }}</td>
                    <td>{{ $history->peristiwa }}</td>
                    <td>{{ \Carbon\Carbon::parse($history->tanggal_peristiwa)->format('d-m-Y') }}</td>
                    <td>{{ $history->detail_peristiwa }}</td>
                    <td>{{ $history->creator->name ?? 'Sistem' }}</td>
                    <td>{{ $history->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data yang cocok dengan filter yang diterapkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
