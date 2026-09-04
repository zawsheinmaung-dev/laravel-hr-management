<script setup>
import { computed, ref } from "vue";
import Layout from "../../Layouts/Layout.vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { route } from "ziggy-js";

const search = ref("");
const selectedUser = ref(null);
const selectedPermissions = ref([]);
const selectedRole = ref(null);
const showCreateRole = ref(false);
const newRoleName = ref("");
const newRolePermissions = ref([]);
const showUpdateRole = ref(false);
const showEditRole=ref(false)
// const editSelectRoleName=ref(null)
const editRoleName=ref("")
const editNewRole=ref()

defineOptions({
    name: "RoleIndex",
    layout: Layout,
});

const props = defineProps({
    users: Array,
    permissions: Array,
    roles: Array,
    errors: Array | Object,
});
const roles =ref(props.roles)

function search_user() {
    router.get(
        route("get_role"),
        {
            search: search.value,
        },
        {},
    );
}

const group_permissions = computed(() => {
    const groups = {};

    props.permissions.forEach((permission) => {
        const group = permission.name.split(".")[0];

        if (!groups[group]) {
            groups[group] = [];
        }
        groups[group].push(permission);
    });

    return groups;
});

function update_permission() {
    axios
        .post(route("update_role"), {
            user_id: selectedUser.value.id,
            role_id: selectedRole.value,
            permissions: selectedPermissions.value,
        })
        .then((res) => {
            console.log(res.data.user.roles);
       
        })
        .catch((err) => {
            console.log(err);
        });
}

function selectUser(user) {
    selectedUser.value = user;
    selectedRole.value = user?.roles[0]?.id;
    selectedPermissions.value =
        user?.roles[0]?.permissions.map((permis) => permis.id) || [];
}

function selectRole(roleId) {
    console.log("select role", roleId);

    const role = props.roles.find((r) => r.id === Number(roleId));
    if (!role) {
        return;
    }
    selectedPermissions.value = role.permissions?.map((p) => p.id) ?? [];
}

function openCreateRole() {
    console.log("hello");

    showCreateRole.value = true;
    console.log(showCreateRole.value);
}

function closeCreateRole() {
    showCreateRole.value = false;
}


function showUpdatingRole() {
    showUpdateRole.value = true;
}

function closeRoleUpdate(){
    showUpdateRole.value=false
}


function create_role() {
    axios
        .post(route("create_role"), {
            role_name: newRoleName.value,
            permissions: newRolePermissions.value,
        })
        .then((res) => {
            ((newRoleName.value = ""),
                (newRolePermissions.value = []),
                closeCreateRole());
                roles.value.push(res.data.role)
        })
        .catch((err) => {
            console.log(err.response.data.errors);
        });
}

function edit_role(role){
    showEditRole.value=true
    editRoleName.value=role
    editNewRole.value=role.permissions?.map(r=>r.id) ??[]
}

function update_role_permissions(){
    axios.post(route('update_role_permissions'),{
        role_id:editRoleName.value.id,
        permissions:editNewRole.value
    }).then(res=>{

    }).catch(err=>{
        console.log(err);
        
    })
    
    
}

function delere_role(id){
    axios.post(route('delete_role',id)) .then(res=>{
        console.log(res);
        
        if(res.data.success){
            roles.value=roles.value.filter(role=> role.id !==id)
            
        }
    }).catch(err=>{
        console.log(err);
        
    }) 
}


