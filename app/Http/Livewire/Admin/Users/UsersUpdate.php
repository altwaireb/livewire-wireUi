<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class UsersUpdate extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;
    use Actions;

    public bool $openUpdateModel = false;

    //  Model
    public $user;

    // Attributes Model
    public string|null $username = null;
    public string|null $name = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $password_confirmation = null;
    public string|null $profile_photo_path = null;
    public int|null $role_id = null;

    // Update New Photo
    public $photo;

    // Relationships
    public array $roles = [];

    protected $listeners = ['openUpdateModel'];

    protected function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'lowercase',
                'min:5',
                'max:25',
                'regex:/^([a-z])+?([a-z0-9])+?(_)?([a-z0-9])+$/i',
                'unique:users,username,' . $this->user->id
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
                'unique:users,email,' . $this->user->id
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed'
            ],
            'role_id' => [
                'required',
                'integer',
                'exists:App\Models\Role,id'
            ],
            'photo' => [
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

    public function openUpdateModel(User $user)
    {
        $this->user = $user;
        $this->openUpdateModel = true;

        $this->authorize('update', $this->user);

        $this->username = $this->user->username;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
        $this->profile_photo_path = $this->user->profile_photo_url;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
    }

    public function updatedPassword()
    {
        $this->validate([
            'password' => 'string|min:8|confirmed',
        ]);
    }


    public function edit()
    {
        $this->validate();
        $this->authorize('update', $this->user);
        $data = [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        // Check if add new photo
        if (!empty($this->photo)) {
            $url = $this->photo->store('profile-photos', 'public');
            $data['profile_photo_path'] = $url;
        }

        // Check if add new password
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);
        $this->closeUpdateModel();
        $this->notification()->success(
            $title = __('app.update') . ' ' . __('users.user'),
            $description = __('users.updated user', ['name' => $data['name']])
        );
        $this->emit('refreshParent');

    }

    public function closeUpdateModel()
    {
        $this->openUpdateModel = false;
        $this->resetExcept('roles');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.admin.users.users-update');
    }
}
