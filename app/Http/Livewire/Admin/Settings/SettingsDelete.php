<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use WireUi\Traits\Actions;

class SettingsDelete extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $itemId;

    protected $listeners = ['openDeleteModel'];

    public function openDeleteModel($itemId) : void
    {
        $this->itemId = $itemId;
        $this->dialog()->confirm([
            'title'       => __('settings.delete question'),
            'description' => __('settings.delete description',['name' => $this->item->key]),
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
            $title = __('app.delete') . ' ' . __('settings.setting'),
            $description = __('settings.deleted setting')
        );
        $this->reset();
        $this->emit('refreshParent');
    }

    public function getItemProperty()
    {
        return Setting::find($this->itemId);
    }

    public function closeDeleteModel()
    {
        $this->reset();
        $this->notification()->success(
            $title = __('app.undo the deletion'),
        );
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-delete');
    }
}
