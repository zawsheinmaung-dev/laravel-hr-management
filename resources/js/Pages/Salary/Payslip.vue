<script setup>
import { computed } from "vue";
import Layout from "../../Layouts/Layout.vue";

defineOptions({
    name: "SalaryPayslip",
    layout: Layout,
});

const props = defineProps({
    payslip: Object,
});

const earnings = computed(() => {
    return props?.payslip?.items.filter(
        (item) => item.item_type === "basic" || item.item_type === "allowance",
    );
});

const deductions = computed(() => {
    return props?.payslip?.items?.filter(
        (item) => item.item_type === "deduction",
    );
});

function getMonthAndYear(month, year) {
    const date = new Date(year, month - 1, 1).toLocaleDateString("en-US", {
        month: "long",
        year: "numeric",
    });
    return date;
}
</script>
<template>
    <div class="mx-auto max-w-2xl p-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <!-- Header -->
            <div
                class="mb-6 flex items-start justify-between border-b border-gray-100 pb-4"
            >
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Payslip</h2>
                    <p class="text-sm text-gray-500">
                        {{
                            getMonthAndYear(
                                payslip.payroll_batch.month,
                                payslip.payroll_batch.year,
                            )
                        }}
                    </p>
                </div>
                <span
                    class="inline-flex rounded-full px-3 py-1 text-xs font-medium text-yellow-700 uppercase"
                    :class="{
                        'bg-yellow-100 text-yellow-700':
                            payslip.status === 'generated',
                        'bg-blue-100 text-blue-700':
                            payslip.status === 'approved',
                        'bg-green-100 text-green-700':
                            payslip.status === 'paid',
                    }"
                >
                    {{ payslip.status }}
                </span>
            </div>

            <!-- Employee Info -->
            <div class="mb-6 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Employee</p>
                    <p class="font-medium text-gray-800">
                        {{ payslip.employee.first_name }}
                        {{ payslip.employee.last_name }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Department</p>
                    <p class="font-medium text-gray-800">
                        {{ payslip.employee.department.name }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Position</p>
                    <p class="font-medium text-gray-800">
                        {{ payslip.employee.position.title }}
                    </p>
                </div>
            </div>

            <!-- Earnings -->
            <div class="mb-4">
                <p class="mb-2 text-xs font-semibold uppercase text-gray-500">
                    Earnings
                </p>
                <div
                    v-for="earning in earnings"
                    :key="earning.id"
                    class="flex justify-between border-b border-gray-50 py-2 text-sm"
                >
                    <span class="text-gray-600">{{ earning.description }}</span>
                    <span class="font-medium text-gray-800">{{
                        earning.amount
                    }}</span>
                </div>
                <div v-if="!earnings.length" class="py-2 text-sm text-gray-400">
                    No earnings recorded.
                </div>
            </div>

            <!-- Deductions -->
            <div class="mb-4">
                <p class="mb-2 text-xs font-semibold uppercase text-gray-500">
                    Deductions
                </p>
                <div
                    v-for="deduction in deductions"
                    :key="deduction.id"
                    class="flex justify-between border-b border-gray-50 py-2 text-sm"
                >
                    <span class="text-gray-600">{{
                        deduction.description
                    }}</span>
                    <span class="font-medium text-red-600"
                        >-{{ deduction.amount || amount.persentage }}</span
                    >
                </div>
                <div
                    v-if="!deductions.length"
                    class="py-2 text-sm text-gray-400"
                >
                    No deductions.
                </div>
            </div>

            <!-- Net Total -->
            <div class="flex justify-between border-t border-gray-200 pt-4">
                <span class="font-semibold text-gray-800">Net Salary</span>
                <span class="text-lg font-bold text-indigo-600">
                    {{ payslip.net_salary }}
                </span>
            </div>
        </div>
    </div>
</template>
