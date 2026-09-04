<script setup>
import Layout from '../../Layouts/Layout.vue';

defineOptions({
    name: 'EmployeeView',
    layout: Layout,
});

defineProps({
    employee:Object
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Employee Details
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    View employee profile and employment information.
                </p>
            </div>

            <div class="flex gap-2">
                <a
                    href="/employees"
                    class="px-4 py-2 text-sm rounded-lg border
                           border-gray-300 bg-white
                           hover:bg-gray-50"
                >
                    Back
                </a>

                <a
                    :href="`/employees/${employee.id}/edit`"
                    class="px-4 py-2 text-sm rounded-lg
                           bg-blue-600 text-white
                           hover:bg-blue-700"
                >
                    Edit Employee
                </a>
            </div>
        </div>


        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

            <!-- Profile Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-4">

                    <!-- Avatar -->
                    <div
                        class="w-16 h-16 rounded-full
                               bg-blue-100 text-blue-700
                               flex items-center justify-center
                               text-2xl font-bold"
                    >
                        {{ employee.first_name?.charAt(0).toUpperCase() }}
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ employee.first_name }}
                            {{ employee.last_name }}
                        </h2>

                        <p class="text-sm text-gray-500">
                            {{ employee.employee_code }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Personal Information -->
            <div class="p-6">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Personal Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Full Name -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Full Name
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.first_name }}
                            {{ employee.last_name }}
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Gender
                        </label>

                        <p class="mt-1 font-medium text-gray-800 capitalize">
                            {{ employee.gender ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Date of Birth
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.dob ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- National ID -->
                    <div>
                        <label class="text-sm text-gray-500">
                            National ID
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.national_id ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Phone
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.phone ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- Personal Email -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Personal Email
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.personal_email ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-500">
                            Address
                        </label>

                        <p class="mt-1 font-medium text-gray-800 whitespace-pre-line">
                            {{ employee.address ?? 'Not Provided' }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Company Account -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Company Account
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- User Name -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Account Name
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.user?.name ?? 'Not Assigned' }}
                        </p>
                    </div>

                    <!-- Company Email -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Company Email
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.user?.email ?? 'Not Assigned' }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Organization -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Organization
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Branch -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Branch
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.branch?.name ?? 'Not Assigned' }}
                        </p>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Department
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.department?.name ?? 'Not Assigned' }}
                        </p>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Position
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.position?.title ?? 'Not Assigned' }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Employment -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Employment Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Employee Code -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employee Code
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.employee_code }}
                        </p>
                    </div>

                    <!-- Employment Type -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employment Type
                        </label>

                        <p class="mt-1 font-medium text-gray-800 capitalize">
                            {{ employee.employment_type?.replace('_', ' ') }}
                        </p>
                    </div>

                    <!-- Employment Status -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employment Status
                        </label>

                        <span
                            class="inline-flex mt-1 px-3 py-1 rounded-full
                                   text-xs font-medium capitalize"
                            :class="{
                                'bg-green-100 text-green-700':
                                    employee.employment_status === 'active',

                                'bg-yellow-100 text-yellow-700':
                                    employee.employment_status === 'probation' ||
                                    employee.employment_status === 'on_leave',

                                'bg-red-100 text-red-700':
                                    employee.employment_status === 'resigned' ||
                                    employee.employment_status === 'terminated',
                            }"
                        >
                            {{ employee.employment_status?.replace('_', ' ') }}
                        </span>
                    </div>

                    <!-- Join Date -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Join Date
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.join_date ?? 'Not Provided' }}
                        </p>
                    </div>

                    <!-- Resign Date -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Resign Date
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.resign_date ?? 'Not Resigned' }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Salary -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Salary Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Salary Structure -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Salary Structure
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.salary_structure?.name ?? 'Not Assigned' }}
                        </p>
                    </div>

                    <!-- Basic Salary -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Basic Salary
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ Number(employee.basic_salary).toLocaleString() }}
                        </p>
                    </div>

                </div>
            </div>


            <!-- Account Activity -->
            <div class="p-6 border-t border-gray-200">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Account Activity
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Created -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Created At
                        </label>

                        <p class="mt-1 text-gray-800">
                            {{ employee.created_at }}
                        </p>
                    </div>

                    <!-- Updated -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Last Updated
                        </label>

                        <p class="mt-1 text-gray-800">
                            {{ employee.updated_at }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>