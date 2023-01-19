<div>
        <label for="{{ $id }}" class="flex items-center {{ $errors->has($name) ? 'text-negative-600':'' }}">
            <div class="relative flex items-start">
                @if ($leftLabel)
                    <div class="ltr:mr-2 rtl:ml-2 text-sm ltr:text-right rtl:text-left">
                        <x-dynamic-component
                            :component="WireUi::component('label')"
                            class=""
                            :for="$id"
                            :label="$leftLabel"
                            :has-error="$errors->has($name)"
                        />
                        @if($description)
                            <div class="text-secondary-500">{{ $description }}</div>
                        @endif
                    </div>
                @endif

                <div class="flex items-center h-5">
                    <input {{ $attributes->class([
                        $getClasses($errors->has($name)),
                    ])->merge([
                        'type'  => 'checkbox',
                        'class' => 'checked:bg-primary-600 dark:checked:bg-primary-600',
                    ]) }} />
                </div>

                @if ($label)
                    <div class="ltr:ml-2 rtl:mr-2 text-sm">
                        <x-dynamic-component
                            :component="WireUi::component('label')"
                            class=""
                            :for="$id"
                            :label="$label"
                            :has-error="$errors->has($name)"
                        />
                        @if($description)
                            <div id="{{ $id }} . comments-description" class="text-secondary-500">{{ $description }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </label>

    @if ($name)
        <x-dynamic-component
            :component="WireUi::component('error')"
            :name="$name"
        />
    @endif
</div>
