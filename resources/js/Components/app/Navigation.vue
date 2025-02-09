<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import CreateDropdown from '@/Components/app/CreateDropdown.vue';
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <nav class="min-w-[200px]">
        <div class="h-[50px] flex items-center px-3 gap-3 mb-5">
            <Link href="/">
                <ApplicationLogo
                    class="block h-9 w-auto fill-current text-gray-800"
                />
            </Link>
            Google Drive
        </div>
        <div class="px-3">
            <CreateDropdown />
            <div class="py-3">
            <NavLink href="/" class="block">My Files</NavLink>
            <NavLink href="/" class="block">Shared with me</NavLink>
            <NavLink href="/" class="block">Shared by me</NavLink>
            <NavLink href="/" class="block">Trash</NavLink>
        </div>
        </div>
        
    </nav>
</template>

<style scoped>

</style>