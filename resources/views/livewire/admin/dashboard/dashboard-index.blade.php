<div class="px-5 pt-10">
    @section('page-title', __('dashboard.index'))

    @can('administrator')
        <div class="grid grid-cols-2 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
            <x-card-info
                    :title="__('dashboard.users_count')"
                    :value="$users_count"
                    icon="user-group"
            />
            <x-card-info
                    :title="__('dashboard.registeredThisDay')"
                    :value="$registeredThisDay"
                    icon="user-add"
                    iconClasses="bg-green-600 text-green-100 dark:bg-green-800 dark:text-green-100"
            />
            <x-card-info
                    :title="__('dashboard.registeredThisWeek')"
                    :value="$registeredThisWeek"
                    icon="user-add"
                    iconClasses="bg-cyan-600 text-cyan-100 dark:bg-cyan-800 dark:text-cyan-100"
            />
            <x-card-info
                    :title="__('dashboard.registeredThisMonth')"
                    :value="$registeredThisMonth" icon="user-add"
                    iconClasses="bg-fuchsia-600 text-fuchsia-100 dark:bg-fuchsia-800 dark:text-fuchsia-100"
            />
            <x-card-info
                    :title="__('dashboard.registeredThisYear')"
                    :value="$registeredThisYear" icon="user-add"
                    class="bg-primary-500 dark:bg-primary-600"
                    titleClasses="text-secondary-200 dark:text-secondary-300"
                    valueClasses="text-secondary-100 dark:text-secondary-200"
                    iconClasses="bg-transparent"
            />
            <x-card-info
                    :title="__('dashboard.users_trashed_count')"
                    :value="$users_trashed_count"
                    icon="user-remove"
                    iconClasses="bg-negative-600 text-negative-100 dark:bg-negative-800 dark:text-negative-100"
            />
        </div>
    @endcan

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-1 lg:grid-cols-2">
        <!-- Latest Users -->
        <x-card :title="__('dashboard.latest_users')" padding="p-0"
                headerClasses="text-secondary-100 dark:text-secondary-200 bg-gradient-to-r from-primary-700 via-primary-500 to-primary-600 rounded-t-lg">
            <x-table>
                <x-slot:header>
                    <x-table.heading :value="__('users.name') . ' / ' . __('users.username')"
                                     class="text-xs ltr:text-left rtl:text-right"/>
                    <x-table.heading :value="__('users.role')"/>
                    <x-table.heading :value="__('app.created_at')"/>
                </x-slot:header>
                @forelse($latest_users as $user)
                    <x-table.row>
                        <x-table.cell>
                            <x-table.card :title="$user->name" :subtitle="$user->username"
                                          :image="$user->profile_photo_url" :active="$user->isOnline()"/>
                        </x-table.cell>
                        <x-table.cell class="text-xs text-center">
                            @if ($user->role)
                                <x-badge-role-user :color="$user->role?->color" :label="$user->role?->name"/>
                            @endif
                        </x-table.cell>
                        <x-table.cell class="text-center truncate" :value="$user->created_at->diffForHumans()"/>
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="3"/>
                    </x-table.row>
                @endforelse
            </x-table>
        </x-card>

        <!-- Latest Activity Users -->
        <x-card :title="__('dashboard.latest_activity_users')" padding="p-0"
                headerClasses="text-secondary-100 dark:text-secondary-200 bg-gradient-to-r from-primary-700 via-primary-500 to-primary-600 rounded-t-lg">
            <x-table>
                <x-slot:header>
                    <x-table.heading :value="__('users.name') . ' / ' . __('users.username')"
                                     class="text-xs ltr:text-left rtl:text-right"/>
                    <x-table.heading :value="__('users.role')"/>
                    <x-table.heading :value="__('users.last_activity')"/>
                </x-slot:header>
                @forelse($latest_activity_users as $user)
                    <x-table.row>
                        <x-table.cell>
                            <x-table.card :title="$user->name" :subtitle="$user->username"
                                          :image="$user->profile_photo_url" :active="$user->isOnline()"/>
                        </x-table.cell>
                        <x-table.cell class="text-xs text-center">
                            @if ($user->role)
                                <x-badge-role-user :color="$user->role?->color" :label="$user->role?->name"/>
                            @endif
                        </x-table.cell>
                        <x-table.cell class="text-center truncate" :value="$user->lastActivityForHumans"/>
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="3"/>
                    </x-table.row>
                @endforelse
            </x-table>
        </x-card>
    </div>


</div>
