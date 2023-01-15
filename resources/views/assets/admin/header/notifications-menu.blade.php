<!-- Notifications menu -->
<li
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.buttonNotifications.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
        x-cloak
        x-on:keydown.escape.prevent.stop="close($refs.buttonNotifications)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['notification-button']"
        class="relative"
>
    <!-- Button -->
    <button
            x-ref="buttonNotifications"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('notification-button')"
            type="button"
            class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-primary"
    >
        <x-icon name="bell" class="w-5 h-5" solid />
        <!-- Notification badge -->
        <span
                aria-hidden="true"
                class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-secondary-800"
        ></span>
    </button>
    <ul
            x-ref="panel"
            x-show="open"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-on:click.outside="close($refs.buttonNotifications)"
            :id="$id('notification-button')"
            style="display: none;"
            class="absolute ltr:right-0 rtl:left-0 w-56 p-2 mt-2 space-y-2 text-secondary-600 bg-white border border-secondary-100 rounded-md shadow-md dark:border-secondary-700 dark:text-secondary-300 dark:bg-secondary-700"
    >
        <li class="flex">
            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-secondary-100 hover:text-secondary-800 dark:hover:bg-secondary-800 dark:hover:text-secondary-200"
               href="#">
                <span>Messages</span>
                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                    13
                </span>
            </a>
        </li>
        <li class="flex">
            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-secondary-100 hover:text-secondary-800 dark:hover:bg-secondary-800 dark:hover:text-secondary-200"
               href="#">
                <span>Sales</span>
                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                    2
                </span>
            </a>
        </li>
        <li class="flex">
            <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-secondary-100 hover:text-secondary-800 dark:hover:bg-secondary-800 dark:hover:text-secondary-200"
               href="#">
                <span>Alerts</span>
            </a>
        </li>
    </ul>
</li>