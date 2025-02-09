<template>
    <div class="search-form">
        <input
            type="text"
            v-model="query"
            @input="debouncedSearch"
            placeholder="Search..."
            aria-label="Search"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue';

const query = ref('');

let debounceTimer = null;

const debouncedSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        emit('search', query.value);
    }, 300); // Adjust debounce delay as needed
};
</script>

<style scoped>
.search-form {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-form input {
    width: 100%;
    max-width: 400px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.2s;
}

.search-form input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style>
