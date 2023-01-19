<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class RolesUpdate extends Component
{

    use WithFileUploads;
    use AuthorizesRequests;
    use Actions;

    public bool $openUpdateModel = false;
    //  Model
    public $role;
    public $itemId;
    // Attributes Model
    public ?string $name = null;
    public ?string $key = null;
    public bool $default = false;
    public ?string $color = '#000';
    // Relationship
    public array $permission = [];

    // All Permissions
    public $permissions;

    protected $listeners = ['openUpdateModel'];

    public function mount($permissions){
        $this->permissions = $permissions;
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:roles,name,'. $this->itemId
            ],
            'key' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^([a-z])+?(_)?([a-z])+$/i',
                'unique:roles,key,'. $this->itemId
            ],
            'default' => [
                'required',
                'boolean',
//                'unique:roles,default,NULL,id,default,1',
                "unique:roles,default,".$this->itemId.",id,default,1"
            ],
            'color' => [
                'required',
                'string',
                'min:4',
                'max:7',
                'unique:roles,color,'. $this->itemId
            ],
            'permission' => [
                'required',
                'array'
            ]
        ];
    }

    public function openUpdateModel($itemId)
    {
        $this->itemId = $itemId;
        $this->role = Role::with('permissions')->find($this->itemId);
        $this->authorize('update', $this->role);
        $this->openUpdateModel = true;

        $this->name         = $this->role->name;
        $this->key          = $this->role->key;
        $this->default      = $this->role->default;
        $this->color        = $this->role->color;
        $this->permission   = $this->role->permissions->pluck('id')->toArray();
    }

    public function edit()
    {
        $this->validate();
        $this->authorize('update', $this->role);

        $data = [
            'name' => $this->name,
            'key' => $this->key,
            'color' => $this->color,
            'default' => $this->default,
        ];

        $this->role->update($data);

        if (!empty($this->permission)){
            $permissionsIds = Permission::whereIn('id', $this->permission)->pluck('id');
            $this->role->permissions()->sync($permissionsIds);
        }

        $this->closeUpdateModel();
        $this->notification()->success(
            $title = __('app.update') . ' ' . __('roles.role'),
            $description = __('roles.updated role', ['name' => $data['name']])
        );
        $this->emit('refreshParent');

    }

    public function closeUpdateModel()
    {
        $this->openUpdateModel = false;
        $this->resetExcept('permissions');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-update');
    }
}
