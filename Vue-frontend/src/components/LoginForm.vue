<template>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center form-title mb-4">Login</h2>
            <div class="text-center">Login to your dashboard</div>

            <form @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" v-model="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" v-model="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <div v-if="errorMessage" class="text-danger mb-3">
                    {{ errorMessage }}
                </div>

                <ul v-if="validationErrors.length" class="text-danger mb-3">
                    <li v-for="(error, index) in validationErrors" :key="index">{{ error }}</li>
                </ul>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" :disabled="isLoading">
                        <span v-if="isLoading">Logging in...</span>
                        <span v-else>Login</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

export default {
    name: "LoginForm",
    data() {
        return {
            email: "", 
            password: "", 
            errorMessage: "", 
            validationErrors: [], 
            isLoading: false, 
        };
    },
    methods: {
        async handleLogin() {
            this.errorMessage = ""; //
            this.validationErrors = []; 
            this.isLoading = true; 

            try {
                
                const response = await this.$axios.post("/login", {
                    email: this.email,
                    password: this.password,
                });

                //
                if (response.data.success) {
                    console.log(response.data);

                    localStorage.setItem("access_token", response.data.access_token); 
                    localStorage.setItem("access_type", response.data.user.type); 
                    localStorage.setItem("user_name", response.data.user.name); 
                    this.$router.push("/preorders"); 
                } else {
                    this.errorMessage = "Invalid credentials. Please try again.";
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    
                    const errors = error.response.data.errors;
                    this.validationErrors = Object.values(errors).flat();
                } else if (error.response && error.response.status === 401) {
                    this.errorMessage = "Invalid credentials. Please try again.";
                } else if (error.response && error.response.data.message) {
                    
                    this.errorMessage = error.response.data.message;
                } else {
                    
                    this.errorMessage = "An unexpected error occurred. Please try again.";
                }
            } finally {
                this.isLoading = false; 
            }
        },
    },
};
</script>

<style>
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}

.form-container {
    max-width: 500px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.form-title {
    font-weight: bold;
    color: #343a40;
}

.form-label {
    font-weight: 500;
    color: #495057;
}


ul {
    padding-left: 1rem;
}
</style>
