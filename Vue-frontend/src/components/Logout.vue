<template>
    <div class="mt-3">
        <small>
            Logged in as: {{ userName }} <button @click="handleLogout" class="btn btn-sm text-primary text-decoration-underline">Logout</button>
        </small>
    </div>
</template>

<script>

export default {
    data() {
        return {
            userName: localStorage.getItem("user_name") || "Guest",
        };
    },
    methods: {
        async handleLogout() {
            try {
                await this.$axios.post("/logout");
            } catch (error) {
                console.error("Logout failed:", error.response ? error.response.data.message : error.message);
            } finally {
                localStorage.removeItem("access_token");
                localStorage.removeItem("user_name");
                localStorage.removeItem("access_type");
                this.$router.push("/login");
            }
        }
    }
};
</script>
