<script setup>
import { ref } from "vue";
import Layout from "../../Layouts/Layout.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { route } from "ziggy-js";

const page = usePage();
defineOptions({
    name: "AttendaceIndex",
    layout: Layout,
});

const props = defineProps({
    attendances: Array,
});
const today = new Date().toLocaleDateString("en-CA");
const date_check = ref();

const current_time = ref(
    new Date().toLocaleTimeString("en-CA", {
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
    }),
);
const search = ref("");

function check_in() {
    router.post(route("attendance.checkIn"));
}

function check_out() {
    router.post(route("attendance.checkOut"));
}

// function search_attendace() {
//      const search_emp = search.value.toLowerCase();
//     if (!search.value)
//         {
//             return props.attendances.filter(att=>{
//                return att.attendance_date === date_check.value
//             })
//         };

//     return props?.attendances.filter((att) => {
//         const name =
//             `${att.employee?.first_name} ${att.employee?.last_name}`.toLowerCase();
//         const code = att.employee.employee_code.toLowerCase();
//         const date=att.attendance_date
//         return name.includes(search_emp) || code.includes(search_emp) || date.includes(search_emp);
//     });
// }

function search_attendace() {
    let search_emp = search.value.toLowerCase();

    let attendacne_data = date_check.value
        ? props.attendances.filter(
              (att) => att.attendance_date === date_check.value,
          )
        : props.attendances;

    if (search_emp) {
        attendacne_data = attendacne_data.filter((att) =>
            `${att.employee?.first_name} ${att.employee?.last_name} ${att.employee?.employee_code} `
                .toLowerCase()
                .includes(search_emp),
        );
    }
    return attendacne_data;
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6 space-y-6">
        <div
            v-if="Object.keys(page?.props?.errors).length"
            class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
        >
            <div
                v-for="(er, key) in page?.props?.errors"
                :key="key"
                class="text-sm text-red-600"
            >
                {{ er }}
            </div>
        </div>

        <!-- Header + Filter -->
        <div class="rounded-xl border border-gray-200 bg-white p-4">
            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <h3 class="text-lg font-semibold text-gray-800">Attendance</h3>
                <div class="relative w-full max-w-sm">
                    <input
                        type="text"
                        v-model="search"
                        class="w-full rounded-lg border border-gray-300 pl-3 pr-10 py-2 text-sm focus:border-blue-500 focus:outline-none"
                        placeholder="Search..."
                    />

                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-2"
                    >
                        <input
                            type="date"
                            v-model="date_check"
                            class="w-8 h-8 opacity-0 absolute right-2 z-10 cursor-pointer"
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-400 pointer-events-none"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today Attendance -->
        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <h3 class="mb-4 text-base font-semibold text-gray-800">
                Today Attendance
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <h4 class="mb-1.5 text-sm font-medium text-gray-700">
                        Check In
                    </h4>
                    <input
                        type="time"
                        v-model="current_time"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                    />
                    <button
                        @click.prevent="check_in"
                        class="mt-2 w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                    >
                        Check In
                    </button>
                </div>
                <div>
                    <h4 class="mb-1.5 text-sm font-medium text-gray-700">
                        Check Out
                    </h4>
                    <input
                        type="time"
                        v-model="current_time"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                    />
                    <button
                        @click.prevent="check_out"
                        class="mt-2 w-full rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium hover:bg-gray-200"
                    >
                        Check Out
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-5 py-3">Employee</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">In</th>
                        <th class="px-5 py-3">Out</th>
                        <th class="px-5 py-3">Hours</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody v-if="search_attendace().length">
                    <tr
                        v-for="att in search_attendace()"
                        :key="att.id"
                        class="border-b hover:bg-gray-50"
                    >
                        <td class="px-5 py-3">
                            <div class="font-medium">
                                {{ att.employee?.first_name }}
                                {{ att.employee?.last_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ att.employee?.employee_code }}
                            </div>
                        </td>
                        <td class="px-5 py-3">{{ att.attendance_date }}</td>
                        <td class="px-5 py-3">{{ att.check_in }}</td>
                        <td class="px-5 py-3">{{ att.check_out }}</td>
                        <td class="px-5 py-3">{{ att.working_hours }}</td>
                        <td class="px-5 py-3">
                            <span
                                class="rounded-full px-2 py-1 text-xs"
                                :class="
                                    att.status === 'late'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-green-100 text-green-700'
                                "
                                >{{ att.status }}</span
                            >
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-400">
                            Not have
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
