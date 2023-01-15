<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\User;
use App\View\Components\AdminLayout;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $user = 1;
    public $users;
    public $simpleModal = false;
    public $date = '2022-12-06';

    public function mount(){
//        $this->users = User::pluck('name','id')->toArray();
//        $this->users = User::select('id','name','email')->get()->toArray();
    }

    public function openModal(){
        $this->simpleModal = true;
    }
    public function closeModal(){
        $this->simpleModal = false;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dashboard-index')
            ->layout(AdminLayout::class);
    }
}
