<script setup>
import { onMounted, ref } from "vue";
import { route } from "ziggy-js";
import axios from "axios";

const props = defineProps({
    modelValue: { type: [String, Number], default: "" },
    initialName: { type: String, default: "" },
    label: { type: String, default: "Manager" },
    placeholder: { type: String, default: "Search Manager" },
});

const show_manager = ref(false);
const manager = ref([]);

const emit = defineEmits(["update:modelValue", "select"]);

let clear_interval;

const manager_name = ref(props.initialName);

function manager_search() {
    clearTimeout(clear_interval);
    if (!manager_name.value.trim()) {
        ((manager.value = []),
            (manager_name.value = ""),
            emit("update:modelValue"),
            (show_manager.value = false));
        return;
    }

    clear_interval = setTimeout(() => {
        axios
            .get(route("search.manager"), {
                params: { search: manager_name.value },
            })
            .then((res) => {
                manager.value = res.data.employees;
                show_manager.value = true;
                console.log(res.data);
                
            });
    }, 1000);
}

function select_manager(mgn) {
    manager_name.value = `${mgn.first_name} ${mgn.last_name}`;
    emit("update:modelValue", mgn.id);
    emit("select", mgn);
    show_manager.value = false;
}
</script>

<template>
    <div class="relative">
        <label class="mb-3 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>

        <div class="relative">
            <input
                type="text"
                v-model="manager_name"
                @input="manager_search"
                :placeholder="placeholder"
                autocomplete="off"
                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 pr-9 text-sm text-gray-700 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            />

            <!-- Search Icon -->
            <svg
                class="absolute right-3 top-2.5 h-5 w-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                />
            </svg>
        </div>

        <!-- Manager Dropdown -->
        <div
            v-if="show_manager && manager && manager.length"
            class="absolute left-0 right-0 top-full z-50 mt-1 max-h-60 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg"
        >
            <div
                v-for="mgn in manager"
                :key="mgn.id"
                @click="select_manager(mgn)"
                class="cursor-pointer border-b border-gray-100 px-3 py-2.5 transition last:border-0 hover:bg-blue-50"
            >
                <div class="font-medium text-gray-800">
                    {{ mgn.first_name }}
                    {{ mgn.last_name }}
                </div>

                <div
                    v-if="mgn.user?.email"
                    class="mt-0.5 text-xs text-gray-500"
                >
                    {{ mgn.user.email }}
                </div>
            </div>
        </div>

        <!-- No Result -->
        <div
            v-if="show_manager && manager && manager.length === 0"
            class="absolute left-0 right-0 top-full z-50 mt-1 rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm text-gray-500 shadow-lg"
        >
            No manager found
        </div>
    </div>
</template>
