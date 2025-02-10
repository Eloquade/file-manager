<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>

<template>
    <AuthenticatedLayout>
        <div>
            {{ $page.url }}
        </div>
    </AuthenticatedLayout>
    
</template>



<style scoped>

</style>