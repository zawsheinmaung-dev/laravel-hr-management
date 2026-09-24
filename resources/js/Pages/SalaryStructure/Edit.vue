<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";
import { ref } from "vue";

defineOptions({
    name: "SalaryStructureEdit",
    layout: Layout,
});

const props = defineProps({
    salary: Object,
    salary_comp: Object,
});

const component_name = ref("");
const show_component = ref(false);
const show_select_component = ref(true);
const select_componet_item = ref(props.salary.salary_structure_items ?? []);

function filter_salary_component() {
    return props.salary_comp.filter((sc) =>
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
    console.log(form.select_componet_item);
}

function remove_componet(sci) {
    select_componet_item.value = select_componet_item.value.filter(
        (sc) => sc.id != sci.id,
    );
    form.select_componet_item = select_componet_item.value.filter(
        (id) => id != sci.salary_component.id,
    );
    console.log(form.select_componet_item);
}

const form = useForm({
    name: props?.salary?.name ?? "",
    description: props?.salary?.description ?? "",
    select_componet_item: select_componet_item.value,
});

function update_salary_structure() {
    form.put(route("salarystructure.update", props.salary.id));
}

const show_add = ref(false);
const show_add_component = ref(false);
const show_all = ref(true);
function add_item(sci) {
    show_all.value = false;
    show_add.value = true;
}

// const select_component_and_stracture_item =ref([]);

const item_form=useForm({
    component_id:"",
    component_item_name:"",
    calculation_type:"",
    amount:"",
    percentage:"",
    effective_date:""


})
function select_component_stracture_item(item)
{
    show_add_component.value=false
    item_form.component_id=item?.salary_component.id
    item_form.component_item_name=item?.salary_component?.name
    item_form.calculation_type=item?.calculation_type
    item_form.amount=item?.amount
    item_form.percentage=item?.percentage
    item_form.effective_date=item?.effective_date
    console.log('items',item);
    
    
}

function add_structure_item()
{
    console.log(item_form.data());
    console.log(form.data());
    
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
        </div>

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <form @submit.prevent="update_salary_structure">
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

                <!-- Description -->
                <div class="mb-6">
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        placeholder="e.g. Monthly salary structure for managers"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    ></textarea>

                    <div
                        v-if="form.errors.description"
                        class="text-sm text-red-600 mt-1"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>
                <!-- Table Card -->

                <div v-if="show_all">
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
                        <div
                            v-if="form.errors.select_componet_item"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.select_componet_item }}
                        </div>
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

                    <div
                        class="mt-4"
                        v-if="
                            show_select_component 
                        "
                    >
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
                                        {{ sci?.salary_component?.name }}
                                    </div>

                                    <div
                                        class="mt-1 flex gap-2 text-xs text-gray-500"
                                    >
                                        <span>
                                            {{ sci?.salary_component?.type }}
                                        </span>

                                        <span>•</span>

                                        <span>{{ sci?.calculation_type }}</span>
                                    </div>
                                </div>

                                <!-- Right -->
                                <div class="flex items-center gap-4">
                                    <span class="font-medium text-gray-700">
                                        {{ sci?.amount ?? sci?.percentage }}
                                    </span>
                                    <button
                                type="button"
                                @click="add_item(sci)"
                                class="flex w-full items-center gap-3 border-b border-blue-100 bg-blue-50 px-4 py-3 text-left text-blue-700 hover:bg-blue-100"
                            >
                                <span class="flex flex-col">
                                    <span class="text-sm font-semibold">
                                       edit
                                    </span>
                                </span>
                            </button>


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
                            class="px-4 py-2.5 rounded-lg bg-gray-800 text-white text-sm font-medium hover:bg-gray-700 disabled:opacity-50"
                        >
                            {{
                                form.processing ? "Saving..." : "Save Structure"
                            }}
                        </button>
                    </div>
                </div>
                
            </form>
            <form @submit.prevent="add_structure_item">
                <div
                    v-if="show_add"
                    class="mt-4 rounded-lg border border-blue-100 bg-blue-50/50 p-4"
                >
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-800">
                            Edit Salary Item
                        </h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Configure the selected salary component
                        </p>
                    </div>

                    <!-- Salary Component -->
                    <div class="mb-4">
                        <div class="relative">
                        <!-- Input -->
                        <input
                            v-model="item_form.component_item_name"
                            type="text"
                            autocomplete="off"
                            placeholder="Search salary component..."
                            class="relative z-30 w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        />
                        <div
                            v-if="form.errors.select_componet_item"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ form.errors.select_componet_item }}
                        </div>
                        <!-- Outside Click Layer -->
                        <div
                            v-if="show_add_component"
                            class="fixed inset-0 z-10"
                            @click="show_add_component =false"
                        ></div>

                        <!-- Dropdown -->
                        <div
                            v-if="show_add_component"
                            class="absolute left-0 right-0 top-full z-20 mt-1 max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                           

                            <button
                                v-for="fsc in filter_salary_component()"
                                :key="fsc.id"
                                type="button"
                                @click="select_component_stracture_item(fsc)"
                                class="block w-full border-b border-gray-100 px-3 py-2.5 text-left hover:bg-blue-50"
                            >
                                {{ fsc.salary_component.name }}
                            </button>
                        </div>
                    </div>
                    </div>

                    <!-- Calculation Type -->
                    <div class="mb-4">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Calculation Type
                        </label>

                        <select
                            v-model="item_form.calculation_type"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm"
                        >
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="mb-4" >
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Amount
                        </label>

                        <input
                            v-model="item_form.amount"
                            type="number"
                            min="0"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm"
                            placeholder="Enter amount"
                        />
                    </div>

                    <!-- Percentage -->
                    <div class="mb-4">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Percentage
                        </label>

                        <div class="relative">
                            <input
                                v-model="item_form.percentage"
                                type="number"
                                min="0"
                                max="100"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 text-sm"
                                placeholder="Enter percentage"
                            />

                            <span
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                            >
                                %
                            </span>
                        </div>
                    </div>

                    <!-- Effective Date -->
                    <div class="mb-4">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Effective Date
                        </label>

                        <input
                            v-model="item_form.effective_date"
                            type="date"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm"
                        />
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            @click="show_add = false; show_all=true"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                        >
                            + Add Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
