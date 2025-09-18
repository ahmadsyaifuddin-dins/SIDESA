<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Helpers\BreadcrumbHelper;

#[Layout('components.layouts.app')]
#[Title('Detail Pengguna')]
class Show extends Component
{
    public User $user;
    public $breadcrumbs = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->breadcrumbs = BreadcrumbHelper::users('show', $user);
        
        // Dispatch breadcrumb ke navbar
        $this->dispatch('update-breadcrumbs', breadcrumbs: $this->breadcrumbs);
    }

    public function render()
    {
        return view('livewire.users.show');
    }
}
