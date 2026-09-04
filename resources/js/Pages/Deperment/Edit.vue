<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import Search from "../../Components/Search.vue";

const show_parent_dep=ref(false);

let clear_interval;

defineOptions({
    name: "DepermentEdit",
    layout: Layout,
});

const props =defineProps({
    department:Object,
    departments:Array,
    branches:Array
})

const form =useForm({
    name:props.department?.name??"",
    description:props.department?.description??"",
    code:props.department?.code ?? "",
    parent_department_id:props.department?.parent_department_id??"",
    head_employee_id: props.department?.head_employee_id?? "",
    branch_id:props.department?.branch_id ??""

})
let manager_name=ref(props.department?.head_emp?.name??"");
let parent_dep_name=ref(props.department?.parent_dep?.name ??"");

function deparment_update()
{
    console.log(form.data());
    form.put(route('deparments.update',props.department.id))
    
}

function select_parent_dep(dep)
{
    console.log(dep)
    parent_dep_name.value =dep.name
    manager_name.value=dep.head_emp?.name
    show_parent_dep.value=false
    
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
                    Create Department
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Create a new department and configure its information.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                :href="route('deparments.show',department.id)"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <button
                    :disabled="form.processing"
                    @click.prevent="deparment_update"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ form.processing ? "Updating..." : "Update" }}
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div
            class="overflow-visible rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            <!-- Basic Information -->
            <div class="p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Basic information about this department.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Department Name -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Department Name
                        </label>

                        <input
                            type="text"
                            v-model="form.name"
                            placeholder="Enter department name"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Department Code -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Department Code
                        </label>

                        <input
                            type="text"
                            v-model="form.code"
                            readonly
                            placeholder="Generated automatically"
                            class="w-full cursor-not-allowed rounded-lg border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-500 placeholder:text-gray-400"
                        />
                    </div>
                    
                    <!-- Branch -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Branch
                        </label>

                        <select
                            v-model="form.branch_id"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>Select branch...</option>
                            <option
                                v-for="b in branches"
                                :key="b.id"
                                :value="b.id"
                            >
                                {{ b.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Parent Department -->
                    <div class="relative">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Parent Department
                        </label>

                        <input
                            type="text"
                            v-model="parent_dep_name"
                            @focus="show_parent_dep =true"
                            placeholder="Search parent department..."
                            autocomplete="off"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />

                        <!-- Parent Department Dropdown -->
                        <div
                            v-if="show_parent_dep"
                            class="absolute left-0 right-0 top-full z-50 mt-1 max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <div
                                v-for="parent_dep in departments" :key="parent_dep.id"
                                @click.prevent="select_parent_dep(parent_dep)"
                                class="cursor-pointer border-b border-gray-100 px-3 py-2.5 transition last:border-0 hover:bg-blue-50"
                            >
                                <div class="font-medium text-gray-800">
                                       {{ parent_dep.name }} 
                                </div>

                                <div class="mt-0.5 text-xs text-gray-500">
                                </div>
                            </div>
                        </div>

                        <!-- No Result -->
                        <div
                            v-if="show_parent_dep && departments.length ==0"
                            class="absolute left-0 right-0 top-full z-50 mt-1 rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm text-gray-500 shadow-lg"
                        >
                            No department found
                        </div>
                    </div>

                    <!-- Department Manager -->
                    <Search v-model="form.head_employee_id"  :initial-name="`${props.department?.head_emp?.first_name} ${props.department?.head_emp?.first_name}`" />
                </div>
            </div>

            <!-- Department Details -->
            <div class="border-t border-gray-200 p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Department Details
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Additional information about this department.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Description
                        </label>

                        <textarea
                            rows="5"
                            v-model="form.description"
                            placeholder="Enter department description..."
                            class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
