<?php

namespace App\Livewire\Warga;

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

    // Properti untuk menampung opsi dari config (hanya yang datanya banyak)
    public $opsiAgama = [];
    public $opsiGolonganDarah = [];
    public $opsiHubunganKeluarga = [];
    public $opsiPendidikan = [];

    // Properti untuk data warga
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

    public function mount(?Warga $warga)
    {
        $this->warga = $warga->exists ? $warga : new Warga();
        $this->kartuKeluarga = KartuKeluarga::pluck('nomor_kk', 'id')->all();

        // Muat opsi dari file config
        $this->opsiAgama = config('options.agama', []);
        $this->opsiGolonganDarah = config('options.golongan_darah', []);
        $this->opsiHubunganKeluarga = config('options.hubungan_keluarga', []);
        $this->opsiPendidikan = config('options.pendidikan', []);

        if ($this->warga->exists) {
            // Jika edit data, isi semua properti dari model
            $this->fill($this->warga->toArray());
        } else {
            // -- PERBAIKAN BUG ADA DI SINI --
            // Jika tambah data baru, inisialisasi nilai default untuk dropdown
            // Ambil key pertama dari setiap array opsi sebagai nilai default
            $this->agama = array_key_first($this->opsiAgama);
            $this->status_hubungan_keluarga = array_key_first($this->opsiHubunganKeluarga);
            $this->pendidikan_terakhir = array_key_first($this->opsiPendidikan);
            $this->golongan_darah = array_key_first($this->opsiGolonganDarah);
            // Untuk dropdown statis, kita bisa set manual
            $this->status_perkawinan = 'BELUM KAWIN';
        }
    }

    public function save()
    {
        $validatedData = $this->validate([
            'kartu_keluarga_id' => 'required|exists:kartu_keluarga,id',
            'nik' => ['required', 'digits:16', Rule::unique('warga', 'nik')->ignore($this->warga->id)],
            'nama_lengkap' => 'required|string|max:255',
            // Validasi untuk opsi statis
            'jenis_kelamin' => ['required', Rule::in(['LAKI-LAKI', 'PEREMPUAN'])],
            'status_perkawinan' => ['required', Rule::in(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'])],
            // Validasi untuk opsi dinamis
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => ['required', Rule::in(array_keys($this->opsiAgama))],
            'pendidikan_terakhir' => ['nullable', Rule::in(array_keys($this->opsiPendidikan))],
            'pekerjaan' => 'nullable|string|max:100',
            'golongan_darah' => ['nullable', Rule::in(array_keys($this->opsiGolonganDarah))],
            'status_hubungan_keluarga' => ['required', Rule::in(array_keys($this->opsiHubunganKeluarga))],
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
        ]);

        $isNew = !$this->warga->exists;

        if ($isNew) {
            $this->warga = Warga::create($validatedData);

            HistoryKependudukan::create([
                'warga_id' => $this->warga->id,
                'peristiwa' => 'LAHIR',
                'tanggal_peristiwa' => $this->warga->tanggal_lahir,
                'detail_peristiwa' => 'Data awal dibuat secara manual.',
                'created_by' => Auth::id(),
            ]);

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
