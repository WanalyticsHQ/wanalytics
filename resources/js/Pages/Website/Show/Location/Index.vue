<script setup>
import { ref, onMounted } from "vue";
import Tab from "@/Components/Tab.vue";
import City from "@/Pages/Website/Show/Location/City.vue";
import Country from "@/Pages/Website/Show/Location/Country.vue";
import Region from "@/Pages/Website/Show/Location/Region.vue";

const { dateRange, website } = defineProps({
    dateRange: Object,
    website: Object,
});

const tab = ref("countries");
const tabs = ["countries", "regions", "cities"];

const setTab = (value) => {
    tab.value = value;
};
</script>

<template>
    <div class="col-span-12 lg:col-span-6 card p-4 min-h-[450px]">
        <Tab :tabs="tabs" @update="setTab" />
        <div class="mt-4">
            <Country
                v-if="tab == 'countries'"
                key="countries"
                :dateRange="dateRange"
                :website="website"
            />
            <Region
                v-else-if="tab == 'regions'"
                key="regions"
                :dateRange="dateRange"
                :website="website"
            />
            <City
                v-else-if="tab == 'cities'"
                key="cities"
                :dateRange="dateRange"
                :website="website"
            />
        </div>
    </div>
</template>
