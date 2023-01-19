<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class RolesForceDelete extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openForceDeleteModel'];

    public function openForceDeleteModel($itemId): void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title' => __('roles.forceDelete question'),
            'description' => __('roles.forceDelete description',
                [
                    'name' => $this->item->name,
                    'count' => $this->item->users_count,
                ]),
            'icon' => 'warning',
            'accept' => [
                'label' => __('app.yes ok'),
                'method' => 'forceDelete',
                'params' => null,
            ],
            'reject' => [
                'label' => __('app.no cancel'),
                'method' => 'closeForceDeleteModel',
            ],
        ]);
    }

    public function forceDelete()
    {
        $this->authorize('forceDelete', $this->item);
        $this->item->forceDelete();
        $this->notification()->success(
            $title = __('app.forceDelete') . ' ' . __('roles.role'),
            $description = __('roles.forceDeleted role')
        );
        $this->reset();
        $this->emit('refreshParent');
    }

    public function getItemProperty()
    {
        return Role::onlyTrashed()->withCount('users')->find($this->itemId);
    }

    public function closeForceDeleteModel()
    {
        $this->reset();
        $this->notification()->error(
            $title = __('app.undo the deletion'),
        );
    }
    public function render(): View
    {
        return view('livewire.admin.roles.roles-force-delete');
    }
}
