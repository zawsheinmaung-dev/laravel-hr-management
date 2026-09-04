<script setup>
import Layout from "../../Layouts/Layout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { route } from "ziggy-js";

defineOptions({
    name: "PositionEdit",
    layout: Layout,
});

const props = defineProps({
    position: Object,
    levels:Array,
    departments:Array
});

const form=useForm({
    title: props.position?.title ?? "",
    level:props.position?.level ?? "",
    department_id:props.position?.department?.id ?? "",
    description:props.position?.description ??""
})

function position_update()
{
    form.put(route('positions.update',props.position?.id),{
        preserveState:true
    })    
}
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
                    @click="position_update"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Update
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
                            v-model="form.title"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Level -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Level
                        </label>

                        <select
                            v-model="form.level"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="">Select Level</option>
                            <option v-for="lv in levels" :key="lv">{{lv}}</option>
                            
                        </select>
                    </div>
                    <!-- Department -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Department
                        </label>

                        <select
                            v-model="form.department_id"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="" disabled>Select Department</option>
                            <option v-for="dep in departments" :key="dep.id" :value="dep.id">{{dep.name}}</option>
                            
                        </select>
                    </div>
                    <!-- Department Manager -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Department Manager
                        </label>

                        <input
                            type="text"
                            readonly
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

                <textarea
                            v-model="form.description"
                            rows="3"
                            placeholder="Enter address"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 resize-none focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        ></textarea>
            </div>

        </div>
    </div>
</template>