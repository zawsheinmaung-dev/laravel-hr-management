<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
defineOptions({
    name: "EmpSalary",
    layout: Layout,
});

defineProps({
    payroll: Object,
});
function statusColor(status) {
    const colors = {
        generated: "bg-yellow-100 text-yellow-700",
        approved: "bg-blue-100 text-blue-700",
        paid: "bg-green-100 text-green-700",
    };
    return colors[status] ?? "bg-gray-100 text-gray-700";
}

function getMonthYear(month, year) {
    const date = new Date(year, month - 1, 1).toLocaleDateString("en-US", {
        month: "long",
        year: "numeric",
    });
    return date;
}
</script>
<template>
    <div class="p-6">
        <!-- Employee Info Header -->
        <div
            class="mb-6 flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
        >
            <div
                class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-lg font-semibold text-indigo-600"
            >
                {{ payroll.first_name[0] }}{{ payroll.last_name[0] }}
            </div>
            <div class="flex w-full justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ payroll.first_name }}{{ payroll.last_name }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ payroll.department.name }} .
                        {{ payroll.position.title }}
                    </p>
                </div>
                <div>
                    <Link :href="route('payroll.index')">Back</Link>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div
                class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
            >
                <p
                    class="text-xs font-medium tracking-wide text-gray-500 uppercase"
                >
                    Current Basic Salary
                </p>
                <p class="mt-1 text-lg font-semibold text-gray-800">
                    {{
                        payroll.salary_structure.salary_structure_items[0]
                            .amount
                    }}
                </p>
            </div>
            <div
                class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
            >
                <p
                    class="text-xs font-medium tracking-wide text-gray-500 uppercase"
                >
                    Total Payrolls
                </p>
                <p class="mt-1 text-lg font-semibold text-gray-800">
                    {{ payroll.payrolls.length }}
                </p>
            </div>
        </div>

        <!-- Payroll History Table -->
        <div
            class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-6 py-4">Month/Year</th>
                        <th class="px-6 py-4">Basic Salary</th>
                        <th class="px-6 py-4">Allowance</th>
                        <th class="px-6 py-4">Deduction</th>
                        <th class="px-6 py-4">Net Salary</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr
                        v-for="p in payroll.payrolls"
                        :key="p.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{
                                getMonthYear(
                                    p.payroll_batch.month,
                                    p.payroll_batch.year,
                                )
                            }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ p.basic_salary }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ p.total_allowance }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ p.total_deduction }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ p.net_salary }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                :class="[
                                    'inline-flex rounded-full px-3 py-1 text-xs font-medium uppercase',
                                    statusColor(p.status),
                                ]"
                            >
                                {{ p.status }}
                            </span>
                        </td>
                        <th class="px-6 py-4">
                            <Link :href="route('payroll.payslip', p.id)">
                                View
                            </Link>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
