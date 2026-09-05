<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineOptions({
    name: "LeaveIndex",
    layout: Layout,
    inheritAttrs: false,
});

const props = defineProps({
    auth: Object,
    leavetypes: Object,
    leaverequests: Object,
});
// const total_day =form.start_date -form.end_date;

const form = useForm({
    start_date: "",
    end_date: "",
    total_days: "",
    leavetype_id: "",
    reason: "",
});

function request_leave() {
    console.log(form.data());

    form.post(route("leave.store"));
}

function get_total_days() {
    if (!form.start_date || !form.end_date) {
        console.log("return");

        return;
    }
    const start = new Date(form.start_date);
    const end = new Date(form.end_date);
    const diff = (end.getTime() - start.getTime()) / (1000 * 60 * 60 * 24);
    if (diff < 0) {
        form.total_days = 0;
    }
    form.total_days = diff + 1;
}
</script>

<template>
    <div
        v-if="Object.keys(form?.errors).length"
        class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
    >
        <div
            v-for="(er, key) in form?.errors"
            :key="key"
            class="text-sm text-red-600"
        >
            {{ er }}
        </div>
    </div>
    <!-- Compact Overtime Form -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-4">
        <form
            @submit.prevent="request_leave"
            class="grid grid-cols-1 gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm md:grid-cols-2 lg:grid-cols-12 lg:items-end"
        >
            <!-- Employee -->
            <div class="lg:col-span-3">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Employee
                </label>

                <input
                    :value="auth.name"
                    readonly
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-800 outline-none"
                />
            </div>

            <!-- Leave Type -->
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Leave Type
                </label>

                <select
                    v-model="form.leavetype_id"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >
                    <option value="" disabled>Select leave</option>
                    <option
                        v-for="lt in leavetypes"
                        :key="lt.id"
                        :value="lt.id"
                    >
                        {{ lt.name }}
                    </option>
                </select>
            </div>

            <!-- From -->
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Request From
                </label>

                <input
                    type="date"
                    v-model="form.start_date"
                    @change="get_total_days"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />
            </div>

            <!-- To -->
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Request To
                </label>

                <input
                    type="date"
                    v-model="form.end_date"
                    @change="get_total_days"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />
            </div>

            <!-- Request Days -->
            <div class="lg:col-span-1">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Days
                </label>

                <input
                    type="number"
                    :value="form.total_days"
                    readonly
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-700 outline-none"
                    placeholder="0"
                />
            </div>

            <!-- Reason -->
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Reason
                </label>

                <input
                    type="text"
                    v-model="form.reason"
                    placeholder="Reason..."
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />
            </div>

            <!-- Submit -->
            <div class="lg:col-span-12 lg:flex lg:justify-end">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60 md:w-auto"
                >
                    {{ form.processing ? "Submitting..." : "Submit Request" }}
                </button>
            </div>
        </form>
    </div>
    <div
        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
    >
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200">
                    <th class="px-5 py-3">Employee</th>
                    <th class="px-5 py-3">Leave Type</th>
                    <th class="px-5 py-3">From</th>
                    <th class="px-5 py-3">To</th>
                    <th class="px-5 py-3">Days</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-if="leaverequests?.data.length"
                    v-for="lq in leaverequests?.data"
                    class="border-b border-gray-100 hover:bg-gray-50"
                >
                    <td class="px-5 py-3">
                        {{ lq.employee?.first_name }}
                        {{ lq.employee?.last_name }}
                    </td>
                    <td class="px-5 py-3">{{ lq.leave_type?.name }}</td>
                    <td class="px-5 py-3">{{ lq.start_date }}</td>
                    <td class="px-5 py-3">{{ lq.end_date }}</td>
                    <td class="px-5 py-3">{{ lq.total_days }}</td>
                    <td class="px-5 py-3">
                        <span
                            v-if="lq.status === 'approved'"
                            class="text-green-400"
                        >
                            {{ lq.status }}
                        </span>

                        <span v-else class="text-red-400">
                            {{ lq.status }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1">
                            <div class="flex gap-1">
                                <button
                                    class="px-2 py-1 rounded-lg bg-green-100 hover:bg-green-200"
                                >
                                    Approve
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200"
                                >
                                    Reject
                                </button>
                            </div>
                            <Link
                                class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-gray-200"
                                >View</Link
                            >
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="7" class="text-center py-10 text-gray-500">
                        No overtime requests found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
