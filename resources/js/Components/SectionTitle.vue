<template>
    <div class="md:col-span-1 flex justify-between">
        <div class="">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                <slot name="title" />
            </h3>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                <slot name="description" />
            </p>
        </div>

        <div class="">
            <slot name="aside" />
        </div>
    </div>
</template>
