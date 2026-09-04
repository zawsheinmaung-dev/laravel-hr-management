<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import axios, { create } from "axios";
import { ref } from "vue";

let show_manager=ref(false);
let manager_name=ref("");
let manager_dropdown=ref(false);
let managers =ref([]);
let clear_interval;

defineOptions({
    name: "EmployeeCreate",
    layout: Layout,
});

const props = defineProps({
    department: Array,
    position: Array,
    branch: Array,
});

const form = useForm({
    first_name: "",
    last_name:  "",
    gender: '',
    dob:    "",
    phone: "",
    personal_email: "",
    address:  "",
    department_id: "",
    national_id:"",
    position_id:  "",
    branch_id:"",
    manager_id:"",
    employment_type:"",
    join_date: "",
});

function employee_create()
{
    form.post(route('employees.store'),{
        onSuccess:(success)=>{
            form.reset()
        }
    })
}

function search_manager()
{
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
        managers.value=res.data.employees
        show_manager.value=true
    }).catch(err=>{
        
    })
    },2000)
      
}

function select_manger(manager)
{
    manager_name.value=`${manager.first_name} ${manager.last_name}`
    form.manager_id=manager.id
    show_manager.value=false
    
    
}

function select_dep()
{
    const dep_head =props.department.find(d=>d.id === Number(form.department_id))
    if(dep_head?.head_emp)
    {
        form.manager_id=dep_head.head_emp?.id
        manager_name.value=`${dep_head.head_emp?.first_name} ${dep_head.head_emp?.last_name}`
    }else{
        manager_name.value="";
        form.manager_id=""
    }    
}

</script>
<template>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                
                <h1 class="text-2xl font-bold text-gray-800">
                    Add New Employee
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Add employee profile and employment information.
                </p>
                <p v-if="form.errors">
                    <span v-for="err in form.errors" :key="err.id">{{ err }}</span>
                </p>
            </div>

            <div >
                
                <button
                    @click="employee_create"
                    class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                {{ form.processing ? 'Creating .....' :'Create' }}
                </button>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
           

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
                            <option value="">Select Gender</option>
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
                            rows="3"
                            v-model="form.address"
                            placeholder="Enter address"
                            class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 resize-none focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        ></textarea>
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
            <label class="block mb-1.5 text-sm font-medium text-gray-700">
                Branch
            </label>

            <select
                v-model="form.branch_id"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
                <option value="">Select Branch</option>

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
                @change="select_dep"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
                <option value="">Select Department</option>

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
            <label class="block mb-1.5 text-sm font-medium text-gray-700">
                Position
            </label>

            <select
                v-model="form.position_id"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
                <option value="">Select Position</option>

                <option
                    v-for="pos in position"
                    :key="pos.id"
                    :value="pos.id"
                >
                    {{ pos.title }}
                </option>
            </select>
        </div>


        <!-- Manager -->
        <div class="relative">
            <label class="block mb-1.5 text-sm font-medium text-gray-700">
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
                    

                    <!-- Employment Type -->
                    <div>
                        <label class="text-sm text-gray-500">
                            Employment Type
                        </label>

                        <select
                            v-model="form.employment_type"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm font-medium text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="">Select Employment Type</option>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="contract">Contract</option>
                            <option value="intern">intern</option>
                        </select>
                    </div>

                 

                    <!-- Join Date -->
                    <div>
                        <label class="text-sm text-gray-500"> Join Date </label>

                        <input
                            v-model="form.join_date"
                            type="date"
                            class="w-40 rounded-md border border-gray-300 bg-white px-2 py-1.5 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        />
                    </div>

                   
                </div>
            </div>

            
        </div>
    </div>
</template>
