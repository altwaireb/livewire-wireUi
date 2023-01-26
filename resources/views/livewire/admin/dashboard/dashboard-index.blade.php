<div class="px-5 pt-10">
    @section('page-title', __('app.dashboard'))

    @can('administrator')
        <div class="grid grid-cols-2 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
            <x-card-info :title="__('dashboard.users_count')" :value="$users_count" icon="user-group" />
            <x-card-info :title="__('dashboard.registeredThisDay')" :value="$registeredThisDay" icon="user-group" iconClasses="bg-green-400 dark:bg-green-700" />
            <x-card-info :title="__('dashboard.registeredThisWeek')" :value="$registeredThisWeek" icon="user-group" iconClasses="dark:bg-cyan-500" />
            <x-card-info :title="__('dashboard.registeredThisMonth')" :value="$registeredThisMonth" icon="user-group" iconClasses="dark:bg-indigo-700" />
            <x-card-info :title="__('dashboard.registeredThisYear')" :value="$registeredThisYear" icon="user-group" iconClasses="dark:bg-fuchsia-700" />
            <x-card-info :title="__('dashboard.users_trashed_count')" :value="$users_trashed_count" icon="user-remove" iconClasses="dark:bg-red-700" />
        </div>
    @endcan

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-1 lg:grid-cols-2">
        <!-- Latest Users -->
        <x-card :title="__('dashboard.latest_users')" padding="p-0"
            headerClasses="text-secondary-100 dark:text-secondary-200 bg-gradient-to-r from-primary-700 via-primary-500 to-primary-600 rounded-t-lg">
            <x-table>
                <x-slot:header>
                    <x-table.heading :value="__('users.name') . ' / ' . __('users.username')" class="text-xs ltr:text-left rtl:text-right" />
                    <x-table.heading :value="__('users.role')" />
                    <x-table.heading :value="__('app.created_at')" />
                </x-slot:header>
                @forelse($latest_users as $user)
                    <x-table.row>
                        <x-table.cell>
                            <x-table.card :title="$user->name" :subtitle="$user->username" :image="$user->profile_photo_url" :active="$user->isOnline()" />
                        </x-table.cell>
                        <x-table.cell class="text-xs text-center">
                            @if ($user->role)
                                <x-badge-role-user :color="$user->role?->color" :label="$user->role?->name" />
                            @endif
                        </x-table.cell>
                        <x-table.cell class="text-center truncate" :value="$user->created_at->diffForHumans()" />
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="3" />
                    </x-table.row>
                @endforelse
            </x-table>
        </x-card>

        <!-- Latest Activity Users -->
        <x-card :title="__('dashboard.latest_activity_users')" padding="p-0"
            headerClasses="text-secondary-100 dark:text-secondary-200 bg-gradient-to-r from-primary-700 via-primary-500 to-primary-600 rounded-t-lg">
            <x-table>
                <x-slot:header>
                    <x-table.heading :value="__('users.name') . ' / ' . __('users.username')" class="text-xs ltr:text-left rtl:text-right" />
                    <x-table.heading :value="__('users.role')" />
                    <x-table.heading :value="__('users.last_activity')" />
                </x-slot:header>
                @forelse($latest_activity_users as $user)
                    <x-table.row>
                        <x-table.cell>
                            <x-table.card :title="$user->name" :subtitle="$user->username" :image="$user->profile_photo_url" :active="$user->isOnline()" />
                        </x-table.cell>
                        <x-table.cell class="text-xs text-center">
                            @if ($user->role)
                                <x-badge-role-user :color="$user->role?->color" :label="$user->role?->name" />
                            @endif
                        </x-table.cell>
                        <x-table.cell class="text-center truncate" :value="$user->lastActivityForHumans" />
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="3" />
                    </x-table.row>
                @endforelse
            </x-table>
        </x-card>
    </div>


</div>
