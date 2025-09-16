<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Profil Saya')]
class UpdateForm extends Component
{
    use WithFileUploads;

    // Properti untuk form informasi profil
    public string $nik = '';
    public string $name = '';
    public string $email = '';
    public $photo; // Properti untuk file upload baru
    public $jenis_kelamin = '';
    public $tanggal_lahir = '';
    public $alamat = '';

    // Properti untuk form ubah password
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        $user = Auth::user();
        $this->nik = $user->nik;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->jenis_kelamin = $user->jenis_kelamin;
        $this->tanggal_lahir = $user->tanggal_lahir;
        $this->alamat = $user->alamat;
    }

    public function updateProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'nik' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'photo' => ['nullable', 'image', 'max:1024'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        if ($this->photo) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && File::exists(public_path($user->profile_photo_path))) {
                File::delete(public_path($user->profile_photo_path));
            }

            $filename = Str::random(12) . '.' . $this->photo->extension();
            $destinationPath = public_path('profile-photos');

            // Pastikan direktori ada
            File::makeDirectory($destinationPath, 0755, true, true);

            // Baca konten file temporer dan tulis ke tujuan baru
            File::put($destinationPath . '/' . $filename, file_get_contents($this->photo->getRealPath()));

            $validated['profile_photo_path'] = 'profile-photos/' . $filename;
        }

        // Langsung panggil update() pada Auth::user()
        $user->update($validated);

        $this->dispatch('flash-message-display', ['message' => 'Informasi profil berhasil diperbarui.', 'type' => 'success']);

        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Garis merah akan hilang
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('flash-message-display', ['message' => 'Password berhasil diubah.', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.profile.update-form');
    }
}
