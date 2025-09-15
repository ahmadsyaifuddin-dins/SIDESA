<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
class Form extends Component
{
    public User $user;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('nullable|string|max:100')]
    public $jabatan = '';

    #[Rule('required|in:admin,superadmin,pimpinan')]
    public $role = 'admin';

    #[Rule('required|in:Aktif,Tidak Aktif')]
    public $status = 'Aktif';

    #[Rule('nullable|string|min:8|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    public $isEditMode = false;

    public function mount(User $user)
    {
        if ($user->exists) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->jabatan = $user->jabatan;
            $this->role = $user->role;
            $this->status = $user->status;
            $this->isEditMode = true;
        }
    }

    public function save()
    {
        $rules = $this->getRules();
        $rules['email'] = 'required|email|max:255|unique:users,email,' . ($this->isEditMode ? $this->user->id : '');
        if (!$this->isEditMode) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        $validated = $this->validate($rules);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($this->isEditMode) {
            $this->user->update($validated);
            // Persist flash message for next request
            session()->flash('success', 'Pengguna berhasil diperbarui.');
        } else {
            User::create($validated);
            // Persist flash message for next request
            session()->flash('success', 'Pengguna berhasil ditambahkan.');
        }

        return $this->redirect(route('users.index'), navigate: true);
    }

    #[Title('Form Pengguna')]
    public function render()
    {
        return view('livewire.users.form');
    }
}
