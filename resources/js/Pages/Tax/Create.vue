
<script setup>
import { useForm,Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";

defineOptions({
        name:'TaxCreate',
        layout : Layout
    })

    const form=useForm({
        min_amount:"",
        max_amount:"",
        rate_percentage:"",
        effective_year:""
    });

    function create_tax()
    {
        console.log(form.data());
        form.post(route('taxbreacket.store'),{
            onSuccess:(success)=>{
                console.log(success);
                form.reset();
            },
            onError:(err)=>{
                console.log(err);
            }
        })
    }
</script>

<template>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Create Tax Bracket
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Add a new tax bracket
            </p>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl rounded-xl bg-white p-6 shadow-sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <!-- Min Amount -->
                <div>
                    <label
                        for="min_amount"
                        class="mb-1.5 block text-sm font-medium text-gray-700"
                    >
                        Min Amount
                    </label>

                    <input
                        v-model="form.min_amount"
                        id="min_amount"
                        type="number"
                        step="0.01"
                        placeholder="Enter minimum amount"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />
                </div>

                <!-- Max Amount -->
                <div>
                    <label
                        for="max_amount"
                        class="mb-1.5 block text-sm font-medium text-gray-700"
                    >
                        Max Amount
                    </label>

                    <input
                    v-model="form.max_amount"
                        id="max_amount"
                        type="number"
                        step="0.01"
                        placeholder="Enter maximum amount"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />

                    <p class="mt-1 text-xs text-gray-500">
                        Leave empty for the highest bracket.
                    </p>
                </div>

                <!-- Tax Rate -->
                <div>
                    <label
                        for="rate_percentage"
                        class="mb-1.5 block text-sm font-medium text-gray-700"
                    >
                        Tax Rate (%)
                    </label>

                    <div class="relative">
                        <input
                            v-model="form.rate_percentage"
                            id="rate_percentage"
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            placeholder="Enter tax rate"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 pr-10 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                        />

                        <span
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500"
                        >
                            %
                        </span>
                    </div>
                </div>

                <!-- Effective Year -->
                <div>
                    <label
                        for="effective_year"
                        class="mb-1.5 block text-sm font-medium text-gray-700"
                    >
                        Effective Year
                    </label>

                    <input
                    v-model="form.effective_year"
                        id="effective_year"
                        type="number"
                        min="2000"
                        max="2100"
                        placeholder="e.g. 2026"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />
                </div>
            </div>

            <!-- Actions -->
            <div
                class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-5"
            >
                <Link
                    type="button"
                    :href="route('taxbreacket.index')"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </Link>

                <button
                    type="submit"
                    @click="create_tax"
                    class="rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700"
                >
                    Save Tax Bracket
                </button>
            </div>
        </div>
    </div>
</template>