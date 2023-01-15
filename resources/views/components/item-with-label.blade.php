@props([
'label',
'value',
])
<div class="w-full">
    @if(isset($label))
        <div class="px-4 py-0.5 w-40 ltr:text-left rtl:text-right rounded-t-md bg-secondary-300 dark:bg-secondary-400 text-secondary-700 dark:text-secondary-800">
            <span class="text-sm">{{ $label }}</span>
        </div>
    @endif

    <div
        {{ $attributes->merge(['class' => "px-4 py-2 w-full rounded-md ltr:rounded-tl-none rtl:rounded-tr-none border border-secondary-300 dark:border-secondary-400 dark:text-secondary-400"])}}>
    {{ $value ?? $slot }}
    </div>
</div>