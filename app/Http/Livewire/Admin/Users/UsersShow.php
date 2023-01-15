<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UsersShow extends Component
{
    use AuthorizesRequests;

    public bool $openShowModel = false;
    public $item;

    protected $listeners = ['openShowModel'];

    public function openShowModel($itemId) : void
    {
        $this->item = User::with('role')->findOrFail($itemId);
        $this->authorize('view', $this->item);
        $this->openShowModel = true;
    }

    public function closeShowModel()
    {
        $this->openShowModel = false;
        $this->reset();
    }


    public function render()
    {
        return view('livewire.admin.users.users-show');
    }
}
