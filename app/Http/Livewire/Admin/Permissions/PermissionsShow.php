<?php

namespace App\Http\Livewire\Admin\Permissions;

use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;

class PermissionsShow extends Component
{

    use AuthorizesRequests;

    public bool $openShowModel = false;
    public $item;

    protected $listeners = ['openShowModel'];

    public function openShowModel($itemId): void
    {
        $this->item = Permission::withCount('roles')->findOrFail($itemId);
        $this->authorize('view', $this->item);
        $this->openShowModel = true;
    }

    public function closeShowModel(): void
    {
        $this->reset();
    }
    public function render(): View
    {
        return view('livewire.admin.permissions.permissions-show');
    }
}
