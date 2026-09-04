<script setup>
import Layout from '../../Layouts/Layout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import Search from '../../Components/Search.vue';

defineOptions({
    name: 'BranchEdit',
    layout: Layout,
});

const props= defineProps({
    branches:Object
});

const form = useForm({
    name:props.branches?.name ?? "",
    address:props.branches?.address ?? "",
    phone:props.branches?.phone ??"",
    manager_id:props.branches?.manager_id ?? ""
})

function branch_update()
{
    form.put(route('branches.update',props.branches.id))
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
                    Branch Details
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Update branch information and manager details
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="`/branches/${branches.id}`"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2
                           text-sm font-medium text-gray-700
                           transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <button
                    @click.prevent="branch_update"
                    :disabled="form.processing"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm
                           font-medium text-white transition
                           hover:bg-blue-700 disabled:cursor-not-allowed
                           disabled:opacity-50"
                >
                    {{ form.processing ? "Updating..." : "Update" }}
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div
            class="overflow-visible rounded-xl border border-gray-200
                   bg-white shadow-sm"
        >
            <!-- Basic Information -->
            <div class="p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Basic information about this branch.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Branch Name -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Branch Name
                        </label>

                        <input
                            type="text"
                            v-model="form.name"
                            placeholder="Enter branch name"
                            class="w-full rounded-lg border border-gray-300
                                   bg-white px-3 py-2 text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:border-blue-500 focus:outline-none
                                   focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Branch Code -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Branch Code
                        </label>

                        <input
                            type="text"
                            readonly
                            :value="branches.code"
                            class="w-full cursor-not-allowed rounded-lg
                                   border border-gray-200 bg-gray-100
                                   px-3 py-2 text-sm text-gray-500"
                        />
                    </div>

                    <!-- Manager -->
                    <Search
                        v-model="form.manager_id"
                        label="Manager"
                        :initial-name="props.branches.manager ? `${props.branches.manager.first_name} ${props.branches.manager.last_name}` : ''"
                    />
                </div>
            </div>

            <!-- Contact Information -->
            <div class="border-t border-gray-200 p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Contact Information
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Contact details for this branch.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Phone -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Phone
                        </label>

                        <input
                            type="text"
                            v-model="form.phone"
                            placeholder="Enter phone number"
                            class="w-full rounded-lg border border-gray-300
                                   bg-white px-3 py-2 text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:border-blue-500 focus:outline-none
                                   focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Address
                        </label>

                        <textarea
                            v-model="form.address"
                            rows="4"
                            placeholder="Enter branch address"
                            class="w-full resize-none rounded-lg
                                   border border-gray-300 bg-white
                                   px-3 py-2 text-sm text-gray-700
                                   placeholder:text-gray-400
                                   focus:border-blue-500 focus:outline-none
                                   focus:ring-2 focus:ring-blue-100"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
