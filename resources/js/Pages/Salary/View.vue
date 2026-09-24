<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
defineOptions({
    name: "SalaryView",
    layout: Layout,
});
defineProps({
    payrollBatch: Object,
});
</script>
<template>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-4">Employees</th>

                    <th class="px-6 py-4">Department</th>

                    <th class="px-6 py-4">Basic Salary</th>

                    <th class="px-6 py-4">Deductions</th>

                    <th class="px-6 py-4">Net Salary</th>

                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <!-- September -->
                <tr
                    class="hover:bg-gray-50"
                    v-for="pb in payrollBatch?.payrolls"
                    :key="pb.id"
                >
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ pb.employee.first_name }} {{ pb.employee.last_name }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ pb.employee.department.name }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ pb.basic_salary }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ pb.total_deduction }}
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ pb.net_salary }}
                    </td>

                    <td class="px-6 py-4">
                        <span
                            class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 uppercase"
                        >
                            {{ pb.status }}
                        </span>
                    </td>

                    <!-- <td class="px-6 py-4 text-right">
                                <Link 
                                    type="button"
                                    class="font-medium text-indigo-600 hover:text-indigo-800">
                                View
                                </Link>
                            </td> -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
