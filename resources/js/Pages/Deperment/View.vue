<script setup>
import Layout from '../../Layouts/Layout.vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    name: 'DepermentView',
    layout: Layout,
});

defineProps({
    deparment:Object
});
</script>
<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Error -->
        

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Create Department
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Create a new department and configure its information.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="route('deparments.index')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <Link
                :href="route('deparments.edit',deparment.id)"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >Edit
                </Link>
            </div>
        </div>

        <!-- Main Card -->
        <div
            class="overflow-visible rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            <!-- Basic Information -->
            <div class="p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Basic information about this department.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Department Name -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Department Name
                        </label>

                        <input
                            type="text"
                            :value="deparment.name"
                            readonly
                            placeholder="Enter department name"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500 placeholder:text-gray-400"
                        />
                    </div>

                    <!-- Department Code -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Department Code
                        </label>

                        <input
                            type="text"
                            :value="deparment?.code"
                            readonly
                            placeholder="Generated automatically"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500 placeholder:text-gray-400"
                        />
                    </div>

                    <!-- Parent Department -->
                    <div class="relative">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Parent Department
                        </label>

                        <input
                            type="text"
                            :value="deparment?.parent_dep?.name"
                            readonly
                            placeholder="Search parent department..."
                            autocomplete="off"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500 placeholder:text-gray-400"
                        />

                       
                    </div>

                    <!-- Department Manager -->
                    <div class="relative">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Department Manager
                        </label>

                        <input
                            type="text"
                            :value="`${deparment?.head_emp?.first_name} ${deparment?.head_emp?.last_name}`"
                            readonly
                            placeholder="Select automatically"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500 placeholder:text-gray-400"
                        />

                        
                    </div>
                </div>
            </div>

            <!-- Department Details -->
            <div class="border-t border-gray-200 p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Department Details
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Additional information about this department.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Description
                        </label>

                        <textarea
                            rows="5"
                            :value="deparment.description"
                            readonly
                            placeholder="Enter department description..."
                            class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>