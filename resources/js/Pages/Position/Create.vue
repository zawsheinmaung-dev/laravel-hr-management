<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { useForm, Link } from "@inertiajs/vue3";

defineOptions({
    name: "PositionCreate",
    layout: Layout,
});

const props = defineProps({
    levels: Array,
    departments: Array,  
});

const form = useForm({
    title: "",
    level: "",
    department_id: "",
    description: "",
});

function position_create()
{
    console.log(form.data());
    form.post(route('positions.store'),{
        onSuccess:(success)=>{
            form.reset()
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
                    Create Position
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Create a new position and assign it to a department.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="route('positions.index')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <button
                    :disabled="form.processing"
                    @click.prevent="position_create"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ form.processing ? "Creating..." : "Create" }}
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Basic Information -->
            <div class="p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Basic information about this position.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Title -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Title
                        </label>

                        <input
                            type="text"
                            v-model="form.title"
                            placeholder="Enter position title"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Level -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Level
                        </label>

                        <select
                            v-model="form.level"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>Select level...</option>
                            <option v-for="lv in levels" :key="lv">
                                {{ lv }}
                            </option>
                        </select>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Department
                        </label>

                        <select
                            v-model="form.department_id"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>Select department...</option>
                            <option
                                v-for="dep in departments"
                                :key="dep.id"
                                :value="dep.id"
                            >
                                {{ dep.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="border-t border-gray-200 p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Description
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Responsibilities and requirements for this position.
                    </p>
                </div>

                <textarea
                    rows="5"
                    v-model="form.description"
                    placeholder="Enter position description..."
                    class="w-full resize-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                ></textarea>
            </div>
        </div>
    </div>
</template>