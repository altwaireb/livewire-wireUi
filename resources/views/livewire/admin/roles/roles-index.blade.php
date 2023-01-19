<div class="space-y-6">
    @section('page-title', __('roles.roles'))

    <x-card cardClasses="my-6" title="{{ __('roles.roles') }}">
        <x-slot:action class="items-center justify-center">
            @can('create',\App\Models\Role::class)
                <x-button
                        wire:click="$emit('openCreateModel')"
                        label="{{ __('app.create') .' '. __('roles.role') }}"
                        wire:loading.class="disabled"
                        icon="plus" primary
                />
            @endcan
        </x-slot:action>

        <div class="grid gap-x-3 mb-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-8">
            <div class="col-span-3">
                <x-input
                        wire:model="search"
                        :label="__('app.search')"
                        :placeholder="__('app.searchInput')"
                        class="ltr:pl-12 rtl:pr-12"
                >
                    <x-slot name="prepend">
                        <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 flex items-center p-0.5">
                            <x-button
                                    wire:click="resetSearch"
                                    {{ empty($search) ? 'disabled' : ''  }}
                                    class="h-full ltr:rounded-l-md rtl:rounded-r-md"
                                    icon="minus-circle" primary flat squared
                            />
                        </div>
                    </x-slot>
                </x-input>
            </div>

            <div class="col-span-2">
                <x-select
                        :label="__('app.search by').' '.__('roles.permission')"
                        :placeholder="__('app.select').' '.__('roles.permission')"
                        wire:model="permissionSearch"
                        :options="$permissions->toArray()"
                        option-label="name"
                        option-value="id"
                        option-description="table_name"
                        :empty-message="__('wireui::messages.empty_options')"
                />
            </div>

            <div class="xl:col-start-8 xl:col-end-8 items-end justify-end">
                <x-select
                        label="{{ __('app.PerPage') }}"
                        :options="[10, 25, 50, 100]"
                        wire:model="perPage"
                        :clearable="false"
                />
            </div>

        </div>
    </x-card>

    <div class="w-full overflow-hidden rounded-lg">
        <div class="w-full overflow-x-auto shadow-xs">
            <x-table>
                <x-slot:header>
                    <x-table.heading
                            sortable
                            value="#"
                            wire:click="sortBy('id')"
                            class="px-2 py-3"
                            :direction="$sortBy === 'id' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.name')"
                            wire:click="sortBy('name')"
                            :direction="$sortBy === 'name' ? $sortDirection : null"
                            class="ltr:text-left rtl:text-right"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.key')"
                            wire:click="sortBy('key')"
                            :direction="$sortBy === 'key' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.color')"
                            wire:click="sortBy('color')"
                            :direction="$sortBy === 'color' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.default')"
                            wire:click="sortBy('default')"
                            :direction="$sortBy === 'default' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.users_count')"
                            wire:click="sortBy('users_count')"
                            :direction="$sortBy === 'users_count' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('roles.permissions_count')"
                            wire:click="sortBy('permissions_count')"
                            :direction="$sortBy === 'permissions_count' ? $sortDirection : null"
                    />
                    <x-table.heading
                            sortable
                            :value="__('app.created_at')"
                            wire:click="sortBy('created_at')"
                            :direction="$sortBy === 'created_at' ? $sortDirection : null"
                    />
                    <x-table.heading
                            :value="__('app.actions')"
                            class="px-4 py-3 w-16"
                    />
                </x-slot:header>
                @forelse($items as $item)
                    <x-table.row wire:key="items-{{ $item->id }}">
                        <x-table.cell :value="$item->id" class="px-2 py-3 text-center"/>
                        <x-table.cell :value="$item->name" />
                        <x-table.cell :value="$item->key" class="text-center" />
                        <x-table.cell class="text-center" >
                            <x-badge-role-user
                                    :color="$item->color"
                                    :label="$item->name"
                            />
                        </x-table.cell>
                        <x-table.cell class="text-center" >
                            @if($item->default)
                                {{ __('app.true') }}
                            @else
                                {{ __('app.false') }}
                            @endif
                        </x-table.cell>
                        <x-table.cell :value="$item->users_count" class="text-center" />
                        <x-table.cell :value="$item->permissions_count" class="text-center" />
                        <x-table.cell
                                :value="date('Y-m-d H:i', strtotime($item->created_at))"
                                class="text-center text-xs"
                        />
                        <x-table.cell>
                            <div class="flex justify-center items-center gap-x-1">
                                @can('update',$item)
                                    <x-button.circle
                                            wire:click="$emit('openUpdateModel',{{$item->id}})"
                                            icon="pencil" primary flat
                                    />
                                @endcan

                                @can('view',$item)
                                    <x-button.circle
                                            wire:click="$emit('openShowModel',{{$item->id}})"
                                            icon="eye" primary flat
                                    />
                                @endcan

                                @can('delete',$item)
                                    <x-button.circle
                                            wire:click="$emit('openDeleteModel',{{$item->id}})"
                                            icon="trash" primary flat
                                    />
                                @endcan
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row class="text-center">
                        <x-table.cell :value="__('app.no data')" colspan="8"/>
                    </x-table.row>
                @endforelse
            </x-table>
        </div>
        @if(!empty($items))
            <div class="px-4 py-3 border-t dark:border-secondary-700 bg-white divide-y dark:divide-secondary-700 dark:bg-secondary-800">
                {!! $items->links() !!}
            </div>
        @endif
    </div>

    <livewire:admin.roles.roles-create :permissions="$permissions"/>
</div>