<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class UsersForceDelete extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openForceDeleteModel'];

    public function openForceDeleteModel($itemId): void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title' => __('user.forceDelete question'),
            'description' => __('user.forceDelete description', ['name' => $this->item->name]),
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
            $title = __('app.forceDelete') . ' ' . __('user.user'),
            $description = __('user.forceDeleted user')
        );
        $this->reset();
        $this->emit('refreshParent');
    }

    public function getItemProperty()
    {
        return User::onlyTrashed()->find($this->itemId);
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
        return view('livewire.admin.users.users-force-delete');
    }
}
