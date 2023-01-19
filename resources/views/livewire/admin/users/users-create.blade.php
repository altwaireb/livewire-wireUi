<div>
    <x-modal.card
            title="{{ __('app.create') }} {{ __('users.user') }}"
            wire:model.defer="openCreateModel"
            blur
            hideClose

    >
        <form wire:submit.prevent="create" autocomplete="off" >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input
                        wire:model.defer="username"
                        type="text"
                        label="{{ __('users.username') }}"
                        placeholder="{{ __('users.username') }}"
                        id="usernameCreate"
                />
                <x-input
                        wire:model.defer="name"
                        type="text"
                        label="{{ __('users.name') }}"
                        placeholder="{{ __('users.name') }}"
                        id="nameCreate"
                />
                <x-input
                        wire:model.defer="email"
                        type="email"
                        label="{{ __('users.email') }}"
                        placeholder="example@mail.com"
                        id="emailCreate"
                />

                <x-select
                        :label="__('users.role')"
                        :placeholder="__('app.select').' '.__('users.role')"
                        :options="$roles"
                        wire:model.defer="role_id"
                        id="roleCreate"
                        option-label="name"
                        option-value="id"
                        :empty-message="__('wireui::messages.empty_options')"
                        :clearable="false"
                />

                <x-inputs.password
                        wire:model.defer="password"
                        label="{{ __('users.password') }}"
                        id="passwordCreate"

                />
                <x-input
                        wire:model.defer="password_confirmation"
                        type="password"
                        label="{{ __('users.confirm password') }}"
                        required
                        autocomplete="new-password"
                        id="password_confirmation_Create"

                />

                <div class="col-span-2 md:col-span-4 lg:col-span-2 lg:row-span-2 order-last lg:order-none">
                    <div class="flex flex-row items-center justify-center">
                        <div class="relative mt-4">
                            <div class="w-24 h-24 bg-secondary-200 dark:bg-secondary-700 rounded-full">
                                @if(!empty($profilePhotoPath))
                                    <img src="{{ $profilePhotoPath->temporaryUrl() }}"
                                         class="object-cover w-24 h-24 rounded-full">

                                @else
                                    <x-avatar size="w-24 h-24" label="" />
                                @endif
                            </div>
                            <span class="absolute bottom-0 rtl:left-0 ltr:right-0 w-8 h-8 p-2 rounded-full bg-primary-600 shadow-md">
                                <label>
                                    <x-icon
                                            wire:target="profilePhotoPath"
                                            wire:loading.class="animate-bounce"
                                            name="upload"
                                            class="w-4 h-4 text-white"/>
                                    <input
                                            wire:model="profilePhotoPath"
                                            type="file"
                                            accept="image/png, image/jpeg"
                                            class="hidden opacity-0"
                                            id="profilePhotoPathCreate"
                                    >
                                </label>
                            </span>
                            <x-error name="profilePhotoPath" class="mt-2"/>
                        </div>
                    </div>
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

