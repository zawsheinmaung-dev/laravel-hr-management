<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";
import { ref } from "vue";

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
    structure_id: props?.salary?.salary_structures[0]?.id ?? "",
    structure_name:props?.salary?.salary_structures[0]?.name ?? "",
    structure_description:props?.salary?.salary_structures[0]?.description ?? "",
    selected_items:props?.salary?.salary_component_items ?? []
});

function update_salary_component() {
    form.put(route('payroll.update',props.salary.id))
}

const item_form = useForm({
    calculation_type: "",
    amount: "",
    percentage: "",
    effective_date: "",
});

function add_items() {
    const item = item_form.data();
    console.log(item);
    
    if (
        !item.calculation_type ||
        !item.effective_date ||
        (item.calculation_type === "fixed" && !item.amount) ||
        (item.calculation_type === "percentage" && !item.percentage)
    )
        return;

    if (item.calculation_type === "fixed") {
        item.percentage = null;
    }

    if (item.calculation_type === "percentage") {
        item.amount = null;
    }

    form.selected_items.push(item);
}

function remove_selected_item(item) {

    form.selected_items = form.selected_items.filter(
        (selected) => selected !== item,
    );
}
</script>

<template>
    <div class="max-w-5xl mx-auto">
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
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <!-- Component Information -->
            <div class="mb-6 rounded-lg border border-gray-200 p-5">
                <h2 class="mb-5 text-base font-semibold text-gray-800">
                    Component Information
                </h2>

                <!-- Component Name -->
                <div class="mb-5">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Component Name
                    </label>

                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                    />
                </div>

                <!-- Type -->
                <div class="mb-5">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Type
                    </label>

                    <select
                        v-model="form.type"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                    >
                        <option value="">Select Type</option>
                        <option value="earning">Earning</option>
                        <option value="deduction">Deduction</option>
                    </select>
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                    v-model="form.description"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                    ></textarea>
                </div>
            </div>

            <!-- Salary Structure -->
            <div class="mb-6 rounded-lg border border-gray-200 p-5">
                <h2 class="mb-5 text-base font-semibold text-gray-800">
                    Salary Structure
                </h2>

                <!-- Structure Name -->
                <div class="mb-5">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Structure Name
                    </label>

                    <input
                        v-model="form.structure_name"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                    />
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        v-model="form.structure_description"
                        rows="3"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                    ></textarea>
                </div>
            </div>

            <!-- Salary Structure Items -->
            <div class="rounded-lg border border-gray-200 p-5">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-gray-800">
                        Salary Structure Items
                    </h2>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <!-- Table Header -->
                    <div
                        class="grid grid-cols-4 gap-4 border-b border-gray-200 bg-gray-50 px-4 py-3 text-xs font-semibold text-gray-600"
                    >
                        <div>Calculation Type</div>
                        <div>Amount / Percentage</div>
                        <div>Effective Date</div>
                        <div>Actions</div>
                    </div>

                    <!-- Add Item -->
                    <div
                        class="grid grid-cols-4 items-center gap-4 border-b border-gray-200 px-4 py-3"
                    >
                        <!-- Calculation Type -->
                        <select
                        v-model="item_form.calculation_type"
                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        >
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>

                        <!-- Amount / Percentage -->
                        <input
                             v-if="item_form.calculation_type === 'fixed'"
                            v-model="item_form.amount"
                            type="number"
                            min="0"
                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        />

                        <input
                            v-else
                            v-model="item_form.percentage"
                            type="number"
                            min="0"
                            max="100"
                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        />

                        <!-- Effective Date -->
                        <input
                            v-model="item_form.effective_date"
                            type="date"
                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        />

                        <!-- Add -->
                        <button
                            type="button"
                            @click.prevent="add_items"
                            class="w-fit rounded-lg border border-blue-200 px-3 py-2 text-sm text-blue-600 hover:bg-blue-50"
                        >
                            Add
                        </button>
                    </div>

                    <!-- Selected Items -->
                    <div
                        v-for="si in form.selected_items" :key="si.id"
                        class="grid grid-cols-4 items-center gap-4 border-b border-gray-200 px-4 py-3"
                    >
                        <!-- Calculation Type -->
                        <div
                            class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm"
                        >
                        {{ si.calculation_type }}
                        </div>

                        <!-- Amount / Percentage -->
                        <div
                            class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm"
                        >
                        {{ si?.calculation_type =="fixed" ? si.amount : si?.percentage+ ' %' }}
                        </div>

                        <!-- Effective Date -->
                        <div
                            class="rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm"
                        >
                        {{ si.effective_date }}
                        </div>

                        <!-- Delete -->
                        <button
                            type="button"
                            @click.prevent="remove_selected_item(si)"
                            class="w-fit rounded-lg border border-red-200 px-3 py-2 text-sm text-red-500 hover:bg-red-50"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</template>
