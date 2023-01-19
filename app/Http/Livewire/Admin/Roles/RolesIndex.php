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

    public bool $trashed = false;
    public int|null $permissionSearch = null;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function updatingTrashed()
    {
        $this->resetPage();
    }

    public function updatingPermissionsSearch(){
        $this->resetPage();
    }

    public function getRolesProperty()
    {
        $items = Role::query();
        // * Trashed
        if ($this->trashed) {
            $items = $items->onlyTrashed()->withCount('users','permissions');
        }else{
            $items = $items->withCount('users','permissions');
        }

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
