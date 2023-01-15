@props([
// your table headers in <th></th> tags
'header' => '',
])

<table class="w-full whitespace-no-wrap">
    <thead class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    <tr class="text-xs font-semibold tracking-wide text-center
    text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50
    dark:text-gray-400 dark:bg-gray-800"
    >
        {{ $header }}
    </tr>
    </thead>
    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
    {{ $slot }}
    </tbody>
</table>
