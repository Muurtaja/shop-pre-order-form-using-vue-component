<template>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center form-title mb-4">Login</h2>
            <div class="text-center">Login to your dashboard</div>

            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Email</label>
                    <input type="email" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Password</label>
                    <input type="password" class="form-control" id="email" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</template>

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

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
</style>