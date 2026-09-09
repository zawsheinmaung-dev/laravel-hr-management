```vue
<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({
    name: "PayrollIndex",
    layout: Layout,
});

defineProps({
    salarys: Object,
});

function delete_salary_component(id)
{
    if(!confirm("Sure to delete?")) return;
    router.delete(route('payroll.destroy',id))
}

</script>

<template>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Salary Components
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Manage salary earnings and deductions
                </p>
            </div>

            <Link
            :href="route('payroll.create')"
                class="inline-flex items-center px-4 py-2
                       bg-gray-800 text-white text-sm font-medium
                       rounded-lg hover:bg-gray-700 transition"
            >
                + Add Component
            </Link>
        </div>


        <!-- Table Card -->
        <div
            class="bg-white border border-gray-200
                   rounded-xl shadow-sm overflow-hidden"
        >

            <table class="w-full text-left text-sm">

                <!-- Table Header -->
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">

                        <th
                            class="px-5 py-3 font-semibold text-gray-600"
                        >
                            #
                        </th>

                        <th
                            class="px-5 py-3 font-semibold text-gray-600"
                        >
                            Component Name
                        </th>

                        <th
                            class="px-5 py-3 font-semibold text-gray-600"
                        >
                            Type
                        </th>

                        <th
                            class="px-5 py-3 text-right font-semibold text-gray-600"
                        >
                            Actions
                        </th>

                    </tr>
                </thead>


                <!-- Table Body -->
                <tbody>

                    <!-- Data -->
                    <tr
                        v-for="(sl, index) in salarys"
                        :key="sl.id"
                        class="border-b border-gray-100 hover:bg-gray-50 transition"
                    >

                        <td class="px-5 py-4 text-gray-500">
                            {{ index + 1 }}
                        </td>


                        <td
                            class="px-5 py-4
                                   font-medium text-gray-800"
                        >
                            {{ sl.name }}
                        </td>


                        <!-- Type -->
                        <td class="px-5 py-4">

                            <span
                                v-if="sl.type === 'earning'"
                                class="inline-flex items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-medium
                                       bg-green-100 text-green-700"
                            >
                                Earning
                            </span>

                            <span
                                v-else
                                class="inline-flex items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-medium
                                       bg-red-100 text-red-700"
                            >
                                Deduction
                            </span>

                        </td>


                        <!-- Actions -->
                        <td class="px-5 py-4">

                            <div
                                class="flex justify-end items-center gap-3"
                            >

                                <Link
                                    :href="route('payroll.edit',sl.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-blue-100
                                           hover:bg-blue-200"
                                >
                                    Edit
                                </Link>


                                <button
                                   @click="delete_salary_component(sl.id)"
                                    as="button"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-red-100
                                           hover:bg-red-200"
                                >
                                    Delete
                                </button>

                            </div>

                        </td>

                    </tr>


                    <!-- Empty State -->
                    <tr v-if="salarys.length === 0">

                        <td
                            colspan="4"
                            class="text-center py-12 text-gray-500"
                        >
                            <div class="space-y-2">

                                <p class="font-medium text-gray-600">
                                    No salary components found.
                                </p>

                                <p class="text-sm text-gray-400">
                                    Create your first salary component.
                                </p>

                            </div>
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>
```
