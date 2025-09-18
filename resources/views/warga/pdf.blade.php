<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Warga</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .filter-info {
            margin-bottom: 15px;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
            font-size: 9px;
        }
        .filter-info strong {
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Laporan Data Warga</h1>
            <p>Sistem Informasi Desa (SIDESA) Anjir Muara Kota Tengah</p>
            <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        @if(array_filter($filters))
        <div class="filter-info">
            <strong>Filter Aktif:</strong><br>
            @foreach($filters as $key => $value)
                @if($value)
                    <strong>
                        @switch($key)
                            @case('search') Kata Kunci @break
                            @case('filterJenisKelamin') Jenis Kelamin @break
                            @case('filterAgama') Agama @break
                            @case('filterUsiaMin') Usia Min @break
                            @case('filterUsiaMax') Usia Max @break
                            @case('filterPendidikan') Pendidikan @break
                            @case('filterStatusPerkawinan') Status Perkawinan @break
                            @case('filterRt') RT @break
                        @endswitch
                    </strong>: 
                     @if($key === 'filterPendidikan')
                        {{ $options['pendidikan'][$value] ?? $value }}
                     @elseif($key === 'filterStatusPerkawinan')
                        {{ $options['status_perkawinan'][$value] ?? $value }}
                     @elseif($key === 'filterRt')
                        {{ $value }}
                     @else
                        {{ $value }}
                     @endif
                     <br>
                @endif
            @endforeach
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>No. KK</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Pendidikan</th>
                    <th>Status Perkawinan</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wargas as $index => $warga)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>'{{ $warga->nik }}</td>
                        <td>{{ $warga->nama_lengkap }}</td>
                        <td>'{{ $warga->kartuKeluarga->nomor_kk ?? '-' }}</td>
                        <td>{{ $warga->jenis_kelamin }}</td>
                        <td>{{ \Carbon\Carbon::parse($warga->tanggal_lahir)->age }} Thn</td>
                        <td>{{ $warga->pendidikan_terakhir }}</td>
                        <td>{{ $warga->status_perkawinan }}</td>
                        <td>{{ $warga->kartuKeluarga->alamat ?? '-' }} RT {{ $warga->kartuKeluarga->rt ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">Tidak ada data yang cocok dengan filter yang diterapkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>

