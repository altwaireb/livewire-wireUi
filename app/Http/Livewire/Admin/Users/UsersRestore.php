<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class UsersRestore extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openRestoreModel'];

    public function openRestoreModel($itemId): void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title' => __('users.restore question'),
            'description' => __('users.restore description', ['name' => $this->item->name]),
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
        $this->item->restore();
        $this->notification()->success(
            $title = __('app.restore') . ' ' . __('users.user'),
            $description = __('user.restore user', ['name' => $this->item->name])
        );
        $this->reset();
        $this->emit('refreshParent');

    }

    public function getItemProperty()
    {
        return User::onlyTrashed()->find($this->itemId);
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
        return view('livewire.admin.users.users-restore');
    }
}
