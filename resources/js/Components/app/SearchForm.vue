<script setup>
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const query = ref("");

let debounceTimer = null;

const debouncedSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        emit("search", query.value);
    }, 300); // Adjust debounce delay as needed
};

const form = useForm({
    search: "",
});
</script>

<template>
    <form class="w-[600px] h-[80px] flex items-center">
        <TextInput
            type="text"
            class="block w-full mr-2"
            v-model="form.search"
            autocomplete
            placeholder="Search"
        />
    </form>
</template>

<style scoped></style>
