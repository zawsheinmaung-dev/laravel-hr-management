<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Link, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

defineOptions({
    name: "DepermentIndex",
    layout: Layout,
});

const props = defineProps({
    departments: Array,
    branches:Array
});

function department_delete(id) {
    if (!confirm("Are U sure delete?")) {
        return;
    }

    router.delete(route('deparments.destroy',id),{
        preserveScroll:true,
        onSuccess:(success)=>{
            
        },
        onError:(err)=>{
            
        }
    })
}
</script>

<template>
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Deparment</h1>

                <p class="text-xs text-gray-500 mt-1"></p>
                
            </div>
        </div>

        <!-- Filter -->
        <div class="flex items-center gap-2 justify-between">
            <select
                class="px-3 py-1 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-300"
            >
                <option value="">Brahches</option>

                <option v-for="bch in branches" :key="bch.id">
                    {{ bch.name }}
                </option>
            </select>
            <div>
                <Link :href="route('deparments.create')"
                class="px-3 py-1.5 rounded-lg
                       bg-blue-600 text-white text-xs
                       font-medium hover:bg-blue-700"
            >
                + Add Branches
            </Link>

            </div>
        </div>

        <!-- Table -->
        <div
            class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
        >
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="px-5 py-3">Branch Name</th>

                        <th class="px-5 py-3">Code</th>

                        <th class="px-5 py-3">Location</th>

                        <th class="px-5 py-3">Employees</th>

                        <th class="px-5 py-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                       v-for="dep in departments"
                        class="border-b border-gray-100 hover:bg-gray-50"
                    >
                        <td class="px-5 py-3">
                            {{ dep.name }}
                        </td>

                        <td class="px-5 py-3">
                            {{ dep.code }}
                        </td>

                        <td class="px-5 py-3">
                            {{ dep.branch?.address }}
                        </td>

                        <td class="px-5 py-3">
                            {{ dep.employees_count }}
                        </td>

                        <td class="px-5 py-3">
                            <div class="flex gap-1">
                                <Link
                                :href="route('deparments.show',dep.id)"
                                    class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-gray-200"
                                >
                                    View
                                </Link>

                                <Link
                                :href="route('deparments.edit',dep.id)"
                                    class="px-2 py-1 rounded-lg bg-blue-100 hover:bg-blue-200"
                                >
                                    Edit
                                </Link>
                                <button
                                @click="department_delete(dep.id)"
                                    class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- No Result -->
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            No users found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
