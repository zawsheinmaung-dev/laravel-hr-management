<script setup>
import Sidebar from '../Components/Sidebar.vue'
import Navbar from '../Components/Navbar.vue'

defineOptions({
    name: 'Layout',
})
</script>

<template>
    <div class="grid min-h-screen grid-cols-10">

        <!-- Sidebar: 2 columns -->
        <div class="col-span-2 bg-slate-900">
            <Sidebar />
        </div>

        <!-- Content: 8 columns -->
        <div class="col-span-8">

            <!-- Navbar -->
            <Navbar />
            <!-- Page Content -->
            <main class="p-3">
                <slot />
            </main>

        </div>

    </div>
</template>