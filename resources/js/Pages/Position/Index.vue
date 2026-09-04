<script setup>
import { route } from 'ziggy-js';
import Layout from '../../Layouts/Layout.vue';
import { Link, router } from '@inertiajs/vue3';

defineOptions({
    name:'PositionIndex',
    layout:Layout
})

const props =defineProps({
    departments:Array,
    levels:Array
})

function position_delete(pos)
{
    if(!confirm("Are U Sure to delete?")) return
    router.delete(route('positions.destroy',pos.id),{
            preserveScroll:true
    })
}
</script>

<template>
    <div class="space-y-4">

        <!-- Header -->
        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    Employees
                </h1>

                <p class="text-xs text-gray-500 mt-1">
                </p>
            </div>

            <Link
                :href="route('positions.create')"
                class="px-3 py-1.5 rounded-lg
                       bg-blue-600 text-white text-xs
                       font-medium hover:bg-blue-700"
            >
                + Add Position
            </Link>

        </div>


        <!-- Filter -->
        <div class="flex items-center gap-2">

            <!-- Role -->
            <select
              
                class="px-3 py-2
                       text-sm
                       border border-gray-300
                       rounded-lg
                       bg-white
                       focus:outline-none
                       focus:ring-1
                       focus:ring-blue-300"
            >

                <option value="">
                    All Roles
                </option>

                <option
                  
                >
                </option>

            </select>

        </div>


        <!-- Table -->
        <div
            class="bg-white
                   border border-gray-200
                   rounded-xl
                   shadow-sm
                   overflow-hidden"
        >

            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50">

                    <tr class="border-b border-gray-200">

                        <th class="px-5 py-3">
                            #
                        </th>

                        <th class="px-5 py-3">
                            Titlet 
                        </th>

                        <th class="px-5 py-3">
                            Level
                        </th>

                        <th class="px-5 py-3">
                            Department
                        </th>
                        <th class="px-5 py-3">
                            Employee
                        </th>

                        <th class="px-5 py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr
                    v-for="value in departments"
                        class="border-b border-gray-100
                               hover:bg-gray-50"
                    >

                        <td class="px-5 py-3">
                            {{ value.id }}
                        </td>


                        <td class="px-5 py-3">
                            {{ value.title }}
                        </td>


                        <td class="px-5 py-3">
                            {{ value.level }}
                        </td>


                        <td class="px-5 py-3">
                            {{ value.department?.name }}
                        </td>



                        <td class="px-5 py-3">
                            {{ value.employees_count}}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex gap-1">

                                <Link
                                :href="route('positions.show',value.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-gray-100
                                           hover:bg-gray-200"
                                >
                                    View
                                </Link>

                                <Link
                                :href="route('positions.edit',value.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-blue-100
                                           hover:bg-blue-200"
                                >
                                    Edit
                                </Link>
                                <button 
                                @click="position_delete(value)"
                                            class="px-2 py-1
                                           rounded-lg
                                           bg-red-100
                                           hover:bg-red-200">Delete</button>
                            </div>
                        </td>

                    </tr>


                    <!-- No Result -->
                    <tr >

                        <td
                            colspan="5"
                            class="text-center
                                   py-10
                                   text-gray-500"
                        >
                            No users found.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
</template>