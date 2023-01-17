<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class SettingsUpdate extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    use Actions;

    public bool $openUpdateModel = false;

    //  Model
    public $setting;
    // Attributes Model
    public ?string $key = null;
    public ?string $display_name = null;
    public $value;
    public string $type = 'text';
    public int $order = 1;

    public $newValue;

    public array $types = [];

    protected $listeners = ['openUpdateModel'];

    public function mount($types)
    {
        $this->types = $types;
    }

    protected function rules()
    {
        return [
            'key' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^([a-z])+?(-|_)?([a-z])+$/i',
                'unique:settings,key,'. $this->setting->id
            ],
            'display_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:settings,display_name,'. $this->setting->id
            ],
            'type' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::in($this->types)
            ],
            'value' => [ 'required_if:newValue,null'],
            'order' => [
                'required',
                'integer',
                'min:1',
                'max:100',
                'unique:settings,order,'. $this->setting->id
            ]
        ];
    }

    protected $messages = [
        'key.regex' => 'The input format is incorrect Should a-z (-|_).',
    ];

    public function openUpdateModel(Setting $setting){
        $this->setting = $setting;
        $this->openUpdateModel = true;
        $this->authorize('update', $this->setting);

        $this->key          = $this->setting->key;
        $this->display_name = $this->setting->display_name;
        $this->value        = $this->setting->value;
        $this->type         = $this->setting->type;
        $this->order        = $this->setting->order;

    }

    public function updatingType()
    {
        $this->value = null;
        $this->newValue = null;
    }

    public function updatedNewValue()
    {
        if ($this->type === 'image') {
            $this->validate([
                'newValue' => 'required|image|mimes:jpeg,png,jpg,svg|max:1024|dimensions:min_width=100,min_height=100,max_width=800,max_height=400',
            ]);
        } elseif ($this->type === 'file') {
            $this->validate([
                'newValue' => 'required|file|mimes:pdf,doc,docx|max:10000',
            ]);
        } elseif ($this->type === 'textarea') {
            $this->validate([
                'newValue' => 'required|string|min:1|max:1000',
            ]);
        } elseif ($this->type === 'text') {
            $this->validate([
                'newValue' => 'required|string|min:1|max:255',
            ]);
        }
    }

    public function edit()
    {
        $this->validate();
        $this->authorize('update', $this->setting);

        $data = [
            'key' => $this->key,
            'display_name' => $this->display_name,
            'type' => $this->type,
            'order' => $this->order,
        ];

        if (!empty($this->newValue) and $this->type === 'image' or $this->type === 'file') {
            $url = $this->newValue->store('settings', 'public');
            $data['value'] = $url;
        } else {
            $data['value'] = $this->value;
        }

        $this->setting->update($data);
        $this->closeUpdateModel();
        $this->notification()->success(
            $title = __('app.update') . ' ' . __('setting.setting'),
            $description = __('setting.updated setting', ['name' => $data['key']])
        );
        $this->emit('refreshParent');

    }

    public function closeUpdateModel()
    {
        $this->openUpdateModel = false;
        $this->resetExcept('types');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.settings.settings-update');
    }
}