</script>
<template>
    <div
        v-show="showCreateRole"
        class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm overflow-y-auto"
    >
        <div class="min-h-screen flex items-center justify-center p-6">
            <div
                class="w-full max-w-3xl bg-white rounded-xl shadow-xl overflow-hidden"
            >
                <!-- Header -->
                <div
                    class="px-6 py-5 border-b border-gray-200 flex items-center justify-between"
                >
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Create Role
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Create a role and assign permissions.
                        </p>
                    </div>

                    <button
                        @click="closeCreateRole"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500"
                    >
                        ✕
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <!-- Role Name -->
                    <div class="mb-6">
                        <label
                            class="block mb-2 text-sm font-medium text-gray-700"
                        >
                            Role Name
                        </label>

                        <input
                            v-model="newRoleName"
                            type="text"
                            placeholder="e.g. Manager"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 outline-none"
                        />
                    </div>

                    <!-- Permission Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                Permissions
                            </h3>

                            <p class="text-xs text-gray-500 mt-1">
                                Select permissions for this role.
                            </p>
                        </div>

                        <span
                            class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600"
                        >
                            {{ newRolePermissions.length }} selected
                        </span>
                    </div>

                    <!-- Permission List -->
                    <div class="max-h-80 overflow-y-auto space-y-4 pr-2">
                        <div
                            v-for="(
                                permission_list, group
                            ) in group_permissions"
                            :key="group"
                        >
                            <h4
                                class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500"
                            >
                                {{ group }}
                            </h4>

                            <div
                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 border border-gray-200 rounded-lg overflow-hidden"
                            >
                                <label
                                    v-for="permission in permission_list"
                                    :key="permission.id"
                                    class="flex items-center gap-2 p-3 border-r border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        :value="permission.id"
                                        v-model="newRolePermissions"
                                        class="w-4 h-4 text-gray-900 rounded"
                                    />

                                    <span class="text-sm text-gray-700">
                                        {{
                                            permission.name
                                                .split(".")[1]
                                                .toUpperCase()
                                        }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-3"
                >
                    <button
                        @click="closeCreateRole"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-white"
                    >
                        Cancel
                    </button>

                    <button
                        @click="create_role"
                        class="px-5 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800"
                    >
                        Create Role
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- update roles -->
    <div
        v-show="showUpdateRole"
        class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm overflow-y-auto"
    >
        <div class="min-h-screen flex items-center justify-center p-6">
            <div
                class="w-full max-w-3xl bg-white rounded-xl shadow-xl overflow-hidden"
            >
                <!-- Header -->
                <div
                    class="px-6 py-5 border-b border-gray-200 flex items-center justify-between"
                >
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Manage Roles
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Edit or delete existing roles.
                        </p>
                    </div>

                    <button
                        @click="closeRoleUpdate"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500"
                    >
                        ✕
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        <div
                            v-for="role in roles"
                            :key="role.id"
                            class="flex items-center justify-between px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition"
                        >
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ role.name }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    {{ role.permissions.length }} Permissions
                                </p>
                            </div>

                            <div class="flex items-center gap-1">
                                <!-- Edit -->
                                <button
                                    @click.prevent="edit_role(role)"
                                    class="p-2 rounded-lg hover:bg-blue-50 text-gray-500 hover:text-blue-600"
                                    title="Edit"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 7.5-7.5z"
                                        />
                                    </svg>
                                </button>

                                <!-- Delete -->
                                <button
                                @click.prevent="delere_role(role.id)"
                                    class="p-2 rounded-lg hover:bg-red-50 text-gray-500 hover:text-red-600"
                                    title="Delete"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-7 3h10"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end"
                >
                    <button
                    @click.prevent="closeRoleUpdate"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-white"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Role Modal -->
<div
    v-show="showEditRole"
    class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm overflow-y-auto"
