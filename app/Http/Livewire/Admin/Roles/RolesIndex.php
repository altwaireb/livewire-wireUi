<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Permission;
use App\Models\Role;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

class RolesIndex extends Component
{
    use WithSorting;

    public $permissionSearch;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function updatingPermissionsSearch(){
        $this->resetPage();
    }

    public function getRolesProperty()
    {
        $items = Role::query();
        $items = $items->withCount('users','permissions');

        if ($this->permissionSearch){
            $items = $items->whereHas('permissions' ,function (Builder $query){
                $query->where('id', $this->permissionSearch);
            });
        }
        return $this->orderAndPaginate($items);
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-index',[
            'items' => $this->roles,
            'permissions' => Permission::select('id','name','table_name')->get()
        ])->layout('layouts.admin');
    }
}
