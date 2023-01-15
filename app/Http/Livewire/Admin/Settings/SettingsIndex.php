<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use App\Traits\WithSorting;
use Livewire\Component;

class SettingsIndex extends Component
{
    use WithSorting;


    public function create(){
        $this->emit('showCreateModel');
    }


    public function getItems(){
        $items = Setting::query();
        $items = $this->orderAndPaginate($items);
        return $items;
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-index',[
            'items' => $this->getItems()
        ])->layout('layouts.admin');
    }
}
