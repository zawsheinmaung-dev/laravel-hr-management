<script setup>
import { useForm } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";

defineOptions({
    name: "HolidayCreate",
    layout: Layout,
});

const form =useForm({
    name:"",
    holiday_date:"",
    is_recurring:"",
    description:""
})

function create_holiday()
{
    console.log(form.data());
    
}
</script>
<template>
    <div class="mx-auto max-w-2xl p-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <!-- Header -->
            <div
                class="mb-6 border-b border-gray-100 pb-4 flex justify-between"
            >
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Create Holiday
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Add a public or company holiday
                    </p>
                </div>
                <!-- Actions -->
                <div
                    class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5"
                >
                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                    <button
                        @click.prevent="create_holiday"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Create Holiday
                    </button>
                </div>
            </div>

            <!-- Holiday Name -->
            <div class="mb-5">
                <label
                    for="name"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Holiday Name
                    <span class="text-red-500">*</span>
                </label>

                <input
                    v-model="form.name"
                    id="name"
                    type="text"
                    placeholder="e.g. New Year's Day"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />
            </div>

            <!-- Holiday Date -->
            <div class="mb-5">
                <label
                    for="date"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Holiday Date
                    <span class="text-red-500">*</span>
                </label>

                <input
                    v-model="form.holiday_date"
                    id="date"
                    type="date"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                />
            </div>

            <!-- Recurring -->
            <div class="mb-5">
                <label class="flex cursor-pointer items-start gap-3">
                    <input
                        v-model="form.is_recurring"
                        type="checkbox"
                        class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />

                    <div>
                        <div class="text-sm font-medium text-gray-700">
                            Recurring Holiday
                        </div>

                        <p class="mt-1 text-xs text-gray-500">
                            This holiday repeats every year.
                        </p>
                    </div>
                </label>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label
                    for="description"
                    class="mb-2 block text-sm font-medium text-gray-700"
                >
                    Description
                </label>

                <textarea
                    v-model="form.description"
                    id="description"
                    rows="4"
                    placeholder="Add a description (optional)"
                    class="w-full resize-none rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                ></textarea>
            </div>
        </div>
    </div>
</template>
