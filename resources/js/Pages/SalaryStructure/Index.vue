<script setup>
import { route } from 'ziggy-js';
import Layout from '../../Layouts/Layout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({
    name: 'SalaryStructureIndex',
    layout: Layout
});

defineProps({
    salaries: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Salary Structure
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Manage salary structures
                </p>
            </div>

            <Link
                :href="route('salarystructure.create')"
                class="inline-flex items-center px-4 py-2
                       bg-gray-800 text-white text-sm font-medium
                       rounded-lg hover:bg-gray-700 transition"
            >
                + Add Structure
            </Link>
        </div>


        <!-- Table Card -->
        <div
            class="bg-white
                   border border-gray-200
                   rounded-xl
                   shadow-sm
                   overflow-hidden"
        >

            <table class="w-full text-left text-sm">

                <!-- Table Header -->
                <thead class="bg-gray-50">

                    <tr class="border-b border-gray-200">

                        <th class="px-5 py-4 font-semibold text-gray-600">
                            #
                        </th>

                        <th class="px-5 py-4 font-semibold text-gray-600">
                            Name
                        </th>

                        <th class="px-5 py-4 font-semibold text-gray-600">
                            Description
                        </th>

                        <th class="px-5 py-4 font-semibold text-gray-600">
                            Action
                        </th>

                    </tr>

                </thead>


                <!-- Table Body -->
                <tbody>

                    <!-- Data -->
                    <tr
                        v-for="(sl, index) in salaries"
                        :key="sl.id"
                        class="border-b border-gray-100 hover:bg-gray-50"
                    >

                        <td class="px-5 py-4 text-gray-500">
                            {{ index + 1 }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="font-medium text-gray-800">
                                {{ sl.name }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ sl.description || '-' }}
                        </td>

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <Link
                                    :href="route(
                                        'salarystructure.edit',
                                        sl.id
                                    )"
                                    class="px-3 py-1.5
                                           rounded-lg
                                           bg-blue-100
                                           text-blue-700
                                           text-sm
                                           hover:bg-blue-200"
                                >
                                    Edit
                                </Link>

                            </div>

                        </td>

                    </tr>


                    <!-- No Result -->
                    <tr v-if="salaries.length === 0">

                        <td
                            colspan="4"
                            class="text-center py-12 text-gray-500"
                        >
                            No salary structures found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>