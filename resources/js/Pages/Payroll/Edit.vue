<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";

defineOptions({
    name: "PayrollWdit",
    layout: Layout,
});
const props=defineProps({
    salary:Object
})

const form = useForm({
    name:props?.salary?.name?? "",
    type: props?.salary?.type ??"",
    description:props?.salary?.description ?? "",
});

function update_salary_component() {
    form.put(route('payroll.update',props.salary.id))
}
</script>

<template>
    <div class="max-w-2xl mx-auto">
        <!-- Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
            <!-- Header -->
            <div
                class="px-6 py-5 border-b border-gray-200 flex items-center justify-between"
            >
                <!-- Left -->
                <div>
                    <h1 class="text-xl font-semibold text-gray-800">
                        Update Salary Component
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Update a new earning or deduction component
                    </p>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-3">
                    <Link
                        :href="route('payroll.index')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100"
                    >
                        Back
                    </Link>

                    <button
                        @click="update_salary_component"
                        type="button"
                        :disabled="form.processing"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 disabled:opacity-50"
                    >
                        {{
                            form.processing ? "Updating..." : "Update Component"
                        }}
                    </button>
                </div>
            </div>

            <!-- Form -->
            <div class="p-6 space-y-5">
                <!-- Component Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Component Name
                    </label>

                    <input
                        type="text"
                        placeholder="e.g. Housing Allowance"
                        v-model="form.name"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-500"
                    />
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Type
                    </label>

                    <select
                        v-model="form.type"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-500"
                    >
                        <option value="" disabled>Select type</option>

                        <option value="earning">Earning</option>

                        <option value="deduction">Deduction</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>

                    <textarea
                        v-model="form.description"
                        rows="4"
                        placeholder="Enter description..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-500"
                    ></textarea>
                </div>
            </div>
        </div>
    </div>
</template>
