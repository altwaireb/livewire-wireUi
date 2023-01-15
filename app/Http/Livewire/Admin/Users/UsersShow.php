<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class UsersShow extends Component
{
    public bool $openShowModel = false;
    public $item;

    protected $listeners = ['openShowModel'];

    public function openShowModel($itemId)
    {
        $this->openShowModel = true;
        $this->item = User::with('role')->findOrFail($itemId);
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
