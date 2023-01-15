<div>
    <x-modal.card
            title="{{ __('app.update') }} {{ __('user.user') }}"
            wire:model.defer="openUpdateModel"
            blur
            hideClose

    >
        <form wire:submit.prevent="edit" autocomplete="off">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input
                        wire:model.defer="username"
                        type="text"
                        label="{{ __('user.username') }}"
                        placeholder="{{ __('user.username') }}"
                        id="usernameUpdate"
                />
                <x-input
                        wire:model.defer="name"
                        type="text"
                        label="{{ __('user.name') }}"
                        placeholder="{{ __('user.name') }}"
                        id="nameUpdate"
                />
                <x-input
                        wire:model.defer="email"
                        type="email"
                        label="{{ __('user.email') }}"
                        placeholder="example@mail.com"
                        id="emailUpdate"
                />

                <x-select
                        :label="__('user.role')"
                        :placeholder="__('app.select').' '.__('user.role')"
                        :options="$roles"
                        wire:model.defer="role_id"
                        id="roleUpdate"
                        option-label="name"
                        option-value="id"
                        :empty-message="__('wireui::messages.empty_options')"
                        :clearable="false"
                />

                <x-inputs.password
                        wire:model.defer="password"
                        label="{{ __('user.password') }}"
                        id="passwordUpdate"
                />
                <x-input
                        wire:model.defer="password_confirmation"
                        type="password"
                        label="{{ __('user.confirm password') }}"
                        required
                        autocomplete="new-password"
                        id="password_confirmation_Update"
                />

                <div class="col-span-2 md:col-span-4 lg:col-span-2 lg:row-span-2 order-last lg:order-none">
                    <div class="flex flex-row items-center justify-center">
                        <div class="relative mt-4">
                            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full">
                                @if(!empty($photo))

                                    <img src="{{ $photo->temporaryUrl() }}"
                                         class="object-cover w-24 h-24 rounded-full">

                                @elseif(!empty($profile_photo_path))
                                    <img src="{{ $profile_photo_path }}"
                                         class="object-cover w-24 h-24 rounded-full">
                                @endif
                            </div>
                            <span class="absolute bottom-0 rtl:left-0 ltr:right-0 w-8 h-8 p-2 rounded-full bg-primary-600 shadow-md">
                                <label>
                                    <x-icon
                                            wire:target="photo"
                                            wire:loading.class="animate-bounce"
                                            name="upload"
                                            class="w-4 h-4 text-white"/>
                                    <input
                                            wire:model="photo"
                                            type="file"
                                            accept="image/png, image/jpeg"
                                            class="hidden opacity-0"
                                            id="photoUpdate"
                                    >
                                </label>
                            </span>
                            <x-error name="photo" class="mt-2"/>
                        </div>
                    </div>
                </div>

            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <div class="flex gap-x-4">
                        <x-button
                                wire:click="closeUpdateModel"
                                wire:target="closeUpdateModel"
                                wire:loading.class="disabled"
                                :label="__('app.close')"
                                spinner="closeUpdateModel"
                                flat
                        />
                        <x-button
                                wire:click="edit"
                                wire:target="edit"
                                wire:loading.class="disabled"
                                type="submit"
                                :label="__('app.save')"
                                spinner="edit"
                                primary
                        />
                    </div>
                </div>
            </x-slot>
        </form>
    </x-modal.card>
</div>
