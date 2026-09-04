<script setup>
import Layout from '../../Layouts/Layout.vue'
import { useForm,Link } from '@inertiajs/vue3'

defineOptions({
    name: 'UsersEdit',
    layout: Layout,
})

const props = defineProps({
    user: Object,
    roles: Array,
})

const form = useForm({
    name: props.user.name ?? '',
    email: props.user.email ?? '',
    password: '',
    password_confirmation: '',
    roles: props.user.roles?.map(role => role.id) ?? [],
})

const submit = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => {
            form.reset('password', 'password_confirmation')
        },
    })
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    Edit User
                </h1>

                <p class="text-xs text-gray-500">
                    Update user information and permissions.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="route('users.index')"
                    class="px-3 py-1.5 text-sm rounded-lg border
                           border-gray-300 bg-white hover:bg-gray-50"
                >
                    Cancel
                </Link>

                <button
                    @click="submit"
                    :disabled="form.processing"
                    class="px-3 py-1.5 text-sm rounded-lg
                           bg-blue-600 text-white hover:bg-blue-700
                           disabled:opacity-50"
                >
                    {{ form.processing ? 'Updating...' : 'Update' }}
                </button>
            </div>
        </div>


        <form @submit.prevent="submit">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- LEFT -->
                <div class="lg:col-span-2 space-y-4">

                    <!-- User Information -->
                    <div
                        class="bg-white rounded-lg border
                               border-gray-200 shadow-sm"
                    >

                        <div class="p-4 border-b border-gray-200">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10 rounded-full
                                           bg-blue-100 text-blue-600
                                           flex items-center justify-center
                                           text-lg font-bold"
                                >
                                    {{ props.user.name?.charAt(0).toUpperCase() }}
                                </div>

                                <div>
                                    <h2 class="text-sm font-semibold text-gray-800">
                                        {{ props.user.name }}
                                    </h2>

                                    <p class="text-xs text-gray-500">
                                        {{ props.user.email }}
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="p-4 space-y-4">

                            <!-- Name -->
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    v-model="form.name"
                                    class="w-full px-2.5 py-1.5 text-sm
                                           border border-gray-300 rounded-md
                                           focus:outline-none
                                           focus:ring-1 focus:ring-blue-500"
                                >

                                <p
                                    v-if="form.errors.name"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>


                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    v-model="form.email"
                                    class="w-full px-2.5 py-1.5 text-sm
                                           border border-gray-300 rounded-md
                                           focus:outline-none
                                           focus:ring-1 focus:ring-blue-500"
                                >

                                <p
                                    v-if="form.errors.email"
                                    class="mt-1 text-xs text-red-500"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>

                        </div>
                    </div>


                    <!-- Security -->
                    <div
                        class="bg-white rounded-lg border
                               border-gray-200 shadow-sm"
                    >

                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-sm font-semibold text-gray-800">
                                Security
                            </h2>

                            <p class="text-xs text-gray-500 mt-1">
                                Leave empty to keep current password.
                            </p>
                        </div>

                        <div class="p-4 grid grid-cols-2 gap-3">

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    v-model="form.password"
                                    class="w-full px-2.5 py-1.5 text-sm
                                           border border-gray-300 rounded-md
                                           focus:outline-none
                                           focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    v-model="form.password_confirmation"
                                    class="w-full px-2.5 py-1.5 text-sm
                                           border border-gray-300 rounded-md
                                           focus:outline-none
                                           focus:ring-1 focus:ring-blue-500"
                                >
                            </div>

                        </div>

                    </div>

                </div>


                <!-- RIGHT -->
                <div class="space-y-4">

                    <!-- Roles -->
                    <div
                        class="bg-white rounded-lg border
                               border-gray-200 shadow-sm"
                    >

                        <div class="p-4 border-b border-gray-200">
                            <h2 class="text-sm font-semibold text-gray-800">
                                Roles
                            </h2>

                            <p class="text-xs text-gray-500">
                                Select user roles.
                            </p>
                        </div>

                        <div class="p-4 space-y-2">

                            <label
                                v-for="role in roles"
                                :key="role.id"
                                class="flex items-center gap-2 p-2
                                       rounded-md border border-gray-200
                                       hover:bg-gray-50 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    :value="role.id"
                                    v-model="form.roles"
                                    class="w-3.5 h-3.5 text-blue-600"
                                >

                                <span class="text-sm text-gray-700">
                                    {{ role.name }}
                                </span>
                            </label>

                            <p
                                v-if="form.errors.roles"
                                class="text-xs text-red-500"
                            >
                                {{ form.errors.roles }}
                            </p>

                        </div>

                    </div>


                    <!-- Account -->
                    <div
                        class="bg-white rounded-lg border
                               border-gray-200 shadow-sm p-4"
                    >

                        <h2 class="text-sm font-semibold text-gray-800 mb-3">
                            Account
                        </h2>

                        <div class="space-y-2 text-xs">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    User ID
                                </span>

                                <span class="font-medium">
                                    #{{ props.user.id }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Status
                                </span>

                                <span
                                    class="px-2 py-0.5 rounded-full
                                           bg-green-100 text-green-700"
                                >
                                    Active
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</template>