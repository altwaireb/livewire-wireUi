<!-- Profile menu -->
@auth
    <li
            x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
            x-cloak
            x-on:keydown.escape.prevent.stop="close($refs.button)"
            x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
            x-id="['dropdown-button']"
            class="relative"
    >
        <!-- Button -->
        <button
                x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                type="button"
                class="flex items-center gap-x-2 align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
        >
            <img
                    class="object-cover w-8 h-8 rounded-full"
                    src="{{ auth()->user()->profile_photo_url }}"
                    alt=""
                    alt="{{ auth()->user()->name }}"
                    aria-hidden="true"
            />
        </button>

        <!-- Panel -->
        <ul
                x-ref="panel"
                x-show="open"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click.outside="close($refs.button)"
                :id="$id('dropdown-button')"
                style="display: none;"
                class="absolute ltr:right-0 rtl:left-0 w-56 p-2 mt-2 space-y-2 text-secondary-600 bg-white border border-secondary-100 rounded-md shadow-md dark:border-secondary-700 dark:text-secondary-300 dark:bg-secondary-700"
        >
            <li class="flex">
                <a
                        class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-secondary-100 hover:text-secondary-800 dark:hover:bg-secondary-800 dark:hover:text-secondary-200"
                        href="{{ route('profile.show') }}"
                >
                    <x-icon name="user" class="w-4 h-4 ltr:mr-3 rtl:ml-3" />
                    <span>Profile</span>
                </a>
            </li>
            <li class="flex">
                <form method="POST" action="{{ route('logout') }}" class="w-full" x-data>
                    @csrf
                    <a
                            class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-secondary-100 hover:text-secondary-800 dark:hover:bg-secondary-800 dark:hover:text-secondary-200"
                            href="{{ route('logout') }}"
                            @click.prevent="$root.submit();"
                    >
                        <x-icon name="logout" class="w-4 h-4 ltr:mr-3 rtl:ml-3" />
                        <span>Log out</span>
                    </a>
                </form>
            </li>
        </ul>
    </li>
@endauth