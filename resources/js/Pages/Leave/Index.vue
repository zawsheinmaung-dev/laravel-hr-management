<script setup>
import Layout from '../../Layouts/Layout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({
    name:'LeaveIndex',
    layout:Layout,
    inheritAttrs:false
})

</script>

<template>
    <!-- <div
        v-if="Object.keys(form?.errors).length"
        class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4"
    >
        <div
            v-for="(er, key) in form?.errors"
            :key="key"
            class="text-sm text-red-600"
        >
            {{ er }}
        </div>
    </div> -->
    <!-- Compact Overtime Form -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-4">
        <form
            class="flex flex-wrap items-end gap-3"
        >
            <!-- Employee -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-600 mb-1"
                    >Employee</label
                >
                <input
                    readonly
                    class="w-full rounded-lg border border-gray-300 px-2 py-1.5 text-sm focus:border-blue-500"
                />
            </div>

            <!-- Date -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1"
                    >Date</label
                >
                <input
                    type="date"
                    class="rounded-lg border border-gray-300 px-2 py-1.5 text-sm"
                />
            </div>

            <!-- From -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1"
                    >From</label
                >
                <input
                    type="time"
                    class="rounded-lg border border-gray-300 px-2 py-1.5 text-sm"
                />
            </div>

            <!-- To -->
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1"
                    >To</label
                >
                <input
                    type="time"
                    class="rounded-lg border border-gray-300 px-2 py-1.5 text-sm"
                />
            </div>

            <!-- Reason -->
            <div class="flex-1 min-w-45">
                <label class="block text-xs font-medium text-gray-600 mb-1"
                    >Reason</label
                >
                <input
                    type="text"
                    class="w-full rounded-lg border border-gray-300 px-2 py-1.5 text-sm"
                    placeholder="Reason..."
                />
            </div>

            <!-- Submit -->
            <div>
                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
    <div
        class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
    >
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50">
                <tr class="border-b border-gray-200">
                    <th class="px-5 py-3">Employee</th>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">From</th>
                    <th class="px-5 py-3">To</th>
                    <th class="px-5 py-3">Hours</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="border-b border-gray-100 hover:bg-gray-50"
                >
                    <td class="px-5 py-3">
                    </td>
                    <td class="px-5 py-3"></td>
                    <td class="px-5 py-3"></td>
                    <td class="px-5 py-3"></td>
                    <td class="px-5 py-3"></td>
                    <td class="px-5 py-3">
                        <span
                            class="px-2 py-1 rounded-full text-xs text-red-500"
                        </span>
                    </td>
                    <td class="px-2 py-1 rounded-full text-xs">
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1">
                            <div class="flex gap-1" >
                                <button
                                    class="px-2 py-1 rounded-lg bg-green-100 hover:bg-green-200"
                                >
                                    Approve
                                </button>
                                <button
                                    class="px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200"
                                >
                                    Reject
                                </button>
                            </div>
                            <Link
                                class="px-2 py-1 rounded-lg bg-gray-100 hover:bg-gray-200"
                                >View</Link
                            >
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-500">
                        No overtime requests found.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
