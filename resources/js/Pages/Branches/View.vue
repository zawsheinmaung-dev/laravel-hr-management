<script setup>
import Layout from '../../Layouts/Layout.vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    name: 'BranchView',
    layout: Layout,
});

defineProps({
    branch:Object
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Branch Details
                </h1>
            </div>

            <div class="flex gap-2">
                <Link
                :href="route('branches.index')"
                    class="px-4 py-2 text-sm rounded-lg border
                           border-gray-300 bg-white
                           hover:bg-gray-50"
                >
                    Back
                </Link>

                <Link
                :href="route('branches.edit',branch.id)"
                    class="px-4 py-2 text-sm rounded-lg
                           bg-blue-600 text-white
                           hover:bg-blue-700"
                >
                    Edit Branch
                </Link>
            </div>
        </div>


        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

            <!-- Profile Header -->
            <div class="p-6 border-b border-gray-200">
               <div>
                <h1 class="text-lg font-semibold text-gray-800">🏢 Head Office </h1>
               </div>
               <p>{{ branch.name }}</p>
            </div>


            <!-- Basic Information -->
            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Basic Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Full Name -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Branch Name
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.name }}
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Branch Code
                        </label>

                        <p class="mt-1 font-medium text-gray-800 capitalize">
                            {{ branch.code }}
                        </p>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Manager
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.manager.first_name }}
                            {{ branch.manager.last_name }}
                        </p>
                    </div>

                   

                    

                </div>
            </div>


            <!-- Company Account -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Contact Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- User Name -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Phone
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.phone }}
                        </p>
                    </div>

                    <!-- Company Email -->
                    <div>
                        <label class="text-sm text-gray-500">
                             Email
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.manager.personal_email }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">
                             Address
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.address }}
                        </p>
                    </div>
                </div>
            </div>


            <!-- Organization -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Organization
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Branch -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employees
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.employees.length }}
                        </p>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Department
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.departments.length }}
                        </p>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Created At
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ branch.created_at }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>