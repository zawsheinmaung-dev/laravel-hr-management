<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({
    name:'EmployeeIndex',
    layout: Layout
})

const props =defineProps({
    employees:Array
})

function view_employee(emp){
    router.get(route('employees.show',emp.id))    
}

function employee_delete(id)
{
    if(!confirm("Are U sure to Delete?")){
        return 
    }
    router.delete(route('employees.destroy',id))
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
                    {{ employees.length }} employees
                </p>
            </div>

            <Link
                :href="route('employees.create')"
                class="px-3 py-1.5 rounded-lg
                       bg-blue-600 text-white text-xs
                       font-medium hover:bg-blue-700"
            >
                + Add Employee
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
                            Code
                        </th>

                        <th class="px-5 py-3">
                            Fast Name
                        </th>

                        <th class="px-5 py-3">
                            Last Name
                        </th>

                        <th class="px-5 py-3">
                            Email
                        </th>
                        <th class="px-5 py-3">
                            Department
                        </th>

                        <th class="px-5 py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr
                        v-for="employee in employees" :key="employee.id"
                        class="border-b border-gray-100
                               hover:bg-gray-50"
                    >

                        <td class="px-5 py-3">
                            {{ employee.employee_code }}
                        </td>


                        <td class="px-5 py-3">
                            {{ employee.first_name }}
                        </td>


                        <td class="px-5 py-3">
                            {{ employee.last_name }}

                        </td>


                        <td class="px-5 py-3">
                            {{ employee.personal_email }}
                        </td>



                        <td class="px-5 py-3">

                            {{ employee.department.name }}

                        </td>
                        <td class="px-5 py-3">
                            <div class="flex gap-1">

                                <Link
                                    :href="route('employees.show',employee.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-gray-100
                                           hover:bg-gray-200"
                                >
                                    View
                                </Link>

                                <Link
                                    :href="route('employees.edit',employee.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-blue-100
                                           hover:bg-blue-200"
                                >
                                    Edit
                                </Link>
                                <button 
                                    @click.prevent="employee_delete(employee.id)"
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