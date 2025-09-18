<?php

namespace App\Livewire\Ui;

use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $breadcrumbs = [];

    public function mount($breadcrumbs = [])
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    #[On('update-breadcrumbs')]
    public function updateBreadcrumbs($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    #[On('profile-updated')]
    public function refresh()
    {
        // Method untuk me-refresh info user
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.ui.navbar');
    }
}