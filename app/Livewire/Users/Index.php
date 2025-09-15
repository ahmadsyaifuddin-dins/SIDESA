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

    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterRole() { $this->resetPage(); }
    public function updatedFilterStatus() { $this->resetPage(); }

    public function delete(User $user)
    {
        if ($user->id === Auth::id()) {
            // GUNAKAN DISPATCH (tanpa ->flash() karena tidak ada redirect)
            $this->dispatch('flash-message-display', ['message' => 'Anda tidak dapat menghapus akun Anda sendiri.', 'type' => 'error']);
            return;
        }

        $user->delete();

        // GUNAKAN DISPATCH (tanpa ->flash() karena tidak ada redirect)
        $this->dispatch('flash-message-display', ['message' => 'Pengguna berhasil dihapus.', 'type' => 'success']);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, fn ($query) => $query->where('role', $this->filterRole))
            ->when($this->filterStatus, fn ($query) => $query->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}

