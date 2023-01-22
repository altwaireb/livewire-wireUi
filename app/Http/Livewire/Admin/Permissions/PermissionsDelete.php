<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class PermissionsDelete extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openDeleteModel'];
    public function openDeleteModel($itemId) : void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title'       => __('permissions.delete question'),
            'description' => __('permissions.delete description',
                [
                    'name' => $this->item->name,
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
        return Permission::find($this->itemId);
    }

    public function closeDeleteModel()
    {
        $this->reset();
        $this->notification()->error(
            $title = __('app.undo the deletion'),
        );
    }
    public function render(): View
    {
        return view('livewire.admin.permissions.permissions-delete');
    }
}
