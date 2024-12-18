<template>
    <div>
        <RouterLink to="/preorders" :class="['btn', 'btn-sm', isActive('/preorders') ? 'btn-primary' : 'btn-secondary']">Home</RouterLink>
        <RouterLink to="/preorders/trash" :class="['btn', 'btn-sm', 'ms-1', isActive('/preorders/trash') ? 'btn-primary' : 'btn-secondary']">Trash</RouterLink>
    </div>
</template>

<script>

export default {
    methods: {
        isActive(path) {
            return this.$route.path === path;
        },
    }
};
</script>
