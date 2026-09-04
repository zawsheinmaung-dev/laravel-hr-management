<script setup>

import { router,useForm,Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js';
import Layout from '../../Layouts/Layout.vue';

defineOptions({
    layout: Layout,
    name: 'UserCreate'
})

defineProps({
    roles: Array,
})

const form =useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation:'',
    roles:[]
});

function sumbit(){
    form.post(route('users.store'),{
        onSuccess:((success)=>{
            console.log('success',success);
            form.reset()
            
        }),
        onError:((errors)=>{
            console.log('error',errors);
            
        })
    });
    
}


</script>


<template>

    <div class="max-w-xl mx-auto">

    <!-- Card -->
    <div
        class="bg-white border border-gray-200
               rounded-xl shadow-sm overflow-hidden"
    >

        <!-- Header -->
        <div
            class="flex items-center justify-between
                   px-5 py-4
                   border-b border-gray-200
                   bg-gray-50"
        >

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Add New User
                </h2>

                <p class="text-xs text-gray-500 mt-0.5">
                    Add user information and roles.
                </p>
            </div>



        </div>


        <!-- Form -->
        <form
            @submit.prevent="sumbit"
            class="p-5 flex flex-col gap-4"
        >

            <!-- Name -->
            <div>

                <label
                    for="name"
                    class="block text-sm
                           font-medium text-gray-700 mb-1"
                >
                    Name
                </label>

                <input
                    type="text"
                    name=""
                    id="name"
                    class="p-2
                           border border-gray-300
                           w-full
                           rounded-lg
                           text-sm
                           text-gray-700
                           focus:outline-none
                           focus:ring-1
                           focus:ring-blue-300
                           focus:border-blue-300"
                    v-model="form.name"
                >

                <i
                    v-if="form.errors.name"
                    class="block text-xs
                           text-red-500
                           mt-1"
                >
                    {{ form.errors.name }}
                </i>

            </div>


            <!-- Email -->
            <div>

                <label
                    for="email"
                    class="block text-sm
                           font-medium text-gray-700 mb-1"
                >
                    Email
                </label>

                <input
                    type="text"
                    name=""
                    id="email"
                    class="p-2
                           border border-gray-300
                           w-full
                           rounded-lg
                           text-sm
                           text-gray-700
                           focus:outline-none
                           focus:ring-1
                           focus:ring-blue-300
                           focus:border-blue-300
                           autofill:bg-white"
                    v-model="form.email"
                >

                <i
                    v-if="form.errors.email"
                    class="block text-xs
                           text-red-500
                           mt-1"
                >
                    {{ form.errors.email }}
                </i>

            </div>


            <!-- Password -->
            <div>

                <label
                    for="password"
                    class="block text-sm
                           font-medium text-gray-700 mb-1"
                >
                    Password
                    <span class="text-xs text-gray-400">
                        (optional)
                    </span>
                </label>

                <input
                    type="password"
                    name=""
                    id="password"
                    class="p-2
                           border border-gray-300
                           w-full
                           rounded-lg
                           text-sm
                           text-gray-700
                           focus:outline-none
                           focus:ring-1
                           focus:ring-blue-300
                           focus:border-blue-300"
                    v-model="form.password"
                >

                <i
                    v-if="form.errors.password"
                    class="block text-xs
                           text-red-500
                           mt-1"
                >
                    {{ form.errors.password }}
                </i>

            </div>


            <!-- Confirm Password -->
            <div>

                <label
                    for="confirm_password"
                    class="block text-sm
                           font-medium text-gray-700 mb-1"
                >
                    Confirm Password
                </label>

                <input
                    type="password"
                    name=""
                    id="confirm_password"
                    class="p-2
                           border border-gray-300
                           w-full
                           rounded-lg
                           text-sm
                           text-gray-700
                           focus:outline-none
                           focus:ring-1
                           focus:ring-blue-300
                           focus:border-blue-300
                           autofill:bg-white"
                    v-model="form.password_confirmation"
                >

                <i
                    v-if="form.errors.confirm_password"
                    class="block text-xs
                           text-red-500
                           mt-1"
                >
                    {{ form.errors.password_confirmation }}
                </i>

            </div>


            <!-- Roles -->
            <div>

                <div class="flex items-center justify-between mb-2">

                    <label
                        class="text-sm
                               font-medium
                               text-gray-700"
                    >
                        Roles
                    </label>

                    <span class="text-xs text-gray-400">
                        Select roles
                    </span>

                </div>


                <!-- Role Error -->
                <i
                    v-if="form.errors.roles"
                    class="block text-xs
                           text-red-500
                           mb-2"
                >
                    {{ form.errors.roles }}
                </i>


                <!-- Roles -->
                <div
                    class="grid grid-cols-2
                           sm:grid-cols-3
                           gap-2"
                >

                    <label
                        v-for="role in roles"
                        :key="role.id"
                        class="flex items-center gap-2
                               px-3 py-2
                               border border-gray-200
                               rounded-lg
                               cursor-pointer
                               hover:bg-blue-50
                               hover:border-blue-200
                               transition"
                    >

                        <input
                            type="checkbox"
                            name=""
                            id=""
                            :value="role.name"
                            v-model="form.roles"
                            class="w-4 h-4
                                   text-blue-600
                                   border-gray-300
                                   rounded
                                   focus:ring-blue-500"
                        >

                        <span
                            class="text-sm
                                   text-gray-700"
                        >
                            {{ role.name }}
                        </span>

                    </label>

                </div>

            </div>


            <!-- Bottom Actions -->
            <div
                class="flex justify-end
                       gap-2
                       pt-3
                       border-t border-gray-100"
            >

                <Link
                    :href="route('users.index')"
                    class="px-4 py-2
                           text-sm
                           rounded-lg
                           border border-gray-300
                           text-gray-600
                           hover:bg-gray-50
                           transition"
                >
                    Cancel
                </Link>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="px-4 py-2
                           text-sm
                           rounded-lg
                           bg-blue-600
                           text-white
                           font-medium
                           hover:bg-blue-700
                           transition
                           disabled:opacity-50
                           disabled:cursor-not-allowed"
                >
                    {{ form.processing ? 'Creating...' : 'Creating User' }}
                </button>

            </div>

        </form>

    </div>

</div>


</template>