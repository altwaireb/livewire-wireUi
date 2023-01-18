<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use App\Traits\WithSorting;
use Illuminate\View\View;
use Livewire\Component;

class RolesIndex extends Component
{
    use WithSorting;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function getRolesProperty()
    {
        $items = Role::query();
        return $this->orderAndPaginate($items);
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-index',[
            'items' => $this->roles
        ])->layout('layouts.admin');
    }
}
