<div>
    @if($openShowModel)
        <x-modal.card
                title="{{ __('app.show') }} {{ __('roles.role') }}"
                wire:model.defer="openShowModel"
                blur
                hideClose
                max-width="4xl"
        >
            <div class="grid grid-cols-2 md:grid-cols-10 gap-4 px-4">

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('roles.name')"
                            :value="$item->name"
                    />
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('roles.key')"
                            :value="$item->key"
                    />
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label :label="__('roles.default')">
                        @if($item->default)
                            {{ __('app.true') }}
                        @else
                            {{ __('app.false') }}
                        @endif
                    </x-item-with-label>
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('roles.users_count')"
                            :value="$item->users_count"
                    />
                </div>
                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('roles.permissions_count')"
                            :value="$item->permissions_count"
                    />
                </div>
                <div class="col-span-1 md:col-span-10">
                    <x-item-with-label :label="__('roles.color')">
                        <div class="flex flex-row gap-x-3">
                            <div class="w-1/2 text-center bg-secondary-50 p-2 rounded drop-shadow">
                                <span class="text-xs text-secondary-600 dark:text-secondary-600 block pb-0.5">Light mode</span>
                                <x-badge-role-user
                                        color="{{ !empty($item->color) ? $item->color : '#000' }}"
                                        label="{{ !empty($item->name) ? $item->name : 'text' }}"
                                />
                            </div>
                            <div class="w-1/2 text-center bg-secondary-800 dark:bg-secondary-900/40 p-2 rounded drop-shadow">
                                <span class="text-xs text-secondary-300 dark:text-secondary-400 block pb-0.5">Dark mode</span>
                                <x-badge-role-user
                                        color="{{ !empty($item->color) ? $item->color : '#000' }}"
                                        label="{{ !empty($item->name) ? $item->name : 'text' }}"
                                />
                            </div>
                        </div>
                    </x-item-with-label>
                </div>
                <div class="col-span-2 md:col-span-10">
                    <x-item-with-label class="items-center" :label="__('roles.permissions')">
                        <div class="overflow-y-auto scroll-smooth h-48">
                            @forelse($item->permissions->unique('table_name')->pluck('table_name') as $key => $value)
                                <div class="py-2">
                                    <x-item-with-label
                                            label="{{ !empty($value) ? __(''.$value.'.'.$value.'')  : __('app.general') }}"
                                    >
                                        <div class="flex flex-wrap gap-4">
                                            @foreach($item->permissions as $permission)
                                                @if($permission->table_name === $value)
                                                    <p class="text-xs border p-2 rounded-md dark:border-secondary-600">{{ !empty($value) ? __(''.$value.'.'.$permission->name.'')  :  __('app.'.$permission->name.'') }}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </x-item-with-label>
                                </div>
                            @empty
                                <div class="text-red-700">{{ __('app.no data') }}</div>
                            @endforelse
                        </div>

                    </x-item-with-label>
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('app.created_at')"
                            :value="$item->created_at"
                    />
                </div>

                @if(!empty($item->updated_at) && $item->created_at != $item->updated_at)
                    <div class="col-span-1 md:col-span-3">
                        <x-item-with-label
                                :label="__('app.updated_at')"
                                :value="$item->updated_at"
                        />
                    </div>
                @endif

            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <div class="flex gap-x-4">
                        <x-button
                                wire:click="closeShowModel"
                                wire:target="closeShowModel"
                                wire:loading.class="disabled"
                                :label="__('app.close')"
                                spinner="closeShowModel"
                                flat
                        />
                    </div>
                </div>
            </x-slot>
        </x-modal.card>
    @endif
</div>
