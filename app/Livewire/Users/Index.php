<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Daftar Pengguna')]
class Index extends Component
{
    use WithPagination;

    public function delete(User $user)
    {
        if ($user->id === Auth::id()) {
            // Mengirim data sebagai satu array
            $this->dispatch('flash-message', ['message' => 'Anda tidak dapat menghapus akun Anda sendiri.', 'type' => 'error']);
            return;
        }

        $user->delete();

        // Mengirim data sebagai satu array
        $this->dispatch('flash-message', ['message' => 'Pengguna berhasil dihapus.', 'type' => 'success']);
    }

    public function render()
    {
        $users = User::latest()->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}