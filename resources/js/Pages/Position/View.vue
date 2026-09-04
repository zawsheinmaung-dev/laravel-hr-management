<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { route } from "ziggy-js";

defineOptions({
    name: "PositionEdit",
    layout: Layout,
});

const props = defineProps({
    position: Object,
});

const dep_manager =computed(()=>{
    const head_dep =props.position?.head_emp
    return head_dep ? `${props.position?.head_emp?.first_name} ${props.position?.head_emp?.last_name}` : "--"
})
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Error -->
        <div
            v-if="Object.keys($page.props.errors).length"
            class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
        >
            <div
                v-for="(err, key) in $page.props.errors"
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
                    Position Details
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    View position information and assigned employees
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <Link
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Edit
                </Link>
            </div>
        </div>

        <!-- Main Card -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Basic Information -->
            <div class="p-6">
                <h2 class="mb-5 text-lg font-semibold text-gray-800">
                    Basic Information
                </h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Title -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Title
                        </label>

                        <input
                            type="text"
                            readonly
                            :value="position.title"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500"
                        />
                    </div>

                    <!-- Level -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Level
                        </label>

                        <span
                            v-if="position.level"
                            class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700"
                        >
                            {{ position.level }}
                        </span>
                        <span v-else class="text-sm text-gray-400">—</span>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Department
                        </label>

                        <input
                            type="text"
                            readonly
                            :value="position.department?.name ?? '—'"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500"
                        />
                    </div>
                    <!-- Department Manager -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Department Manager
                        </label>

                        <input
                            type="text"
                            readonly
                            :value="dep_manager"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500"
                        />
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 p-6">
                <h2 class="mb-5 text-lg font-semibold text-gray-800">
                    Description
                </h2>

                <p class="text-sm leading-relaxed text-gray-600">
                    {{ position.description ?? "No description provided." }}
                </p>
            </div>

            <!-- Assigned Employees -->
            <div class="border-t border-gray-200 p-6">
                <h2 class="mb-5 text-lg font-semibold text-gray-800">
                    Assigned Employees 
                </h2>

                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="px-5 py-3">Name</th>

                            <th class="px-5 py-3">Email</th>

                            <th class="px-5 py-3">Join Date</th>

                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="emp in position.employees"
                            :key="emp.id"
                            class="border-b border-gray-100 hover:bg-gray-50"
                        >
                            <td class="px-5 py-3 font-medium text-gray-800">
                                {{ emp.first_name }} {{ emp.last_name }}
                            </td>

                            <td class="px-5 py-3">{{ emp.personal_email ?? "—" }}</td>

                            <td class="px-5 py-3">{{ emp.join_date ?? "—" }}</td>

                            <td class="px-5 py-3">
                                <Link
                                    :href="route('employees.show', emp.id)"
                                    class="rounded-lg bg-gray-100 px-2 py-1 hover:bg-gray-200"
                                >
                                    View
                                </Link>
                            </td>
                        </tr>

                        <tr v-if="!position.employees.length">
                            <td colspan="4" class="py-10 text-center text-gray-500">
                                No employees assigned yet.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>