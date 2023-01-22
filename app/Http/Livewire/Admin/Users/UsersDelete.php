<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use WireUi\Traits\Actions;

class UsersDelete extends Component
{

    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openDeleteModel'];

    public function openDeleteModel($itemId) : void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title'       => __('users.delete question'),
            'description' => __('users.delete description',['name' => $this->item->name]),
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
            $title = __('app.delete') . ' ' . __('users.user'),
            $description = __('users.deleted user')
        );
        $this->reset();
        $this->emit('refreshParent');
    }

    public function getItemProperty()
    {
        return User::find($this->itemId);
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
        return view('livewire.admin.users.users-delete');
    }
}
