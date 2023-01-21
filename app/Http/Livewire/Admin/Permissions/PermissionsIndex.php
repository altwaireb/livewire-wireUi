<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Models\Permission;
use App\Traits\WithSorting;
use Illuminate\View\View;
use Livewire\Component;

class PermissionsIndex extends Component
{
    use WithSorting;

    public string|null $tableNameSearch = null;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function updatingTableNameSearch()
    {
        $this->resetPage();
    }

    public function getPermissionsProperty()
    {
        $items = Permission::query();
        $items = $items->withCount('roles');

        if (!empty($this->tableNameSearch)) {
            if ($this->tableNameSearch === 'NULL'){
                $items = $items->whereNull('table_name');
            }else{
                $items = $items->where('table_name', $this->tableNameSearch);
            }
        }

        return $this->orderAndPaginate($items);
    }

    public function render(): View
    {
        return view('livewire.admin.permissions.permissions-index',[
            'items' => $this->permissions,
            'tableNames' => Permission::select('table_name')->distinct()->get()
        ])->layout('layouts.admin');
    }
}
