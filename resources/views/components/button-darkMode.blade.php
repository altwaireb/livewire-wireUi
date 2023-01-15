<button
        class="rounded-md focus:outline-none focus:shadow-outline-primary"
        x-on:click="
                                if (darkMode === 'light'){
                                darkMode = 'dark'
                                }else{
                                darkMode = 'light'
                                }
                                "
        aria-label="Toggle color mode"
>
    <template x-if="darkMode === 'light'">
        <x-icon name="moon" class="w-5 h-5" solid/>
    </template>
    <template x-if="darkMode === 'dark'">
        <x-icon name="sun" class="w-5 h-5" solid/>
    </template>

    <template x-if="darkMode !== 'dark' && darkMode !== 'light'">
        <x-icon name="moon" class="w-5 h-5" solid/>
    </template>
</button>
