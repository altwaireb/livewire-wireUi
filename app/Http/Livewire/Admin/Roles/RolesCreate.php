<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Permission;
use Livewire\Component;
use App\Models\Role;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RolesCreate extends Component
{
    use AuthorizesRequests;
    use Actions;

    public bool $openCreateModel = false;

    public ?string $name = null;
    public ?string $key = null;
    public bool $default = false;
    public ?string $color = '#000';
    // Relationship
    public array $permission = [];

    // All Permissions
    public $permissions;

    protected $listeners = ['openCreateModel'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:roles'
            ],
            'key' => [
                'required',
                'string',
                'lowercase',
                'min:2',
                'max:50',
                'regex:/^([a-z])+?(_)?([a-z])+$/i',
                'unique:roles'
            ],
            'default' => [
                'required',
                'boolean',
                'unique:roles,default,NULL,id,default,1'
            ],
            'color' => [
                'required',
                'string',
                'min:4',
                'max:7',
                'unique:roles'
            ],
            'permission' => [
                'nullable',
                'array',
                'exists:App\Models\Permission,id'
            ]
        ];
    }

    public function mount($permissions){
        $this->permissions = $permissions;
    }

    public function openCreateModel()
    {
        $this->openCreateModel = true;
    }

    public function create()
    {
        $this->validate();
        $this->authorize('create', Role::class);

        $data = [
            'name' => $this->name,
            'key' => $this->key,
            'color' => $this->color,
            'default' => $this->default,
        ];

        $role = Role::create($data);

        if (!empty($this->permission)){
            $permissionsIds = Permission::whereIn('id', $this->permission)->pluck('id');
            $role->permissions()->attach($permissionsIds);
        }

        $this->closeCreateModel();
        $this->notification()->success(
            $title = __('app.create') . ' ' . __('roles.role'),
            $description = __('roles.created role', ['name' => $data['name']])
        );
        $this->emit('refreshParent');
    }

    public function closeCreateModel()
    {
        $this->openCreateModel = false;
        $this->resetExcept('permissions');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-create');
    }
}
