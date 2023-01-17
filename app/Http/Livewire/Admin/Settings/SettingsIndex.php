<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use App\Models\User;
use App\Traits\WithSorting;
use Illuminate\View\View;
use Livewire\Component;

class SettingsIndex extends Component
{
    use WithSorting;

    public string|null $typeSearch = null;

    public array $types = ['text', 'textarea', 'image', 'file'];

    protected $listeners = ['refreshParent' => '$refresh'];

    public function updatingTypeSearch()
    {
        $this->resetPage();
    }

    public function getSettingsProperty()
    {
        $items = Setting::query();
        if (!empty($this->typeSearch)) {
            $items = $items->where('type', $this->typeSearch);
        }
        return $this->orderAndPaginate($items);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.settings-index', [
            'items' => $this->settings
        ])->layout('layouts.admin');
    }
}
