<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";

defineOptions({
    name: "ShiftCreate",
    layout: Layout,
});

const form = useForm({
    name: "",
    start_time: "",
    end_time: "",
    grace_minutes: "",
    break_minutes: "",
});

function shift_create() {
    console.log(form.data());
    form.post(route('shifts.store'),{
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
                <h1 class="text-2xl font-bold text-gray-800">Create Shift</h1>

                <p class="mt-1 text-sm text-gray-500">
                    Create a new shift and configure its information.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="route('shifts.index')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Back
                </Link>

                <button
                    @click="shift_create"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    {{ form.processing ? "Creating..." : "Create" }}
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
                        Basic information about this shift.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Shift Name -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Shift Name
                        </label>

                        <input
                            type="text"
                            v-model="form.name"
                            placeholder="Enter department name"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Allow Late minutes -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Allow Late Minutes
                        </label>

                        <input
                            type="number"
                            v-model="form.grace_minutes"
                            list="minute_options"
                            min="0"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm ..."
                        />

                        <datalist id="minute_options">
                            <option
                                v-for="m in [5, 10, 15, 20, 30, 45, 60]"
                                :key="m"
                                :value="m"
                            />
                        </datalist>
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Start Time
                        </label>

                        <input
                            type="time"
                            v-model="form.start_time"
                            placeholder="Generated automatically"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Parent Department -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            End Time
                        </label>

                        <input
                            type="time"
                            v-model="form.end_time"
                            placeholder="Generated automatically"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                </div>
            </div>

            <!-- Break Time Details -->
            <div class="border-t border-gray-200 p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Break Time
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">Break Time Details</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Break Time -->
                    <div class="md:col-span-2">
                        <label
                            class="mb-1.5 block text-sm font-medium text-gray-700"
                        >
                            Break Time
                        </label>

                        <input
                            type="number"
                            v-model="form.break_minutes"
                            list="minute_options"
                            min="0"
                            class="w-50 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm ..."
                        />

                        <datalist id="minute_options">
                            <option
                                v-for="m in [5, 10, 15, 20, 30, 45, 60]"
                                :key="m"
                                :value="m"
                            />
                        </datalist>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
