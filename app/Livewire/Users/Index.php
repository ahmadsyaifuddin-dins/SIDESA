<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\BreadcrumbHelper;

class Index extends Component
{
    use WithPagination;

    public $breadcrumbs = [];
    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    public function mount()
    {
        // Set breadcrumb untuk halaman index users
        $this->breadcrumbs = BreadcrumbHelper::users('index');
        
        // Dispatch breadcrumb ke navbar
        $this->dispatch('update-breadcrumbs', breadcrumbs: $this->breadcrumbs);
    }

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
            $this->dispatch('flash-message-display', ['message' => 'Anda tidak dapat menghapus akun Anda sendiri.', 'type' => 'error']);
            return;
        }

        $user->delete();
        $this->dispatch('flash-message-display', ['message' => 'Pengguna berhasil dihapus.', 'type' => 'success']);
    }

    #[Title('Daftar Pengguna')]
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, fn($query) => $query->where('role', $this->filterRole))
            ->when($this->filterStatus, fn($query) => $query->where('status', $this->filterStatus))
            ->latest()
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users,
        ]);
    }
}