<script setup>
import { Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";

defineOptions({
    name: "TaxIndex",
    layout: Layout,
});
defineProps({
    tax_brackets: Object,
});
</script>

<template>
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">Tax Brackets</h1>

            <Link
                :href="route('taxbreacket.create')"
                class="rounded-lg bg-gray-800 px-4 py-2.5 text-white"
            >
                Add Tax Bracket
            </Link>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow">
            <table class="w-full text-left">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Min Amount</th>
                        <th class="px-4 py-3">Max Amount</th>
                        <th class="px-4 py-3">Rate</th>
                        <th class="px-4 py-3">Effective Year</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="tb in tax_brackets" class="border-b">
                        <td class="px-4 py-3">
                            {{ tb.min_amount }}
                        </td>

                        <td class="px-4 py-3">
                            {{ tb.max_amount }}
                        </td>

                        <td class="px-4 py-3">
                            {{ tb.rate_percentage + " %" }}
                        </td>

                        <td class="px-4 py-3">
                            {{ tb.effective_year }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <Link
                                :href="route('taxbreacket.edit',tb.id)"
                                class="mr-3 text-blue-600"
                            >
                                Edit
                            </Link>
                            <Link
                                :href="route('taxbreacket.show',tb.id)"
                                class="mr-3 text-blue-600"
                            >
                                View
                            </Link>
                            <Link
                                :href="route('taxbreacket.destroy',tb.id)"
                                method="delete"
                                as="button"
                                class="text-red-600"
                            >
                                Delete
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
