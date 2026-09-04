<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const page=usePage();
defineOptions({
    name: "ShiftIndex",
    layout: Layout,
});

defineProps({
    shifts: Array,
});

function shifts_delete(id)
{
    console.log("delete");
    
    if(!confirm("Sure Delete")) return
    router.delete(route('shifts.destroy',id),{
        preserveScroll:true,
        onError:(err)=>{
            console.log(err);
            
        }
    })
}
</script>


<template>
    <div class="space-y-4">
        <div v-if="page.props.errors.shift" class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
    {{ page.props.errors.shift }}
  </div>
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Shift</h1>

                <p class="text-xs text-gray-500 mt-1"></p>
            </div>
        </div>

        <!-- Filter -->
        <div class="flex items-center gap-2 justify-between">
            <select
                class="px-3 py-1 text-sm border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-300"
            >
                <option value="">Brahches</option>

                <option></option>
            </select>
            <div>
                <Link
                    :href="route('shifts.create')"
                    class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-medium hover:bg-blue-700"
                >
                    + Add Shift
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
                        <th class="px-5 py-3">Name</th>

                        <th class="px-5 py-3">Working Hours</th>

                        <th class="px-5 py-3">Allowed Late Minutes</th>

                        <th class="px-5 py-3">Employees</th>

                        <th class="px-5 py-3">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="value in shifts"
                        class="border-b border-gray-100 hover:bg-gray-50"
                    >
                        <td class="px-5 py-3">
                            {{ value.name }}
                        </td>

                        <td class="px-5 py-3">
                            {{ value.start_time }} - {{ value.end_time }}
                        </td>

                        <td class="px-5 py-3">
                            {{ value.grace_minutes }} Minutes
                        </td>

                        <td class="px-5 py-3">
                            {{ value.assignments.length }}
                        </td>

                        <td class="px-5 py-3">
                            <div class="flex gap-1">
                                <Link
                                    class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-gray-200"
                                >
                                    Shift View
                                </Link>

                                <Link
                                    :href="route('shifts.edit',value.id)"
                                    class="px-2 py-1 rounded-lg bg-blue-100 hover:bg-blue-200"
                                >
                                    Shift Assign
                                </Link>
                                <button
                                    @click="shifts_delete(value.id)"
                                    class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- No Result -->
                    <tr v-if="!shifts.length">
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            No shifts found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
