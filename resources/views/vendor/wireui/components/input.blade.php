@php
    $hasError = !$errorless && $name && $errors->has($name);
@endphp

<div class="@if($disabled) opacity-60 @endif">
    @if ($label || $cornerHint)
        <div class="flex {{ !$label && $cornerHint ? 'justify-end' : 'justify-between' }} mb-1">
            @if ($label)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$label"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif

            @if ($cornerHint)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$cornerHint"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif
        </div>
    @endif

    <div class="relative rounded-md @unless($shadowless) shadow-sm @endunless">
        @if ($prefix || $icon)
            <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 ltr:pl-2.5 rtl:pr-2.5 flex items-center pointer-events-none
                {{ $hasError ? 'text-negative-500' : 'text-secondary-400' }}">
                @if ($icon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$icon"
                        class="w-5 h-5"
                    />
                @elseif($prefix)
                    <span class="flex items-center self-center ltr:pl-1 rtl:pr-1">
                        {{ $prefix }}
                    </span>
                @endif
            </div>
        @elseif($prepend)
            {{ $prepend }}
        @endif

        <input {{ $attributes->class([
                $getInputClasses($hasError),
            ])->merge([
                'type'         => 'text',
                'autocomplete' => 'off',
            ]) }} />

        @if ($suffix || $rightIcon || ($hasError && !$append))
            <div class="absolute inset-y-0 ltr:right-0 rtl:left-0 ltr:pr-2.5 rtl:pl-2.5 flex items-center pointer-events-none
                {{ $hasError ? 'text-negative-500' : 'text-secondary-400' }}">
                @if ($rightIcon)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        :name="$rightIcon"
                        class="w-5 h-5"
                    />
                @elseif ($suffix)
                    <span class="flex items-center justify-center ltr:pr-1 rtl:pl-1">
                        {{ $suffix }}
                    </span>
                @elseif ($hasError)
                    <x-dynamic-component
                        :component="WireUi::component('icon')"
                        name="exclamation-circle"
                        class="w-5 h-5"
                    />
                @endif
            </div>
        @elseif ($append)
            {{ $append }}
        @endif
    </div>

    @if (!$hasError && $hint)
        <label @if ($id) for="{{ $id }}" @endif class="mt-2 text-sm text-secondary-500 dark:text-secondary-400">
            {{ $hint }}
        </label>
    @endif

    @if ($name && !$errorless)
        <x-dynamic-component
            :component="WireUi::component('error')"
            :name="$name"
        />
    @endif
</div>
