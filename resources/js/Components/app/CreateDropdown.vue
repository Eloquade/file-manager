<script setup>
import { ref } from "vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";

const isOpen = ref(false);
</script>

<template>
    <Menu as="div" class="relative inline-block text-left" v-slot="{ open }">
        <MenuButton
            @click="isOpen = !isOpen"
            class="inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
            Create New
            <ChevronDownIcon 
                class="w-5 h-5 ml-2 text-gray-500 transition-transform duration-200 ease-in-out" 
                :class="{ 'rotate-180': open }"
            />
        </MenuButton>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute left-0 mt-2 w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
            >
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <a 
                            href="#" 
                            :class="[
                                active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-3 py-2 text-sm'
                            ]"
                        >
                            New Folder
                        </a>
                    </MenuItem>
                </div>
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <a 
                            href="#" 
                            :class="[
                                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-3 py-2 text-sm'
                            ]"
                        >
                            Upload Files
                        </a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <a 
                            href="#" 
                            :class="[
                                active ? 'bg-blue-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-3 py-2 text-sm'
                            ]"
                        >
                            Upload Folder
                        </a>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>
