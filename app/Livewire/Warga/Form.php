<?php

namespace App\Livewire\Warga;

use App\Helpers\BreadcrumbHelper;
use App\Models\HistoryKependudukan;
use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public Warga $warga;
    public $kartuKeluarga = [];
    public $breadcrumbs = [];

    // Opsi dari config
    public $opsiAgama = [];
    public $opsiGolonganDarah = [];
    public $opsiHubunganKeluarga = [];
    public $opsiPendidikan = [];

    // --- PROPERTI BARU UNTUK JENIS PENDAFTARAN ---
    public $jenis_pendaftaran = 'kelahiran';

    // Properti data warga
    public $kartu_keluarga_id;
    public $nik;
    public $nama_lengkap;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $agama;
    public $pendidikan_terakhir;
    public $pekerjaan;
    public $golongan_darah;
    public $status_perkawinan;
    public $status_hubungan_keluarga;
    public $nama_ayah;
    public $nama_ibu;

    // --- PROPERTI BARU UNTUK PENDATANG ---
    public $tanggal_pindah;
    public $alamat_sebelumnya;
    public $nomor_surat_pindah;

    public function mount(?Warga $warga)
    {
        $this->warga = $warga->exists ? $warga : new Warga();
        $this->kartuKeluarga = KartuKeluarga::with('kepalaKeluarga')->orderBy('nomor_kk')->get();

        // Muat opsi dari file config
        $this->opsiAgama = config('options.agama', []);
        $this->opsiGolonganDarah = config('options.golongan_darah', []);
        $this->opsiHubunganKeluarga = config('options.hubungan_keluarga', []);
        $this->opsiPendidikan = config('options.pendidikan', []);

        if ($this->warga->exists) {
            $this->fill($this->warga->toArray());
            $this->breadcrumbs = BreadcrumbHelper::warga('edit', $this->warga);
        } else {
            // Jika tambah, set jenis pendaftaran dari URL jika ada (?type=pendatang)
            $this->jenis_pendaftaran = request()->query('type', 'kelahiran');
            
            // Inisialisasi nilai default
            $this->agama = array_key_first($this->opsiAgama);
            $this->status_hubungan_keluarga = array_key_first($this->opsiHubunganKeluarga);
            $this->pendidikan_terakhir = array_key_first($this->opsiPendidikan);
            $this->golongan_darah = array_key_first($this->opsiGolonganDarah);
            $this->status_perkawinan = 'BELUM KAWIN';
            $this->warga = new Warga();
            $this->breadcrumbs = BreadcrumbHelper::warga('create');
        }

        $this->dispatch('update-breadcrumbs', breadcrumbs: $this->breadcrumbs);
    }

    public function save()
    {
        $rules = [
            'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            'nik' => ['required', 'digits:16', Rule::unique('warga', 'nik')->ignore($this->warga->id)],
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => ['required', Rule::in(['LAKI-LAKI', 'PEREMPUAN'])],
            'status_perkawinan' => ['required', Rule::in(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'])],
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => ['required', Rule::in(array_keys($this->opsiAgama))],
            'pendidikan_terakhir' => ['nullable', Rule::in(array_keys($this->opsiPendidikan))],
            'pekerjaan' => 'nullable|string|max:100',
            'golongan_darah' => ['nullable', Rule::in(array_keys($this->opsiGolonganDarah))],
            'status_hubungan_keluarga' => ['required', Rule::in(array_keys($this->opsiHubunganKeluarga))],
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
        ];

        // Tambahkan validasi kondisional untuk pendatang
        if ($this->jenis_pendaftaran === 'pendatang') {
            $rules['tanggal_pindah'] = 'required|date';
            $rules['alamat_sebelumnya'] = 'required|string|max:255';
            $rules['nomor_surat_pindah'] = 'nullable|string|max:100';
        }

        $validatedData = $this->validate($rules);

        $isNew = !$this->warga->exists;

        if ($isNew) {
            // Pisahkan data untuk model Warga
            $wargaData = collect($validatedData)->except([
                'tanggal_pindah', 'alamat_sebelumnya', 'nomor_surat_pindah'
            ])->toArray();
            
            $this->warga = Warga::create($wargaData);

            // Buat histori kependudukan berdasarkan jenis pendaftaran
            if ($this->jenis_pendaftaran === 'pendatang') {
                HistoryKependudukan::create([
                    'warga_id' => $this->warga->id,
                    'peristiwa' => 'PINDAH MASUK',
                    'tanggal_peristiwa' => $this->tanggal_pindah,
                    'detail_peristiwa' => "Pindah masuk dari {$this->alamat_sebelumnya}. No. Surat: {$this->nomor_surat_pindah}",
                    'created_by' => Auth::id(),
                ]);
            } else { // Default adalah 'LAHIR'
                HistoryKependudukan::create([
                    'warga_id' => $this->warga->id,
                    'peristiwa' => 'LAHIR',
                    'tanggal_peristiwa' => $this->warga->tanggal_lahir,
                    'detail_peristiwa' => 'Data kelahiran dibuat.',
                    'created_by' => Auth::id(),
                ]);
            }

            $this->dispatch('history-created')->to(\App\Livewire\History\Index::class);
            session()->flash('success', 'Data warga berhasil ditambahkan.');
        } else {
            $this->warga->update($validatedData);
            session()->flash('success', 'Data warga berhasil diperbarui.');
        }

        return $this->redirect(route('warga.show', $this->warga), navigate: true);
    }

    public function render()
    {
        return view('livewire.warga.form');
    }
}
