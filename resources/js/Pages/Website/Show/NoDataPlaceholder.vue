<script setup>
import SnippetCode from "@/Pages/Website/SnippetCode.vue";

const { website } = defineProps({
    website: Object,
});
</script>
<template>
    <div class="space-y-4">
        <div class="card p-6">
            <div class="flex items-center">
                <div class="flex absolute h-4 w-4">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"
                    ></span
                    ><span
                        class="relative inline-flex rounded-full h-4 w-4 bg-green-500"
                    ></span>
                </div>
                <div
                    class="ml-7 flex items-center space-x-1 text-gray-800 dark:text-white text-sm font-medium"
                >
                    <div>Waiting for first pageview on</div>
                    <div class="font-bold">{{ website.domain }}</div>
                </div>
            </div>
        </div>

        <SnippetCode :website="website" />
    </div>
</template>
