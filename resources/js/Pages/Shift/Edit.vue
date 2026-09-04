<script setup>
import { useForm, Link, router } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";
import Search from "../../Components/Search.vue";

defineOptions({
    name: "ShiftEdit",
    layout: Layout,
});

const props = defineProps({
    shift: Object,
    assignments: Object,
});

const form = useForm({
    employee_id: "",
    shift_id: props?.shift?.id ?? "",
    effective_date: "",
});

function shift_assign() {
    console.log(form.data());

    form.post(route("shift.assign"), {
        onSuccess: (success) => {
            console.log(success);
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
}

function remove_assignment(shift)
{
    if(!confirm("Surre delete")) return
    router.post(route('shift.delete',shift.id),{},{
        onSuccess:(success)=>{
            console.log(success);
            
        },
        onError:(err)=>{
            form.errors =err
            
        }
    })    
}
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">
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

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Shift: {{ shift.name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ shift.start_time }} - {{ shift.end_time }} · Grace
                    {{ shift.grace_minutes }} min
                </p>
            </div>
            <div class="flex gap-2">
                <Link
                    :href="route('shifts.index')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Back
                </Link>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Assigned Employees -->
            <div class="border-b border-gray-200 p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">
                    Assigned Employees
                </h2>
                <!-- Assigned Employees -->
                <div v-if="assignments?.data?.length" class="space-y-2">
                    <div
                        v-for="a in assignments.data"
                        :key="a.id"
                        class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-3 transition hover:bg-gray-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700"
                            >
                                {{ a.employee?.first_name?.[0]
                                }}{{ a.employee?.last_name?.[0] }}
                            </div>

                            <div>
                                <div class="text-sm font-medium text-gray-800">
                                    {{ a.employee?.first_name }}
                                    {{ a.employee?.last_name }}
                                </div>
                                <div class="mt-0.5 text-xs text-gray-500">
                                    {{ a.employee?.employee_code }} · effective
                                    {{ a.effective_date }}
                                </div>
                                <div
                                    v-if="
                                        a.employee?.position?.title ||
                                        a.employee?.department?.name
                                    "
                                    class="mt-0.5 text-xs text-gray-500"
                                >
                                    <span v-if="a.employee?.position?.title">{{
                                        a.employee?.position?.title
                                    }}</span>
                                    <span v-if="a.employee?.department?.name">
                                        at
                                        {{ a.employee?.department?.name }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <button
                            @click="remove_assignment(a)"
                            class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-200"
                        >
                            Remove
                        </button>
                    </div>
                </div>

                <!-- Empty state -->
                <p
                    v-else
                    class="rounded-lg border border-dashed border-gray-200 px-4 py-6 text-center text-sm text-gray-400"
                >
                    No employees assigned yet.
                </p>
                <div
                    v-if="assignments?.links?.last_page >1"
                    class="mt-4 flex flex-wrap gap-1"
                >
                    <Link
                        v-for="link in assignments.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        preserve-scroll
                        class="rounded-lg border px-3 py-1.5 text-xs"
                        :class="
                            link.active
                                ? 'border-blue-500 bg-blue-600 text-white'
                                : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
                        "
                    />
                </div>
                
            </div>

            <!-- Assign Form -->
            <div class="p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">
                    ➕ Assign Employee
                </h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <Search
                            v-model="form.employee_id"
                            label="Search Employees"
                            placeholder="Search Employee"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-3 block text-sm font-medium text-gray-700"
                        >
                            Effective Date
                        </label>
                        <input
                            type="date"
                            v-model="form.effective_date"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        @click="shift_assign"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                        :disabled="!form.employee_id || !form.effective_date"
                    >
                        Assign
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
