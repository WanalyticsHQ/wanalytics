<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import Label from "@/Components/Label.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/Input.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    domain: "",
});

const submit = () => {
    form.post(route("websites.store"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="New Website" />

        <div class="flex flex-col sm:justify-center items-center">
            <div class="sm:mx-auto sm:w-full sm:max-w-md mb-4">
                <h1
                    class="mt-6 text-center text-3xl font-bold tracking-tight text-zinc-900 dark:text-white"
                >
                    New Website
                </h1>
            </div>
            <div
                class="w-full sm:max-w-md px-6 py-4 card overflow-hidden sm:rounded-lg"
            >
                <form @submit.prevent="submit">
                    <div>
                        <Label for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            placeholder="My Website"
                            autocomplete="off"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <Label for="domain" value="Domain" />

                        <TextInput
                            id="domain"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="domain.com"
                            v-model="form.domain"
                            required
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.domain"
                        />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('websites.index')"
                            class="text-sm dark:text-gray-300 dark:hover:text-white hover:underline"
                        >
                            Cancel
                        </Link>
                        <PrimaryButton
                            class="ml-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
