<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Search from "../../Components/Search.vue";
import { ref } from "vue";

defineOptions({
    name: "LeaveIndex",
    layout: Layout,
    inheritAttrs: false,
});

const props = defineProps({
    auth: Object,
    leavetypes: Object,
    leaverequests: Object,
    status: Array,
});

const form = useForm({
    start_date: "",
    end_date: "",
    total_days: "",
    leavetype_id: "",
    reason: "",
});

const updat_form = useForm({
    status: "",
});
function request_leave() {
    form.post(route("leave.store"));
}

function get_total_days() {
    if (!form.start_date || !form.end_date) {
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

function update_status(id, status) {
    updat_form.status = status;

    updat_form.put(route("leave.update", id), {
        preserveScroll: true,

        onSuccess: () => {
            console.log("success");
        },

        onError: (errors) => {
            console.log(errors);
        },
    });
}

const employee_id = ref();
function filter_emloyee() {
    const emp = employee_id.value
        ? props.leaverequests.data.filter(
              (lq) => lq.employee_id == employee_id.value,
          )
        : props.leaverequests.data;
    return emp;
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
    <div
        v-if="Object.keys(updat_form?.errors).length"
        class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
    >
        <div
            v-for="(er, key) in updat_form?.errors"
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
        <div class="flex justify-end p-5">
            <div class="w-full max-w-sm">
                <Search
                    v-model="employee_id"
                    label="Search"
                    placeholder="Search Employee..."
                />
            </div>
        </div>
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
            <tbody v-if="filter_emloyee()?.length">
                <tr
                    v-for="lq in filter_emloyee()"
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
                        <div class="flex items-center gap-2">
                            <select
                                v-model="lq.status"
                                :disabled="lq.status !== 'pending'"
                                @change="update_status(lq.id, lq.status)"
                                class="px-2 py-1 rounded-lg border border-gray-300"
                            >
                                <option
                                    v-for="item in status"
                                    :key="item"
                                    :value="item"
                                >
                                    {{ item }}
                                </option>
                            </select>

                            <Link
                            :href="route('leave.show',lq.id)"
                                class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-gray-200"
                            >
                                View
                            </Link>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tr v-else>
                <td colspan="7" class="text-center py-10 text-gray-500">
                    No overtime requests found.
                </td>
            </tr>
        </table>
    </div>
</template>
