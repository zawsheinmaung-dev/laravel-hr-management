<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

let clear_interval;
let managers=ref([]);
let show_manager=ref(false);

defineOptions({
    name: "EmployeeEdit",
    layout: Layout,
});

const props = defineProps({
    employee: Object,
    department: Array,
    position: Array,
    branch: Array,
});

const form = useForm({
    first_name: props.employee.first_name ?? "",
    last_name: props.employee.last_name ?? "",
    gender: props.employee.gender ?? "",
    dob: props.employee.dob ?? "",
    national_id: props.employee.national_id ?? "",
    phone: props.employee.phone ?? "",
    personal_email: props.employee.personal_email ?? "",
    address: props.employee.address,
    company_mail: props.employee.user.email,
    branch_id: props.employee.branch?.id ?? "",
    department_id: props.employee.department.id ?? "",
    manager_id: props.employee.manager_id ?? "",
    position_id: props.employee.position.id ?? "",
    employment_type: props.employee.employment_type ?? "",
    employment_status: props.employee.employment_status ?? "",
    join_date: props.employee.join_date ?? "",
    basic_salary: props.employee.basic_salary ?? "",
});

function employee_update() {
    console.log(form.data());
    form.put(route("employees.update", props.employee.id));
}

let manager_name=ref(props.employee.manager ? `${props.employee.manager.first_name} ${props.employee.manager.last_name}`:'');

function search_manager()
{
    console.log(manager_name.value);
    clearTimeout(clear_interval)
    if(manager_name.value.length <2)
        {
            managers.value=[];
            form.manager_id="";
            show_manager.value=false
            return;
        }
    
    clear_interval = setTimeout(()=>{
        axios.get(route('search.manager'),{
        params:{search:manager_name.value}
    }).then(res=>{
        console.log(res.data);
        managers.value=res.data.employees
        show_manager.value=true
    }).catch(err=>{
        console.log(err.data);
        
    })
    },2000)
      
}

function select_manger(manager)
{
    console.log(manager);
    manager_name.value=`${manager.first_name} ${manager.last_name}`
    form.manager_id=manager.id
    show_manager.value=false
    
}
</script>
<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span v-if="form.errors">
                    <p v-for="err in form.errors">{{ err }}</p>
                </span>
                <h1 class="text-2xl font-bold text-gray-800">
                    Employee Details
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    View employee profile and employment information.
                </p>
            </div>

            <div class="flex gap-2">
                <Link
                    :href="`/employees/${employee.id}`"
                    class="px-4 py-2 text-sm rounded-lg border border-gray-300 bg-white hover:bg-gray-50"
                >
                    Back
                </Link>

                <button
                    @click.prevent="employee_update"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                    {{ form.processing ? "Updating" : "Update" }}
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <!-- Profile Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <!-- Avatar -->
                    <div
                        class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-bold"
                    >
                        {{ props.employee.first_name?.charAt(0).toUpperCase() }}
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ props.employee.first_name }}
                            {{ props.employee.last_name }}
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
                            First Name
                        </label>

                        <input
                            type="text"
                            v-model="form.first_name"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="text-sm text-gray-500"> Last Name </label>

                        <input
                            type="text"
                            v-model="form.last_name"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Gender
                        </label>

                        <select
                            v-model="form.gender"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Date of Birth
                        </label>

                        <input
                            type="date"
                            v-model="form.dob"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <!-- National ID -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            National ID
                        </label>

                        <input
                            type="text"
                            v-model="form.national_id"
                            placeholder="Enter National ID"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Phone
                        </label>

                        <input
                            type="tel"
                            v-model="form.phone"
                            placeholder="Enter phone number"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Personal Email -->
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">
                            Personal Email
                        </label>

                        <input
                            type="email"
                            v-model="form.personal_email"
                            placeholder="Enter personal email"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-500 mb-1">
                            Address
                        </label>

                        <textarea
                            v-model="form.address"
                            rows="3"
                            placeholder="Enter address"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 resize-none focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        ></textarea>
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
                        <label class="block text-sm text-gray-500 mb-1">
                            Account Name
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.user?.name ?? "Not Assigned" }}
                        </p>
                    </div>

                    <!-- Company Email -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Company Email
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.user?.email ?? "Not Assigned" }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Organization -->
            <div class="p-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Organization
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- Branch -->
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700"> Branch </label>

                        <select
                            v-model="form.branch_id"
                           class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option
                                v-for="bch in branch"
                                :key="bch.id"
                                :value="bch.id"
                            >
                                {{ bch.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700">
                            Department
                        </label>

                        <select
                            v-model="form.department_id"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option
                                v-for="dep in department"
                                :key="dep.id"
                                :value="dep.id"
                            >
                                {{ dep.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700"> Position </label>
                        <select
                            v-model="form.position_id"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option
                                v-for="pos in position"
                                :key="pos.id"
                                :value="pos.id"
                            >
                                {{ pos.title }}
                            </option>
                        </select>
                    </div>
                    <div class="relative">
                        <label
                            class="block mb-1.5 text-sm font-medium text-gray-700"
                        >
                            Manager
                        </label>

                        <input
                            type="text"
                            v-model="manager_name"
                            @input="search_manager"
                            placeholder="Search manager..."
                            autocomplete="off"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />

                        <!-- Manager Dropdown -->
                        <div
                            v-if="show_manager && managers.length"
                            class="absolute left-0 right-0 top-full z-50 mt-1 max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <div
                                v-for="manager in managers"
                                :key="manager.id"
                                @click="select_manger(manager)"
                                class="cursor-pointer border-b border-gray-100 px-3 py-2.5 transition last:border-0 hover:bg-blue-50"
                            >
                                <div class="text-sm font-medium text-gray-800">
                                    {{ manager.first_name }}
                                    {{ manager.last_name }}
                                </div>

                                <div class="mt-0.5 text-xs text-gray-500">
                                    {{ manager.employee_code }}
                                </div>

                                <div class="mt-0.5 text-xs text-gray-500">
                                    {{ manager.personal_email }}
                                </div>
                            </div>
                        </div>

                        <!-- No Result -->
                        <div
                            v-if="show_manager && managers.length === 0"
                            class="absolute left-0 right-0 top-full z-50 mt-1 rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm text-gray-500 shadow-lg"
                        >
                            Not found
                        </div>
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

                        <select
                            v-model="form.employment_type"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm font-medium text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="contract">Contract</option>
                            <option value="intern">intern</option>
                        </select>
                    </div>

                    <!-- Employment Status -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employment Status
                        </label>

                        <select
                            v-model="form.employment_status"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm font-medium text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="permanent">Permanent</option>
                            <option value="probation">Probation</option>
                            <option value="resigned">Resigned</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>

                    <!-- Join Date -->
                    <div>
                        <label class="text-sm text-gray-500"> Join Date </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.join_date ?? "Not Provided" }}
                        </p>
                    </div>

                    <!-- Resign Date -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Resign Date
                        </label>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ employee.resign_date ?? "Not Resigned" }}
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
                            {{
                                employee.salary_structure?.name ??
                                "Not Assigned"
                            }}
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
