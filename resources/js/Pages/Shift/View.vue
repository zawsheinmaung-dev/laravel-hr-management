<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";
import { computed, ref } from "vue";

defineOptions({
    name: "ShiftView",
    layout: Layout,
});
const props = defineProps({
    shift: Object,
    assignments: Object,
});

const search = ref("");
const search_emp = computed(() => {
    if (!search.value) return props.assignments?.data ?? [];
    const search_value=search.value.toLowerCase();
    return props.assignments.data.filter(
        (ass) =>
            `${ass.employee?.first_name}${ass.employee?.flast_name}${ass.employee?.employee_code}`.toLowerCase().includes(search_value),
    );
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">
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
                <div v-if="assignments?.data?.length" class="space-y-2">
                    <div class="mb-4 flex items-center justify-between">
                        <input
                            v-model="search"
                            placeholder="Search..."
                            class="w-64 rounded-lg border px-3 py-2 text-sm"
                        />
                    </div>
                    <div
                        v-for="a in search_emp"
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
                    v-if="assignments?.links?.last_page > 1"
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
        </div>
    </div>
</template>