>
    <div class="min-h-screen flex items-center justify-center p-6">
        <div
            class="w-full max-w-3xl bg-white rounded-xl shadow-xl overflow-hidden"
        >
            <!-- Header -->
            <div
                class="px-6 py-5 border-b border-gray-200 flex items-center justify-between"
            >
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Edit Role
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Update role name and permissions.
                    </p>
                </div>

                <button
                    @click="showEditRole=false"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500"
                >
                    ✕
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <!-- Role Name -->
                <div class="mb-6">
                    <label
                        class="block mb-2 text-sm font-medium text-gray-700"
                    >
                        Role Name
                    </label>

                    <input
                        type="text"
                        v-model="editRoleName.name"
                        placeholder="e.g. Manager"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-gray-900 outline-none"
                    />
                </div>

                <!-- Permission Header -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">
                            Permissions
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            Select permissions for this role.
                        </p>
                    </div>

                    <span
                        class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600"
                    >
                        {{ editNewRole?.length }} selected
                    </span>
                </div>

                <!-- Permission List -->
                <div class="max-h-80 overflow-y-auto space-y-4 pr-2">
                    <div
                      v-for="(permissions_list,group) in group_permissions" :key="group"
                    >
                        <h4
                            class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500"
                        >
                        {{ group }}
                        </h4>

                        <div
                            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 border border-gray-200 rounded-lg overflow-hidden"
                        >
                            <label
                               v-for="permission in permissions_list" :key="permission.id"
                                class="flex items-center gap-2 p-3 border-r border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                            >
                                <input
                                    type="checkbox"
                                    :value="permission.id"
                                    v-model="editNewRole"
                                    class="w-4 h-4 text-gray-900 rounded"
                                />

                                <span class="text-sm text-gray-700">
                                    {{ permission.name.split(".")[1].toUpperCase() }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end gap-3"
            >
                <button
                @click="showEditRole =false"
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-white"
                >
                    Cancel
                </button>

                <button
                @click="update_role_permissions"
                    class="px-5 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800"
                >
                    Update Role
                </button>
            </div>
        </div>
    </div>
</div>
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        User Permissions
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Select a user and control exactly what they can access.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Create Role -->
                    <button
                        class="flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-medium border border-gray-200 rounded-lg hover:bg-gray-50 transition"
                        @click="openCreateRole"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                        Create Role
                    </button>
                    <button
                        @click.passive="showUpdatingRole"
                        class="flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-medium border border-gray-200 rounded-lg hover:bg-gray-50 transition"
                    >
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                            />
                        </svg>

                        Update Role
                    </button>
                    <!-- Save Changes -->
                    <button
                        v-show="selectedUser"
                        class="flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition"
                        @click.prevent="update_permission"
                    >
                        Save Changes
                    </button>
                </div>
            </div>

            <!-- Main -->
            <div
                class="grid grid-cols-1 lg:grid-cols-[250px_1fr] bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm"
            >
                <!-- =================================
                     USERS SIDEBAR
                ================================== -->
                <div class="border-r border-gray-200">
                    <!-- User Header -->
                    <div class="px-5 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2
                                    class="text-xs font-semibold tracking-wider text-gray-400 uppercase"
                                >
                                    Users
                                </h2>

                                <p class="text-xs text-gray-400 mt-1">
                                    Select a user
                                </p>
                            </div>

                            <span
                                class="text-xs px-2 py-1 rounded-md bg-gray-100 text-gray-500"
                            >
                                {{ users.length }}
                            </span>
                        </div>

                        <!-- Search -->
                        <div class="relative mt-4">
                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                />
                            </svg>

                            <input
                                type="text"
                                placeholder="Search users..."
                                v-model="search"
                                @keyup.enter="search_user"
                                class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:bg-white focus:border-gray-400"
                            />
                        </div>
                    </div>

                    <!-- User List -->
                    <div class="p-2">
                        <!-- Selected User -->
                        <button
                            class="w-full flex items-center justify-between p-3 rounded-lg bg-gray-100 text-left cursor-pointer"
                            v-for="user in users"
                            :key="user.id"
                            @click="selectUser(user)"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-semibold"
                                >
                                    {{ user.name?.charAt(0).toUpperCase() }}
                                </div>

                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ user.name }}
                                    </p>

                                    <p class="text-xs text-gray-400 truncate">
                                        {{ user.email }}
                                    </p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- =================================
                     PERMISSION CONTENT
                ================================== -->
                <div v-show="selectedUser">
                    <!-- User Header -->
                    <div
                        class="px-6 py-5 border-b border-gray-200 flex items-center justify-between"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold"
                            >
                                {{ selectedUser?.name.charAt(0).toUpperCase() }}
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <h2
                                        class="text-lg font-semibold text-gray-900"
                                    >
                                        {{ selectedUser?.name }}
                                    </h2>

                                    <select
                                        name=""
                                        id=""
                                        v-model="selectedRole"
                                        @change="selectRole(selectedRole)"
                                        class="px-2 py-1.5 rounded-md bg-blue-50 text-blue-600 text-xs font-medium"
                                    >
                                        <option
                                            v-for="role in roles"
                                            :key="role.id"
                                            :value="role.id"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </select>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ selectedUser?.email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Groups -->
                    <div
                        class="p-2"
                        v-for="(permission_list, group) in group_permissions"
                        :key="group"
                    >
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3
                                        class="text-sm font-semibold text-gray-900"
                                    >
                                        {{ group.toUpperCase() }}
                                    </h3>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 rounded-lg divide-y divide-gray-100 grid grid-cols-4"
                            >
                                <label
                                    class="flex items-center justify-between px-4 py-2 hover:bg-gray-50 cursor-pointer"
                                    v-for="permission in permission_list"
                                    :key="permission.id"
                                >
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-700"
                                        >
                                            {{
                                                permission.name
                                                    .split(".")[1]
                                                    .toUpperCase()
                                            }}
                                        </p>

                                        <input
                                            type="checkbox"
                                            :value="permission.id"
                                            v-model="selectedPermissions"
                                            class="w-4 h-4 rounded border-gray-300 text-gray-900"
                                        />
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
