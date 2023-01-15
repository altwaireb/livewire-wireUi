@props([
'value' => null,
'sortable'=>'',
'direction'
])

@php
$classSortable = $sortable != '' ?  'cursor-pointer' : '';
@endphp

<th {{ $attributes->merge(['class' => "px-4 py-3 text-center group $classSortable"]) }}>
    <span class="px-1">{{ $value ?? $slot }}</span>
    @if(!empty($sortable))
        @if($direction === 'asc')
            <span class="group-hover:visible invisible">&#9650;</span>
        @elseif ($direction == 'desc')
            <span class="group-hover:visible invisible">&#9660;</span>
        @endif
    @endif
</th>

