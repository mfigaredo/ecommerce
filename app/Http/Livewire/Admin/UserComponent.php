<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function assignRole(User $user, $value) {
        if($value=='1') {
            $user->assignRole('admin');
        } else {
            $user->removeRole('admin');
        }

    }

    public function render()
    {
        // \DB::enableQueryLog();
        $users = User::where('id', '<>', auth()->id())
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
                $query->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->paginate(10);
        // dd(\DB::getQueryLog());

        return view('livewire.admin.user-component', compact('users'))->layout('layouts.admin');
    }
}
