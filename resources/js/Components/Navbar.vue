<script setup>
import { ref } from 'vue'
import { route } from 'ziggy-js'
import { Link, router, usePage } from '@inertiajs/vue3'

defineOptions({
    name: 'Navbar',
})

const page =usePage();

const search = ref('')
const profileOpen = ref(false)

function search_user(){
    router.get(route('users.index'),
        {
            search: search.value
        },{
        onSuccess:((success)=>{

        }),
        onError:((errors)=>{
            
        })
    });
}
</script>

<template>
    <nav class="flex h-16 items-center justify-between border-b bg-white px-6">

        <!-- Search -->
        <div class="relative w-96">
            <input
                v-model="search"
                type="text"
                @keyup.enter="search_user"
                placeholder="Search employees..."
                class="w-full rounded-lg border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            />

            <span class="absolute left-3 top-2.5 text-gray-400">
                🔍
            </span>
        </div>

        <!-- Right -->
        <div class="flex items-center gap-5">

            <!-- Notification -->
            <button
                type="button"
                class="relative rounded-lg p-2 text-gray-500 hover:bg-gray-100"
            >
                🔔

                <!-- Notification Badge -->
                <span
                    class="absolute right-1 top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] text-white"
                >
                    3
                </span>
            </button>

            <!-- User Profile -->
            <div class="relative">

                <button
                    type="button"
                    @click="profileOpen = !profileOpen"
                    class="flex items-center gap-3 rounded-lg p-2 hover:bg-gray-100"
                >
                    <!-- Avatar -->
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 font-semibold text-white"
                    >
                        A
                    </div>

                    <!-- User Info -->
                    <div class="hidden text-left sm:block">
                        <p class="text-sm font-semibold text-gray-800">
                            {{page?.props?.auth?.name}}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{page?.props?.auth?.roles?.[0].name}}
                        </p>
                    </div>

                    <span class="text-gray-400">
                        ▼
                    </span>
                </button>

                <!-- Profile Dropdown -->
                <div
                    v-if="profileOpen"
                    class="absolute right-0 top-14 z-50 w-48 rounded-lg border bg-white py-2 shadow-lg"
                >
                    <a
                        href="/profile"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                        Profile
                    </a>

                    <a
                        href="/profile/password"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    >
                        Change Password
                    </a>

                    <hr class="my-2">

                    <Link
                        :href="route('logout')"
                        type="button"
                        class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                    >
                        Logout
                    </Link>
                </div>

            </div>

        </div>

    </nav>
</template>