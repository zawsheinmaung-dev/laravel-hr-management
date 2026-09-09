<script setup>
import Layout from '../../Layouts/Layout.vue';

defineOptions({
    name: 'LeaveView',
    layout: Layout,
});

defineProps({
    leave: Object,
    history: Array,
    balance: Array,
});
</script>

<template>
    <div class="mx-auto max-w-4xl space-y-4">

        <!-- Header -->
        <div
            class="rounded-xl border border-gray-200 bg-white px-6 py-5 shadow-sm"
        >
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">
                        Leave Request Details
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Leave request #{{ leave?.id }}
                    </p>
                </div>

                <!-- Status -->
                <span
                    class="rounded-full px-3 py-1 text-sm font-medium capitalize"
                    :class="{
                        'bg-yellow-100 text-yellow-700':
                            leave?.status === 'pending',

                        'bg-green-100 text-green-700':
                            leave?.status === 'approved',

                        'bg-red-100 text-red-700':
                            leave?.status === 'rejected',

                        'bg-gray-100 text-gray-700':
                            leave?.status === 'cancelled',
                    }"
                >
                    {{ leave?.status }}
                </span>
            </div>
        </div>

        <!-- Employee -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Employee Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <div>
                    <p class="text-xs text-gray-500">
                        Employee Name
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.employee?.first_name }}
                        {{ leave?.employee?.last_name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Employee Code
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.employee?.employee_code || '-' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Leave Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Leave Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Leave Type -->
                <div>
                    <p class="text-xs text-gray-500">
                        Leave Type
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.leave_type?.name || '-' }}
                    </p>
                </div>

                <!-- Total Days -->
                <div>
                    <p class="text-xs text-gray-500">
                        Total Days
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.total_days || 0 }} day(s)
                    </p>
                </div>

                <!-- From -->
                <div>
                    <p class="text-xs text-gray-500">
                        Start Date
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.start_date || '-' }}
                    </p>
                </div>

                <!-- To -->
                <div>
                    <p class="text-xs text-gray-500">
                        End Date
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.end_date || '-' }}
                    </p>
                </div>

            </div>

            <!-- Reason -->
            <div class="mt-5">
                <p class="text-xs text-gray-500">
                    Reason
                </p>

                <div
                    class="mt-2 rounded-lg bg-gray-50 px-4 py-3 text-sm leading-6 text-gray-700"
                >
                    {{ leave?.reason || 'No reason provided.' }}
                </div>
            </div>
        </div>

        <!-- Approval Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500">
                Approval Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Approved By -->
                <div>
                    <p class="text-xs text-gray-500">
                        Approved By
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        <template v-if="leave?.approved_by">
                            {{ leave.approved_by.first_name }}
                            {{ leave.approved_by.last_name }}
                        </template>

                        <template v-else>
                            -
                        </template>
                    </p>
                </div>

                <!-- Approved At -->
                <div>
                    <p class="text-xs text-gray-500">
                        Approved At
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ leave?.approved_at || '-' }}
                    </p>
                </div>

            </div>
        </div>

    </div>
    <div
    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
>
    <div class="mb-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">
            Leave Balance
        </h2>

        <p class="mt-1 text-xs text-gray-400">
            Current year leave balance
        </p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
            v-for="item in balance"
            :key="item.id"
            class="rounded-lg border border-gray-200 p-4"
        >
            <p class="text-sm font-medium text-gray-800">
                {{ item?.leave_type?.name || '-'  }}
            </p>

            <div class="mt-3 grid grid-cols-3 gap-2 text-center">
                <div>
                    <p class="text-xs text-gray-400">
                        Allocated
                    </p>
                    <p class="mt-1 font-semibold">
                        {{ item.allocated_days }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">
                        Used
                    </p>
                    <p class="mt-1 font-semibold">
                        {{ item.used_days }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">
                        Remaining
                    </p>
                    <p class="mt-1 font-semibold text-green-600">
                        {{ item.remaining_days }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div
        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
    >
        <h1>EMPLOYEE LEAVE HISTORY
</h1>
        
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200">
                    <th class="px-5 py-3">Leave Type</th>
                    <th class="px-5 py-3">From</th>
                    <th class="px-5 py-3">To</th>
                    <th class="px-5 py-3">Days</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="ls in history"
                    class="border-b border-gray-100 hover:bg-gray-50"
                >
                    <td class="px-5 py-3">
                       {{ ls?.leave_type?.name }}
                    </td>
                    <td class="px-5 py-3">{{ ls.start_date }}</td>
                    <td class="px-5 py-3">{{ ls.end_date }}</td>
                    <td class="px-5 py-3">{{ ls.total_days }}</td>
                    <td class="px-5 py-3">
                        <span
                            v-if="ls.status === 'approved'"
                            class="text-green-400"
                        >
                            {{ ls.status }}
                        </span>

                        <span v-else class="text-red-400">
                            {{ ls.status }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                       
                    </td>
                </tr>
            </tbody>
            
        </table>
    </div>
    
</template>