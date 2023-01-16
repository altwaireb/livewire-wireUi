<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class UsersCreate extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    use Actions;

    public bool $openCreateModel = false;

    // Attributes Model
    public string|null $username = null;
    public string|null $name = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $password_confirmation = null;
    public $profilePhotoPath = null;
    public int|null $role_id = null;

    // Relationships
    public array $roles = [];

    protected $listeners = ['openCreateModel'];

    protected function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'lowercase',
                'min:5',
                'max:25',
                'regex:/^([a-z])+?(_)?([a-z0-9])+$/i',
                'unique:users'
            ],
            'name' => [
                'required',
                'string',
                'min:5',
                'max:50'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'role_id' => [
                'required',
                'integer',
                'exists:App\Models\Role,id'
            ],
            'profilePhotoPath' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:1024'
            ],

        ];
    }

    public function mount($roles)
    {
        $this->roles = $roles;
    }

    public function openCreateModel()
    {
        $this->openCreateModel = true;

    }

    public function updatedProfilePhotoPath()
    {
        $this->validate([
            'profilePhotoPath' => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
    }


    public function create()
    {
        $this->validate();
        $this->authorize('create', User::class);

        $data = [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'password' => Hash::make($this->password)
        ];

        // Check if add new photo
        if (!empty($this->profilePhotoPath)) {
            $url = $this->profilePhotoPath->store('profile-photos', 'public');
            $data['profile_photo_path'] = $url;
        } else {
            $data['profile_photo_path'] = null;
        }

        User::create($data);
        $this->closeCreateModel();
        $this->notification()->success(
            $title = __('app.create') . ' ' . __('user.user'),
            $description = __('user.created user', ['name' => $data['name']])
        );
        $this->emit('refreshParent');

    }

    public function closeCreateModel()
    {
        $this->openCreateModel = false;
        $this->resetExcept('roles');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.users.users-create');
    }
}
