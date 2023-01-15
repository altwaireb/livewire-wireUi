@props([
// default color user
'color' => '#000',
'label',
])
<span
        style="background-color: {{$color}};"
        class="outline-none inline-flex justify-center items-center group rounded-full gap-x-1 text-xs leading-tight px-2.5 py-0.5 text-white">
    {{ $label ?? $slot }}
</span>