<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SettingsShow extends Component
{

    use AuthorizesRequests;

    public bool $openShowModel = false;
    public $item;

    protected $listeners = ['openShowModel'];

    public function openShowModel($itemId) : void
    {
        $this->item = Setting::findOrFail($itemId);
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
        return view('livewire.admin.settings.settings-show');
    }
}
