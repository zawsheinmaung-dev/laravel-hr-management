
<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { menuGroups, roleMenuAccess } from '../Layouts/sidebarMenu.js';

const openGroups=ref({});

const page = usePage();
const currentRoute = computed(() => route().current());
function toggle(groupTitle)
{
  openGroups.value[groupTitle]=!openGroups.value[groupTitle];
}

</script>

<template>
  <nav class="w-64 bg-gray-800 text-gray-100 h-screen overflow-y-auto">
    <div v-for="group in menuGroups" :key="group.title" class="py-2">
      <!-- header -->
      <button
        v-if="group.collapsible"
        @click="toggle(group.title)"
        class="w-full px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400 hover:bg-gray-700 flex justify-between"
      >
        {{ group.title }}
        <span>{{ openGroups[group.title] ? '−' : '+' }}</span>
      </button>
      <div v-else class="px-4 py-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
        {{ group.title }}
      </div>

      <!-- items -->
      <div v-if="!group.collapsible || openGroups[group.title]" class="mt-1">
        <Link
          v-for="item in group.items"
          :key="item.name"
          :href="route(item.route)"
          class="flex items-center px-4 py-2 text-sm hover:bg-gray-700"
          :class="{ 'bg-gray-700': currentRoute === item.route }"
        >
          <span class="mr-3">{{ item.icon }}</span>
          {{ item.name }}
        </Link>
      </div>
    </div>
  </nav>
</template>