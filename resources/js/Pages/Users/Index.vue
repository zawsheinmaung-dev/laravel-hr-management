<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import Layout from '../../Layouts/Layout.vue'

defineOptions({
    name: 'UsersIndex',
    layout: Layout,
})

const props = defineProps({
    users: Array,
    roles: Array,
})
const role=ref('');
function filter_user_by_role() {
    router.get(
        route('users.index'),
        {
            role: role.value,
        },
        {
            preserveState:true,
            preserveScroll:true,
            onSuccess:(success)=>{
                
            }
        }
    )
}

function user_delete(id){
    router.delete(route('users.destroy',id),{},{
        onSuccess:((success)=>{
            console.log('success',success);
            form.reset()
            
        }),
        onError:((errors)=>{
            console.log('error',errors);
            
        })
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
                    {{ users.length }} employees
                </p>
            </div>

        </div>


        <!-- Filter -->
        <div class="flex items-center gap-2">

            <!-- Role -->
            <select
                v-model="role"
                @change="filter_user_by_role"
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
                    v-for="role in roles"
                    :key="role.id"
                    :value="role.name"
                >
                    {{ role.name }}
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
                            Name
                        </th>

                        <th class="px-5 py-3">
                            Department
                        </th>

                        <th class="px-5 py-3">
                            Email
                        </th>

                        <th class="px-5 py-3">
                            Role
                        </th>

                        <th class="px-5 py-3">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="border-b border-gray-100
                               hover:bg-gray-50"
                    >

                        <td class="px-5 py-3">

                            <div class="flex items-center gap-2">

                                <div
                                    class="w-8 h-8
                                           rounded-full
                                           bg-blue-100
                                           text-blue-600
                                           flex items-center
                                           justify-center
                                           font-medium"
                                >
                                    {{ user.name?.charAt(0).toUpperCase() }}
                                </div>

                                <span>
                                    {{ user.name }}
                                </span>

                            </div>

                        </td>


                        <td class="px-5 py-3">
                            {{ user?.employee?.department?.name }}
                        </td>


                        <td class="px-5 py-3">
                            {{ user.email }}
                        </td>


                        <td class="px-5 py-3">

                            <div class="flex flex-wrap gap-1">

                                <span
                                    v-for="item in user.roles"
                                    :key="item.id"
                                    class="px-2 py-0.5
                                           rounded-full
                                           bg-purple-100
                                           text-purple-700
                                           text-xs"
                                >
                                    {{ item.name }}
                                </span>

                            </div>

                        </td>


                        <td class="px-5 py-3">

                            <div class="flex gap-1">

                                <Link
                                    :href="route('users.show', user.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-gray-100
                                           hover:bg-gray-200"
                                >
                                    View
                                </Link>

                                <Link
                                    :href="route('users.edit', user.id)"
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-blue-100
                                           hover:bg-blue-200"
                                >
                                    Edit
                                </Link>
                                <button @click.prevent="user_delete(user.id)" class="px-2 py-1
                                           rounded-lg
                                           bg-red-100
                                           hover:bg-red-200">Delete</button>
                            </div>

                        </td>

                    </tr>


                    <!-- No Result -->
                    <tr v-if="users.length === 0">

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