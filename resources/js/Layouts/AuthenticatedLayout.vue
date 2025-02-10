<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Navigation from '@/Components/app/Navigation.vue';
import SearchForm from '@/Components/app/SearchForm.vue';
import UserSettingsDropdown from '@/Components/app/UserSettingsDropdown.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex w-full gap-4 bg-gray-50">
        <Navigation />
        
        <main class="flex flex-col flex-1 px-4 overflow-hidden">
            <!-- Header Section -->
            <div class="flex items-center justify-between w-full py-4 border-b">
                <div class="flex-1 max-w-xl">
                    <SearchForm />
                </div>
                <div class="flex items-center gap-4 ml-4">
                    <UserSettingsDropdown />
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col overflow-auto py-6 px-4">
                <div class="rounded-lg bg-white p-6 shadow-md min-h-[520px]">
                    <slot />
                </div>
            </div>
        </main>
    </div>
</template>

<style>
/* Add smooth transitions for dropdowns */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>