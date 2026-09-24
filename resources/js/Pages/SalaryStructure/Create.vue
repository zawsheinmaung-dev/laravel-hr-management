<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { ref } from "vue";

defineOptions({
    name: "SalaryStructureCreate",
    layout: Layout,
});

const props = defineProps({
    salarycomp: Object,
});
const form = useForm({
    name: "",
    description: "",
    select_componet_item: [],
});

function create_salary_structure() {
    form.post(route("salarystructure.store"), {
        preserveScroll: true,
        onSuccess: (success) => {
            form.reset();
        },
    });
}

const component_name = ref("");
const show_component = ref(false);
const select_componet_item = ref([]);
function filter_salary_component() {
    return props.salarycomp.filter((sc) =>
        sc.salary_component.name
            .toLowerCase()
            .includes(component_name.value.toLowerCase()),
    );
}

function select_componet(fc) {
    show_component.value = false;
    component_name.value = "";
    select_componet_item.value.push(fc);
    form.select_componet_item.push(fc);
}

function remove_componet(sci) {
    select_componet_item.value = select_componet_item.value.filter(
        (sc) => sc.id != sci.id,
    );
    form.select_componet_item = form.select_componet_item.filter(
        (id) => id != sci.salary_component.id,
    );
}
</script>

<template>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Create Salary Structure
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Define a salary structure and its description
            </p>
            <!-- Actions -->
            <div class="flex items-center justify-end gap-3">
                <Link
                    :href="route('salarystructure.index')"
                    class="px-4 py-2.5 rounded-lg border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    @click="create_salary_structure"
                    class="px-4 py-2.5 rounded-lg bg-gray-800 text-white text-sm font-medium hover:bg-gray-700 disabled:opacity-50"
                >
                    {{ form.processing ? "Saving..." : "Save Structure" }}
                </button>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <div>
                <!-- Name -->
                <div class="mb-5">
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Structure Name
                    </label>

                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="e.g. Manager Salary"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />

                    <div
                        v-if="form.errors.name"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <div class="mb-6">
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Description
                    </label>

                    <input
                        id="description"
                        v-model="form.description"
                        placeholder="e.g. Monthly salary structure for managers"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />

                    <div
                        v-if="form.errors.description"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>

                <!-- Salary Structure Items -->
                <div class="relative">
                    <!-- Input -->
                    <input
                        type="text"
                        v-model="component_name"
                        @focus="show_component = true"
                        autocomplete="off"
                        placeholder="Search salary component..."
                        class="relative z-30 w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    />

                    <!-- Outside Click Layer -->
                    <div
                        v-if="show_component"
                        class="fixed inset-0 z-10"
                        @click="show_component = false"
                    ></div>

                    <!-- Dropdown -->
                    <div
                        v-if="show_component"
                        class="absolute left-0 right-0 top-full z-20 mt-1 max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
                    >
                        <button
                            v-for="fsc in filter_salary_component()"
                            :key="fsc.id"
                            type="button"
                            class="block w-full border-b border-gray-100 px-3 py-2.5 text-left hover:bg-blue-50"
                            @click="select_componet(fsc)"
                        >
                            {{ fsc.salary_component.name }}
                        </button>
                    </div>
                </div>
                <div class="mt-4" v-if="select_componet_item.length">
                    <h3 class="mb-2 text-sm font-semibold text-gray-700">
                        Selected Salary Components
                    </h3>

                    <div class="space-y-2">
                        <div
                            v-for="sci in select_componet_item"
                            :key="sci.id"
                            class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-3 shadow-sm"
                        >
                            <!-- Left -->
                            <div>
                                <div class="font-medium text-gray-800">
                                    {{ sci.salary_component.name }}
                                </div>

                                <div
                                    class="mt-1 flex gap-2 text-xs text-gray-500"
                                >
                                    <span>
                                        {{ sci.salary_component.type }}
                                    </span>

                                    <span>•</span>

                                    <span>{{ sci.calculation_type }}</span>
                                </div>
                            </div>

                            <!-- Right -->
                            <div class="flex items-center gap-4">
                                <span class="font-medium text-gray-700">
                                    {{ sci.amount ?? sci.percentage }}
                                </span>

                                <button
                                    type="button"
                                    @click="remove_componet(sci)"
                                    class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-500"
                                >
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
