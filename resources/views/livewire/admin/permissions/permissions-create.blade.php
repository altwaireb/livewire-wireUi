<div>
    <x-modal.card
            title="{{ __('app.create') }} {{ __('permissions.permission') }}"
            wire:model.defer="openCreateModel"
            blur
            hideClose
    >
        <form wire:submit.prevent="create" autocomplete="off">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="col-span-1 md:col-span-3">
                    <x-input
                            wire:model.defer="name"
                            label="{{ __('permissions.name') }}"
                            placeholder="{{ __('permissions.name') }}"
                            type="text"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-input
                            wire:model.defer="key"
                            label="{{ __('permissions.key') }}"
                            placeholder="{{ __('permissions.key') }}"
                            type="text"
                    />
                </div>
                <div class="col-span-1 md:col-span-3">
                    <x-input
                            wire:model.defer="table_name"
                            label="{{ __('permissions.table_name') }}"
                            placeholder="{{ __('permissions.table_name') }}"
                            type="text"
                    />
                </div>


            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <div class="flex gap-x-4">
                        <x-button
                                wire:click="closeCreateModel"
                                wire:target="closeCreateModel"
                                wire:loading.class="disabled"
                                :label="__('app.close')"
                                spinner="closeCreateModel"
                                flat
                        />
                        <x-button
                                wire:click="create"
                                wire:target="create"
                                wire:loading.class="disabled"
                                type="submit"
                                :label="__('app.save')"
                                spinner="create"
                                primary
                        />
                    </div>
                </div>
            </x-slot>
        </form>
    </x-modal.card>
</div>
