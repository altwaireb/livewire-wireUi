<div>
    @if($openShowModel)
        <x-modal.card
                title="{{ __('app.show') }} {{ __('users.user') }}"
                wire:model.defer="openShowModel"
                blur
                hideClose

        >
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 px-4">

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('users.username')"
                            :value="$item->username"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('users.name')"
                            :value="$item->name"
                    />
                </div>

                <div class="col-span-1 md:col-span-1 order-last md:order-none row-span-2 flex items-center justify-center">
                    <x-avatar size="w-18 h-18" src="{{ $item->profile_photo_url }}"/>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label :label="__('users.role')">
                        <x-badge-role-user
                                :color="$item->role->color"
                                :label="$item->role->name"
                        />
                    </x-item-with-label>
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-item-with-label
                            :label="__('users.email')"
                            :value="$item->email"
                    />
                </div>
                @if(!empty($item->last_activity))
                    <div class="col-span-1 md:col-span-2">
                        <x-item-with-label
                                :label="__('users.last_activity')"
                                :value="$item->last_activity"
                        />
                    </div>
                @endif

                <div class="col-span-1 md:col-span-2">
                    <x-item-with-label
                            :label="__('app.created_at')"
                            :value="$item->created_at"
                    />
                </div>

                @if(!empty($item->updated_at) && $item->created_at != $item->updated_at)
                    <div class="col-span-1 md:col-span-2">
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

