<script setup>

defineOptions({
    name:"RoleCreate"
})

const props=defineProps({})
</script>
<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-5xl mx-auto">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Create Role
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Create a role and assign permissions.
                    </p>
                </div>

                <button
                    class="flex items-center gap-2 px-5 py-2.5
                           bg-gray-900 text-white text-sm font-medium
                           rounded-lg hover:bg-gray-800 transition"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Create Role
                </button>
            </div>

            <!-- Main Card -->
            <div
                class="bg-white border border-gray-200
                       rounded-xl shadow-sm overflow-hidden"
            >

                <!-- Role Information -->
                <div class="p-6 border-b border-gray-200">
                    <div class="max-w-xl">

                        <label
                            class="block text-sm font-medium
                                   text-gray-700 mb-2"
                        >
                            Role Name
                        </label>

                        <input
                            type="text"
                            placeholder="e.g. Manager"
                            class="w-full px-4 py-2.5
                                   text-sm text-gray-900
                                   bg-gray-50
                                   border border-gray-200
                                   rounded-lg
                                   outline-none
                                   focus:bg-white
                                   focus:border-gray-400
                                   focus:ring-2
                                   focus:ring-gray-100
                                   transition"
                        />

                        <p class="mt-2 text-xs text-gray-400">
                            Give this role a clear and recognizable name.
                        </p>

                    </div>
                </div>

                <!-- Permissions Header -->
                <div
                    class="px-6 py-5
                           border-b border-gray-200
                           flex items-center justify-between"
                >
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">
                            Permissions
                        </h2>

                        <p class="mt-1 text-xs text-gray-400">
                            Select the permissions this role should have.
                        </p>
                    </div>

                    <span
                        class="px-2.5 py-1
                               text-xs font-medium
                               text-gray-600
                               bg-gray-100
                               rounded-md"
                    >
                        8 selected
                    </span>
                </div>

                <!-- Permission Groups -->
                <div class="p-6 space-y-5">

                    <!-- User Group -->
                    <div
                        class="border border-gray-200
                               rounded-xl overflow-hidden"
                    >

                        <!-- Group Header -->
                        <div
                            class="flex items-center justify-between
                                   px-4 py-3
                                   bg-gray-50
                                   border-b border-gray-200"
                        >
                            <div>
                                <h3
                                    class="text-sm font-semibold
                                           text-gray-900 uppercase"
                                >
                                    User
                                </h3>

                                <p class="text-xs text-gray-400 mt-0.5">
                                    4 permissions
                                </p>
                            </div>

                            <label
                                class="flex items-center gap-2
                                       text-xs font-medium
                                       text-gray-600 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900
                                           focus:ring-gray-200"
                                />

                                Select all
                            </label>
                        </div>

                        <!-- Permission List -->
                        <div
                            class="grid grid-cols-1
                                   sm:grid-cols-2 lg:grid-cols-4"
                        >
                            <label
                                class="flex items-center gap-3
                                       px-4 py-3
                                       border-b border-r
                                       border-gray-100
                                       hover:bg-gray-50
                                       cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900
                                           focus:ring-gray-200"
                                />

                                <div>
                                    <p
                                        class="text-sm font-medium
                                               text-gray-700"
                                    >
                                        VIEW
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        user.view
                                    </p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3
                                       px-4 py-3
                                       border-b border-r
                                       border-gray-100
                                       hover:bg-gray-50
                                       cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900
                                           focus:ring-gray-200"
                                />

                                <div>
                                    <p
                                        class="text-sm font-medium
                                               text-gray-700"
                                    >
                                        CREATE
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        user.create
                                    </p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3
                                       px-4 py-3
                                       border-b border-r
                                       border-gray-100
                                       hover:bg-gray-50
                                       cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900
                                           focus:ring-gray-200"
                                />

                                <div>
                                    <p
                                        class="text-sm font-medium
                                               text-gray-700"
                                    >
                                        EDIT
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        user.edit
                                    </p>
                                </div>
                            </label>

                            <label
                                class="flex items-center gap-3
                                       px-4 py-3
                                       border-b border-gray-100
                                       hover:bg-gray-50
                                       cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900
                                           focus:ring-gray-200"
                                />

                                <div>
                                    <p
                                        class="text-sm font-medium
                                               text-gray-700"
                                    >
                                        DELETE
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        user.delete
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Employee Group -->
                    <div
                        class="border border-gray-200
                               rounded-xl overflow-hidden"
                    >

                        <div
                            class="flex items-center justify-between
                                   px-4 py-3
                                   bg-gray-50
                                   border-b border-gray-200"
                        >
                            <div>
                                <h3
                                    class="text-sm font-semibold
                                           text-gray-900 uppercase"
                                >
                                    Employee
                                </h3>

                                <p class="text-xs text-gray-400 mt-0.5">
                                    4 permissions
                                </p>
                            </div>

                            <label
                                class="flex items-center gap-2
                                       text-xs font-medium
                                       text-gray-600 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900"
                                />

                                Select all
                            </label>
                        </div>

                        <div
                            class="grid grid-cols-1
                                   sm:grid-cols-2 lg:grid-cols-4"
                        >
                            <label
                                v-for="permission in [
                                    'VIEW',
                                    'CREATE',
                                    'EDIT',
                                    'DELETE',
                                ]"
                                :key="permission"
                                class="flex items-center gap-3
                                       px-4 py-3
                                       border-b border-r
                                       border-gray-100
                                       hover:bg-gray-50
                                       cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded
                                           border-gray-300
                                           text-gray-900"
                                />

                                <div>
                                    <p
                                        class="text-sm font-medium
                                               text-gray-700"
                                    >
                                        {{ permission }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        employee.{{ permission.toLowerCase() }}
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="px-6 py-4
                           bg-gray-50
                           border-t border-gray-200
                           flex items-center justify-end gap-3"
                >
                    <button
                        type="button"
                        class="px-4 py-2 text-sm font-medium
                               text-gray-600 bg-white
                               border border-gray-200
                               rounded-lg hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                    <button
                        class="px-5 py-2
                               text-sm font-medium
                               text-white bg-gray-900
                               rounded-lg hover:bg-gray-800"
                    >
                        Create Role
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>