<script setup>
import Layout from '../../Layouts/Layout.vue'

defineOptions({
    name: 'UsersShow',
    layout: Layout,
})

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    User Details
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    View user account information and assigned roles.
                </p>
            </div>

            <div class="flex gap-2">
                <a
                    :href="route('users.index')"
                    class="px-3 py-1.5 text-sm rounded-lg border
                           border-gray-300 bg-white hover:bg-gray-50"
                >
                    Back
                </a>

                <a
                    :href="route('users.edit', props.user.id)"
                    class="px-3 py-1.5 text-sm rounded-lg
                           bg-blue-600 text-white hover:bg-blue-700
                           disabled:opacity-50"
                >
                    Edit User
                </a>
            </div>
        </div>


        <!-- Profile Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

            <!-- Profile Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-4">

                    <!-- Avatar -->
                    <div
                        class="w-16 h-16 rounded-full bg-blue-100
                               text-blue-700 flex items-center justify-center
                               text-2xl font-bold"
                    >
                        {{ props.user.name?.charAt(0).toUpperCase() }}
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ props.user.name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ props.user.email }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Account Information -->
            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Account Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Name -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Full Name
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ props.user.name }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Email Address
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ props.user.email }}
                        </p>
                    </div>

                    <!-- User ID -->
                    <div>
                        <label class="text-sm text-gray-500">
                            User ID
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            #{{ props.user.id }}
                        </p>
                    </div>

                    <!-- Email Verification -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Email Status
                        </label>

                        <span
                            v-if="props.user.email_verified_at"
                            class="inline-flex mt-1 px-2.5 py-1 rounded-full
                                   bg-green-100 text-green-700 text-xs font-medium"
                        >
                            Verified
                        </span>

                        <span
                            v-else
                            class="inline-flex mt-1 px-2.5 py-1 rounded-full
                                   bg-yellow-100 text-yellow-700 text-xs font-medium"
                        >
                            Not Verified
                        </span>
                    </div>

                </div>
            </div>


            <!-- Roles -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Assigned Roles
                </h3>

                <div
                    v-if="props.user.roles?.length"
                    class="flex flex-wrap gap-2"
                >
                    <span
                        v-for="role in props.user.roles"
                        :key="role.id"
                        class="px-3 py-1.5 rounded-full
                               bg-blue-100 text-blue-700
                               text-sm font-medium"
                    >
                        {{ role.name }}
                    </span>
                </div>

                <p
                    v-else
                    class="text-sm text-gray-500"
                >
                    No roles assigned.
                </p>

            </div>


            <!-- Timestamps -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Account Activity
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="text-sm text-gray-500">
                            Created At
                        </label>

                        <p class="mt-1 text-gray-800">
                            {{ props.user.created_at }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500">
                            Last Updated
                        </label>

                        <p class="mt-1 text-gray-800">
                            {{ props.user.updated_at }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</template>