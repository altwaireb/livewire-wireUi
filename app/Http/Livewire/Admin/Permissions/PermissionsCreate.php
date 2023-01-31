<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Models\Permission;
use Livewire\Component;
use Illuminate\View\View;
use WireUi\Traits\Actions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PermissionsCreate extends Component
{
    use AuthorizesRequests;
    use Actions;

    public bool $openCreateModel = false;

    public ?string $name = null;
    public ?string $key = null;
    public ?string $table_name = null;

    protected $listeners = ['openCreateModel'];

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:permissions'
            ],
            'key' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/(^[a-z])+?([a-zA-Z])+?([_])?([A-Za-z])+?([_])?([A-Za-z])+$/i',
                'unique:permissions'
            ],
            'table_name' => [
                'nullable',
                'string',
                'lowercase',
                'min:2',
                'max:50',
                'regex:/(^[a-z])+?([a-z])+?([_])?([a-z])+?([_])?([a-z])+$/i',
            ]
        ];
    }

    public function openCreateModel()
    {
        $this->openCreateModel = true;
    }

    public function create()
    {
        $this->validate();
        $this->authorize('create', Permission::class);

        $data = [
            'name' => $this->name,
            'key' => $this->key,
            'table_name' => $this->table_name,
        ];

        Permission::create($data);

        $this->closeCreateModel();
        $this->notification()->success(
            $title = __('app.create') . ' ' . __('permissions.permission'),
            $description = __('permissions.created permission', ['name' => $data['name']])
        );
        $this->emit('refreshParent');
    }

    public function closeCreateModel()
    {
        $this->openCreateModel = false;
        $this->reset();
        $this->resetValidation();
        $this->resetErrorBag();
    }
    public function render(): View
    {
        return view('livewire.admin.permissions.permissions-create');
    }
}
