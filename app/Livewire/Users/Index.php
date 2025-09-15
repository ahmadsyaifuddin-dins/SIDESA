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
    // Gunakan trait WithPagination untuk paginasi Livewire
    use WithPagination;

    // Properti untuk menyimpan nilai dari input pencarian dan filter
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    // Lifecycle hook untuk mereset paginasi setiap kali filter berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedFilterRole()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function delete(User $user)
    {
        if ($user->id === Auth::id()) {
            $this->dispatch('flash-message', ['message' => 'Anda tidak dapat menghapus akun Anda sendiri.', 'type' => 'error']);
            return;
        }

        $user->delete();
        $this->dispatch('flash-message', ['message' => 'Pengguna berhasil dihapus.', 'type' => 'success']);
    }

    public function render()
    {
        $users = User::query()
            // Terapkan pencarian jika $search tidak kosong
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            // Terapkan filter role jika $filterRole tidak kosong
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            // Terapkan filter status jika $filterStatus tidak kosong
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}

