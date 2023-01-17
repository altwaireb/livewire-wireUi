<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class SettingsCreate extends Component
{
    use WithFileUploads;
    use Actions;

    public bool $openCreateModel = false;
    public ?string $key = null;
    public ?string $display_name = null;
    public $value;
    public string $type = 'file';
    public int $order = 1;

    public array $types = [];


    protected $listeners = ['openCreateModel'];

    public function mount($types)
    {
        $this->types = $types;
    }

    public function openCreateModel()
    {
        $this->openCreateModel = true;
        $this->order = Setting::orderBy('order', 'DESC')->first()->order + 1 ?? 1;
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
                'unique:settings'
            ],
            'display_name' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'unique:settings'
            ],
            'value' => [
                'required',
                'string',
                'min:1',
                'max:255'
            ],
            'type' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::in($this->types)
            ],
            'order' => [
                'required',
                'integer',
                'min:1',
                'max:100'
            ]
        ];
    }

    protected $messages = [
        'key.regex' => 'The input format is incorrect Should a-z (-|_).',
    ];

    public function updatedValue()
    {
        if ($this->type === 'image') {
            $this->validate([
                'value' => 'required|image|mimes:jpeg,png,jpg,svg|max:1024',
            ]);
        } elseif ($this->type === 'file') {
            $this->validate([
                'value' => 'required|file|mimes:pdf,doc,docx|max:10000',
            ]);
        } elseif ($this->type === 'text' or $this->type === 'textarea') {
            $this->validate([
                'value' => 'required|string|min:1|max:255',
            ]);
        }
    }

    public function updatingType()
    {
        $this->value = null;
    }

    public function create()
    {
        $this->validate();
        $data = [
            'key' => Str::slug($this->key),
            'display_name' => $this->display_name,
            'type' => $this->type,
            'order' => $this->order,
        ];

        if (!empty($this->value) and $this->type === 'image' or $this->type === 'file') {
            $url = $this->value->store('settings', 'public');
            $data['value'] = $url;
        } else {
            $data['value'] = $this->value;
        }

        Setting::create($data);
        $this->closeCreateModel();
        $this->notification()->success(
            $title = __('app.create') . ' ' . __('setting.setting'),
            $description = __('setting.created setting', ['name' => $data['name']])
        );
        $this->emit('refreshParent');
    }

    public function closeCreateModel()
    {
        $this->openCreateModel = false;
        $this->resetExcept('types');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.settings.settings-create');
    }
}
