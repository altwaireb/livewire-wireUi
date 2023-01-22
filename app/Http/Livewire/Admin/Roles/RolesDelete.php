<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class RolesDelete extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openDeleteModel'];

    public function openDeleteModel($itemId) : void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title'       => __('roles.delete question'),
            'description' => __('roles.delete description',
                [
                    'name' => $this->item->name,
                    'count' => $this->item->users_count,
                ]
            ),
            'icon'        => 'warning',
            'accept'      => [
                'label'  => __('app.yes ok'),
                'method' => 'delete',
                'params' => null,
            ],
            'reject' => [
                'label'  => __('app.no cancel'),
                'method' => 'closeDeleteModel',
            ],
        ]);


    }


    public function delete()
    {
        $this->authorize('delete', $this->item);
        $this->item->users()->delete();
        $this->item->delete();
        $this->notification()->success(
            $title = __('app.delete') . ' ' . __('roles.role'),
            $description = __('roles.deleted role')
        );
        $this->reset();
        $this->emit('refreshParent');
    }

    public function getItemProperty()
    {
        return Role::withCount('users')->find($this->itemId);
    }

    public function closeDeleteModel()
    {
        $this->reset();
        $this->notification()->success(
            $title = __('app.undo the deletion'),
        );
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-delete');
    }
}
