<label {{ $attributes->class([
        'block text-sm font-medium',
        'text-negative-600'  => $hasError,
        'opacity-60'         => $attributes->get('disabled'),
        'text-secondary-700 dark:text-secondary-400' => !$hasError,
    ]) }}>
    {{ $label ?? $slot }}
</label>
