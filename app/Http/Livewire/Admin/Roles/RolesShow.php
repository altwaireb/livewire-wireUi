<?php

namespace App\Http\Livewire\Admin\Roles;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

class RolesShow extends Component
{
    use AuthorizesRequests;

    public bool $openShowModel = false;
    public $item;

    protected $listeners = ['openShowModel'];

    public function openShowModel($itemId): void
    {
        $this->item = Role::with('permissions')
            ->withCount('users','permissions')
            ->findOrFail($itemId);
        $this->authorize('view', $this->item);
        $this->openShowModel = true;
    }

    public function closeShowModel(): void
    {
        $this->openShowModel = false;
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.admin.roles.roles-show');
    }
}
