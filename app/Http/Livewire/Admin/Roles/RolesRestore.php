<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class RolesRestore extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openRestoreModel'];

    public function openRestoreModel($itemId): void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title' => __('roles.restore question'),
            'description' => __('roles.restore description',
                [
                    'name' => $this->item->name,
                    'count' => $this->item->users_count,
                ]
            ),
            'icon' => 'warning',
            'accept' => [
                'label' => __('app.yes ok'),
                'method' => 'restore',
                'params' => null,
            ],
            'reject' => [
                'label' => __('app.no cancel'),
                'method' => 'closeRestoreModel',
            ],
        ]);

    }

    public function restore()
    {
        $this->authorize('restore', $this->item);
        $this->item->users()->restore();
        $this->item->restore();
        $this->notification()->success(
            $title = __('app.restore') . ' ' . __('roles.role'),
            $description = __('roles.restore role', ['name' => $this->item->name])
        );
        $this->reset();
        $this->emit('refreshParent');

    }

    public function getItemProperty()
    {
        return Role::onlyTrashed()->withCount('users')->find($this->itemId);
    }

    public function closeRestoreModel()
    {
        $this->reset();
        $this->notification()->success(
            $title = __('app.undo the restore'),
        );
    }
    public function render(): View
    {
        return view('livewire.admin.roles.roles-restore');
    }
}
