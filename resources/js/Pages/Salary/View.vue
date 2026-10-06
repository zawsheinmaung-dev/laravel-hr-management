<script setup>
import axios from "axios";
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
defineOptions({
    name: "SalaryView",
    layout: Layout,
});
const props = defineProps({
    payrollBatch: Object,
});

function getMonthYear(year, month) {
    return new Date(year, month - 1, 1).toLocaleDateString("en-US", {
        month: "long",
        year: "numeric",
    });
}

function approveBatch() {
    axios.post(route("payroll.approve", props.payrollBatch.id));
}

function markAsPaid() {
    axios.post(route("payroll.paid", props.payrollBatch.id));
}
</script>
<template>
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">
            Payroll Details —
            {{ getMonthYear(payrollBatch.year, payrollBatch.month) }}
        </h1>

        <div class="flex gap-3">
            <Link
                v-if="payrollBatch.status === 'generated'"
                @click="approveBatch"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                Approve
            </Link>

            <Link
                v-if="payrollBatch.status === 'approved'"
                @click="markAsPaid"
                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700"
            >
                Confirm Paid
            </Link>

            <span
                v-if="payrollBatch.status === 'paid'"
                class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-600"
            >
                ✓ Payment Completed
            </span>
        </div>
    </div>
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p
                class="text-xs font-medium tracking-wide text-gray-500 uppercase"
            >
                Month/Year
            </p>
            <p class="mt-1 text-lg font-semibold text-gray-800">
                {{ getMonthYear(payrollBatch.year, payrollBatch.month) }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p
                class="text-xs font-medium tracking-wide text-gray-500 uppercase" 
            >
                Status
            </p>
            <p class="mt-1">
                <span >
                    {{ payrollBatch.status }}
                </span>
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p
                class="text-xs font-medium tracking-wide text-gray-500 uppercase"
            >
                Total Employee
            </p>
            <p class="mt-1 text-lg font-semibold text-gray-800">
                {{ payrollBatch.payrolls_count }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p
                class="text-xs font-medium tracking-wide text-gray-500 uppercase"
            >
                Total Net Salary
            </p>
            <p class="mt-1 text-lg font-semibold text-indigo-600">
                {{
                    Math.round(
                        payrollBatch.payrolls_sum_net_salary,
                    ).toLocaleString()
                }}
            </p>
        </div>

        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:col-span-2 lg:col-span-4"
        >
            <p
                class="text-xs font-medium tracking-wide text-gray-500 uppercase"
            >
                Generate Date/Time
            </p>
            <p class="mt-1 text-sm text-gray-700">
                {{ payrollBatch.created_at }}
            </p>
        </div>
    </div>
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

                    <th class="px-6 py-4">View Details</th>
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
                            class="inline-flex rounded-full px-3 py-1 text-xs font-medium uppercase"
                            :class="{
                                'text-yellow-700 bg-yellow-400':
                                    pb.status === 'generated',
                                'text-green-700 bg-green-400':
                                    pb.status === 'approved',
                                'text-blue-700 bg-blue-400':
                                    pb.status === 'paid',
                            }"
                        >
                            {{ pb.status }}
                        </span>
                    </td>

                    <td class="px-6 py-4 ">
                        <Link
                            type="button"
                            :href="route('payroll.employee',pb.employee_id)"
                            class="font-medium text-indigo-600 hover:text-indigo-800"
                        >
                            View
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>
