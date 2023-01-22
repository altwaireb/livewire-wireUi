<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Models\Permission;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use WireUi\Traits\Actions;

class PermissionsUpdate extends Component
{
    use AuthorizesRequests;
    use Actions;

    public bool $openUpdateModel = false;
    //  Model
    public $permission;
    public $itemId;
    // Attributes Model
    public ?string $name = null;
    public ?string $key = null;
    public ?string $table_name = null;

    protected $listeners = ['openUpdateModel'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:permissions,name,'. $this->itemId
            ],
            'key' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^([A-Za-z])+?(_)?([A-Za-z])+$/i',
                'unique:permissions,key,'. $this->itemId
            ],
            'table_name' => [
                'nullable',
                'string',
                'lowercase',
                'min:2',
                'max:50',
                'regex:/^([a-z])+?(_)?([a-z])+$/i',
            ]
        ];
    }

    public function openUpdateModel($itemId)
    {
        $this->itemId = $itemId;
        $this->permission = Permission::findOrFail($this->itemId);
        $this->authorize('update', $this->permission);
        $this->openUpdateModel = true;

        $this->name         = $this->permission->name;
        $this->key          = $this->permission->key;
        $this->table_name   = $this->permission->table_name;
    }

    public function edit()
    {
        $this->validate();
        $this->authorize('update', $this->permission);

        $data = [
            'name' => $this->name,
            'key' => $this->key,
            'table_name' => $this->table_name,
        ];

        $this->permission->update($data);

        $this->closeUpdateModel();
        $this->notification()->success(
            $title = __('app.update') . ' ' . __('permissions.permission'),
            $description = __('permissions.updated permission', ['name' => $data['name']])
        );
        $this->emit('refreshParent');

    }

    public function closeUpdateModel()
    {
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.permissions.permissions-update');
    }
}
