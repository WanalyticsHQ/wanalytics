<script setup>
import NoDataPlaceholder from "../NoDataPlaceholder.vue";

import Header from "./Header.vue";

import Source from "../Source/Index.vue";
import Page from "../Page/Index.vue";
import Overview from "../Overview/Index.vue";
import Device from "../Device/Index.vue";
import Location from "../Location/Index.vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { onMounted, ref, computed, reactive } from "vue";

const range = reactive({
    data: null,
});

const user = computed(() => usePage().props.auth.user);
const websites = user.value ? user.value.websites : [];

const { website } = defineProps({
    website: Object,
});

const setRange = (data) => {
    range.data = data;
};
</script>

<template>
    <Head :title="website.name" />

    <AuthenticatedLayout>
        <div v-if="website.sessions_count >= 1">
            <Header :website="website" @update="setRange" />

            <div class="space-y-4" v-if="range.data">
                <Overview :dateRange="range.data" :website="website" />

                <div class="grid grid-cols-12 gap-4">
                    <Source :dateRange="range.data" :website="website" />
                    <Page :dateRange="range.data" :website="website" />
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <Location :dateRange="range.data" :website="website" />
                    <Device :dateRange="range.data" :website="website" />
                </div>
            </div>
        </div>
        <div v-else>
            <NoDataPlaceholder :website="website" />
        </div>
    </AuthenticatedLayout>
</template>
