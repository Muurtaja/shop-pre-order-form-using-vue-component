<template>
    <div class="table-container">
        <h2 class="table-title">Preorder List</h2>
        <div class="table-actions">
            <div>
                <RouterLink to="/preorders" class="btn btn-primary btn-sm">Home</RouterLink>
                <RouterLink to="/preorders/trash" class="btn btn-secondary btn-sm ms-1">Trash</RouterLink>
            </div>
            <div class="search-field">
                <input type="text" class="form-control form-control-sm" placeholder="Search...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Preorder ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>PO12345</td>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>PO12346</td>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <small>Logged in as: Admin <a href="#">Logout</a></small>
        </div>
    </div>
</template>

<style>
body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
    padding: 20px;
}

.table-container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.table-title {
    font-weight: bold;
    color: #343a40;
    text-align: center;
    margin-bottom: 20px;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #bb2d3b;
    border-color: #bb2d3b;
}

.table-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.search-field {
    max-width: 300px;
}

.table-responsive {
    overflow-x: auto;
}
</style>