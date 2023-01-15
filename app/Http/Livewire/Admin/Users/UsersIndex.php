<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use App\Traits\WithSorting;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UsersIndex extends Component
{
    use WithSorting;

    public bool $trashed = false;
    public int|null $roleSearch = null;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function updatingTrashed()
    {
        $this->resetPage();
    }

    public function updatingRoleSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        $items = User::query();
        $items = $items->with('role:id,name,key,color');
        // * Trashed
        if ($this->trashed) {
            $items = $items->onlyTrashed();
        }
        if (!empty($this->roleSearch)) {
            $items = $items->where('role_id', $this->roleSearch);
        }
        return $this->orderAndPaginate($items);
    }

    public function render(): View
    {
        return view('livewire.admin.users.users-index', [
            'items' => $this->users,
            'roles' => Role::select('id', 'name')->orderBy('id', 'asc')->get()->toArray()
        ])->layout('layouts.admin');
    }
}
