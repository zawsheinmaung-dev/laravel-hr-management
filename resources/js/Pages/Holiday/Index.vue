<script setup>
import { route } from "ziggy-js";
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";
defineOptions({
    name:"HolidayIndex",
    layout:Layout
})
</script>
<template>
    <Link :href="route('holidays.create')">Create Holiday</Link>
</template>