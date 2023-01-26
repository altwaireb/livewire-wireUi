<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Role;
use App\Models\User;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $rolesData;
    public array $rolesLabels = [];
    public array $rolesValues = [];
    public array $rolesColors = [];


    public function render()
    {

        return view('livewire.admin.dashboard.dashboard-index', [
            // Users Count
            'users_count' => User::count(),
            'registeredThisDay' => User::where('created_at', '>=', Carbon::now()->startOfDay())->count(),
            'registeredThisWeek' => User::where('created_at', '>=', Carbon::now()->startOfWeek(\Carbon\Carbon::SATURDAY)->startOfDay())->count(), // default startOfWeek() is Monday
            'registeredThisMonth' => User::where('created_at', '>=', Carbon::now()->firstOfMonth()->startOfMonth()->startOfDay())->count(),
            'registeredThisYear' => User::where('created_at', '>=', Carbon::now()->firstOfMonth()->startOfMonth()->startOfDay())->count(),
            'users_trashed_count' => User::onlyTrashed()->count(),

            'latest_users' => User::latest()->take(5)
                ->select('id', 'name', 'username', 'role_id', 'created_at')
                ->with('role')->get(),

            'latest_activity_users' => User::whereNotNull('last_activity')
                ->where('id','!=', auth()->id())
                ->orderBy('last_activity','desc')->take(5)
                ->select('id', 'name', 'username', 'role_id','last_activity')
                ->with('role')->get(),

        ])->layout(AdminLayout::class);
    }
}
