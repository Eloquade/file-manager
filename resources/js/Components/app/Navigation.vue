<script setup>
// uses (imports)
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import CreateDropdown from '@/Components/app/CreateDropdown.vue';
import NavLink from '@/Components/NavLink.vue';

// refs
// (none in this file, but if you had refs, put them here)

// props & emits
// (none in this file, but if you had defineProps/defineEmits, put them here)

// computed
// (none in this file, but if you had computed properties, put them here)

// methods
// (none in this file, but if you had methods, put them here)
</script>

<template>
    <nav class="min-w-[200px]">
        <div class="h-[50px] flex items-center px-3 gap-3 mb-5 mt-7">
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
            <NavLink :href="route('myFiles')" :active="$page.url == '/my-files'" class="block">My Files</NavLink>
            <NavLink href="/" class="block">Shared with me</NavLink>
            <NavLink href="/" class="block">Shared by me</NavLink>
            <NavLink href="/" class="block">Trash</NavLink>
        </div>
        </div>
        
    </nav>
</template>

<style scoped>

</style>