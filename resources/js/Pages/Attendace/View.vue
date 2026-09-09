<script setup>
import Layout from '../../Layouts/Layout.vue';

defineOptions({
    name: 'AttendanceView',
    layout: Layout,
});

defineProps({
    attendance: {
        type: Object,
        default: null,
    },
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
                        Attendance Details
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Attendance #{{ attendance?.id }}
                    </p>
                </div>

                <!-- Status -->
                <span
                    class="rounded-full px-3 py-1 text-sm font-medium capitalize"
                    :class="{
                        'bg-green-100 text-green-700':
                            attendance?.status === 'present',

                        'bg-yellow-100 text-yellow-700':
                            attendance?.status === 'late',

                        'bg-blue-100 text-blue-700':
                            attendance?.status === 'leave',

                        'bg-red-100 text-red-700':
                            attendance?.status === 'absent',
                    }"
                >
                    {{ attendance?.status || '-' }}
                </span>
            </div>
        </div>

        <!-- Employee Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2
                class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500"
            >
                Employee Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Employee -->
                <div>
                    <p class="text-xs text-gray-500">
                        Employee
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.employee?.first_name }}
                        {{ attendance?.employee?.last_name }}
                    </p>
                </div>

                <!-- Employee Code -->
                <div>
                    <p class="text-xs text-gray-500">
                        Employee Code
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.employee?.employee_code || '-' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Schedule Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2
                class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500"
            >
                Schedule Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Attendance Date -->
                <div>
                    <p class="text-xs text-gray-500">
                        Attendance Date
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.attendance_date || '-' }}
                    </p>
                </div>

                <!-- Shift -->
                <div>
                    <p class="text-xs text-gray-500">
                        Shift
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.employee?.current_shift?.shift?.name || '-' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Attendance Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2
                class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500"
            >
                Attendance Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Check In -->
                <div>
                    <p class="text-xs text-gray-500">
                        Check In
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.check_in || '-' }}
                    </p>
                </div>

                <!-- Check Out -->
                <div>
                    <p class="text-xs text-gray-500">
                        Check Out
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.check_out || '-' }}
                    </p>
                </div>

                <!-- Working Hours -->
                <div>
                    <p class="text-xs text-gray-500">
                        Working Hours
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.working_hours ?? '-' }}
                    </p>
                </div>

                <!-- Late Minutes -->
                <div>
                    <p class="text-xs text-gray-500">
                        Late Minutes
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.late_minutes ?? 0 }}
                        min
                    </p>
                </div>

                <!-- Early Leave -->
                <div>
                    <p class="text-xs text-gray-500">
                        Early Leave
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.early_leave_minutes ?? 0 }}
                        min
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <p class="text-xs text-gray-500">
                        Status
                    </p>

                    <p class="mt-1 font-medium capitalize text-gray-800">
                        {{ attendance?.status || '-' }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Check In Information -->
        <div
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
        >
            <h2
                class="mb-5 text-sm font-semibold uppercase tracking-wide text-gray-500"
            >
                Check-in Information
            </h2>

            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Check In IP -->
                <div>
                    <p class="text-xs text-gray-500">
                        Check In IP
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.check_in_ip || '-' }}
                    </p>
                </div>

                <!-- Created At -->
                <div>
                    <p class="text-xs text-gray-500">
                        Created At
                    </p>

                    <p class="mt-1 font-medium text-gray-800">
                        {{ attendance?.created_at || '-' }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</template>