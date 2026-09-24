<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import Layout from '../../Layouts/Layout.vue';
import { route } from 'ziggy-js';

defineOptions({
    name:'SalaryIndex',
    layout: Layout
})

defineProps({
    payrollBatch:Object
})
const form =useForm({
    month:new Date().getMonth()+1,
    year:new Date().getFullYear()
})
function generate_salary()
{
    if(!form.month || !form.year) return;
    form.post(route('generate'));
}

function formatMonthYear(month,year)
{
    const date=new Date(year,month-1).toLocaleDateString('en-Us',{month:'long',year:'numeric'})
    return date;
}
</script>
<template>
        <!-- Error -->
        <div
            v-if="Object.keys(form.errors).length"
            class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
        >
            <div
                v-for="(err, key) in form.errors"
                :key="key"
                class="text-sm text-red-600"
            >
                {{ err }}
            </div>
        </div>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Payroll
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Manage monthly employee payroll
                </p>
            </div>

            <button
                type="button"
                class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-indigo-700"
            >
                Generate Payroll
            </button>
        </div>

        <!-- Generate Payroll -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">
                Generate Payroll
            </h2>

            <div class="flex items-end gap-4">
                <!-- Month -->
                <div class="w-48">
                    <label
                        for="month"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Month
                    </label>

                    <select
                        id="month"
                        v-model="form.month"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Select month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>

                <!-- Year -->
                <div class="w-32">
                    <label
                        for="year"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Year
                    </label>

                    <select
                        id="year"
                        v-model="form.year"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>

                <!-- Generate -->
                <button
                    @click.prevent="generate_salary"
                    type="button"
                    class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-indigo-700"
                >
                    Generate
                </button>
            </div>
        </div>

        <!-- Payroll Batches -->
        <div class="rounded-xl bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Payroll Batches
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4">
                                Month
                            </th>

                            <th class="px-6 py-4">
                                Employees
                            </th>

                            <th class="px-6 py-4">
                                Total Net Salary
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <!-- September -->
                        <tr class="hover:bg-gray-50"
                        v-for="pb in payrollBatch" :key="pb.id"
                        >
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ formatMonthYear(pb.month,pb.year) }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{ pb.payrolls_count }}
                            </td>

                            <td class="px-6 py-4 text-gray-600">
                                {{Math.round(pb.payrolls_sum_net_salary)}}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 uppercase"
                                >
                                    {{ pb.status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <Link :href="route('payroll.show',pb.id)"
                                    type="button"
                                    class="font-medium text-indigo-600 hover:text-indigo-800">
                                View
                                </Link>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>