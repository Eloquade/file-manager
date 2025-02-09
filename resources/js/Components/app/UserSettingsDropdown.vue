<template>
    <div class="user-settings-dropdown">
        <button @click="toggleDropdown" class="dropdown-toggle">
            User Settings
        </button>
        <div v-if="isOpen" class="dropdown-menu">
            <a href="#" @click="handleProfile">Profile</a>
            <a href="#" @click="handleSettings">Settings</a>
            <a href="#" @click="handleLogout">Logout</a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        handleProfile() {
            // Handle profile click
            console.log('Profile clicked');
        },
        handleSettings() {
            // Handle settings click
            console.log('Settings clicked');
        },
        handleLogout() {
            // Handle logout click
            console.log('Logout clicked');
        },
    },
};
</script>

<style scoped>
.user-settings-dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    background-color: #3498db;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

.dropdown-menu {
    display: block;
    position: absolute;
    background-color: white;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-menu a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-menu a:hover {
    background-color: #f1f1f1;
}
</style>
