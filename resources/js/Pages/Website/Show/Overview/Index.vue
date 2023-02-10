<script setup>
import helper from "@/helper";
import { ref, watch, onMounted } from "vue";
import LineChart from "./LineChart.vue";
import BarChart from "./BarChart.vue";
import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/vue/24/outline";

const currentTab = ref("sessions");
const tabs = ref([
    {
        id: "sessions",
        name: "Sessions",
        value: null,
        change: null,
        helperFunction: helper.kFormatter,
    },
    {
        id: "pageViews",
        name: "Page Views",
        value: null,
        change: null,
        helperFunction: helper.kFormatter,
    },
    {
        id: "bounceRate",
        name: "Bounce Rate",
        value: null,
        change: null,
        helperFunction: (value) => {
            return `${value}%`;
        },
    },
    {
        id: "avgSessionDuration",
        name: "Session Duration",
        value: null,
        change: null,
        helperFunction: helper.secondsToTime,
    },
]);

const setChart = (stat) => {
    currentTab.value = stat;
};

const { dateRange, website } = defineProps({
    dateRange: Object,
    website: Object,
});

const loadData = () => {
    axios
        .get(route("websites.statistics", website.id), {
            params: {
                start: dateRange.start,
                end: dateRange.end,
                metric: "overview",
            },
        })
        .then((response) => {
            tabs.value = tabs.value.map((tab) => {
                return {
                    ...tab,
                    value: response.data[tab.id].value,
                    change: response.data[tab.id].change,
                };
            });
        });
};

onMounted(() => {
    loadData();
});

watch(dateRange, (value) => {
    loadData();
});
</script>
<template>
    <div class="card p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div
                v-for="data in tabs"
                :key="data"
                @click="setChart(data.id)"
                :class="{
                    'border-t-4 border-transparent overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-900 px-4 py-5 sm:p-6 cursor-pointer': true,
                    ' border-green-400': data.id === currentTab,
                }"
            >
                <div
                    class="truncate text-xs tracking-wider font-bold uppercase text-zinc-800 dark:text-zinc-200"
                >
                    {{ data.name }}
                </div>
                <div class="flex items-center space-x-2">
                    <div
                        class="mt-1 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white"
                    >
                        {{ data.helperFunction(data.value) }}
                    </div>

                    <div class="flex items-center space-x-1">
                        <ChevronUpIcon
                            v-if="data.change > 0"
                            class="h-4 w-4 text-green-400 stroke-2"
                        />
                        <ChevronDownIcon
                            v-if="data.change < 0"
                            class="h-4 w-4 text-red-400 stroke-2"
                        />
                        <div
                            v-if="data.change > 0"
                            :class="{
                                'font-medium text-sm': true,
                                'text-green-400': data.change > 0,
                                'text-red-400': data.change < 0,
                            }"
                        >
                            {{ data.helperFunction(data.change) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <LineChart :date-range="dateRange" :website="website" />
    </div>
</template>