<script setup>
import Logout from '@/components/Logout.vue';
import Preordernav from '@/components/Preordernav.vue';
</script>

<template>
  <main>
    <div class="table-container">
      <h2 class="table-title">Preorder List</h2>
      <div class="table-actions flex-wrap gap-2">
        <Preordernav />
        <div class="d-flex gap-2 flex-wrap" v-if="adminOnly">
          <div>
            <select class="form-select" @change="fetchPreorders" v-model="orderBy" aria-label="Default select example">
              <option value="1">Latest</option>
              <option value="2">Oldest</option>
              <option value="3">Name ascending</option>
              <option value="4">Name descending</option>
            </select>
          </div>
          <div class="search-field">
            <div class="input-group">
              <input type="text" v-model="searchQuery" class="form-control form-control-sm" placeholder="Search..." />
              <button class="input-group-text btn btn-primary" @click="fetchPreorders">Search</button>
            </div>
          </div>
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
              <th scope="col">Phone</th>
              <th scope="col">Product ID</th>
              <th scope="col">Deleted By</th>
              <th v-if="adminOnly" scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(preorder, index) in preorders.data" :key="preorder.id">
              <td>{{ (preorders.current_page - 1) * preorders.per_page + index + 1 }}</td>
              <td>{{ preorder.id }}</td>
              <td>{{ preorder.name }}</td>
              <td>{{ preorder.email }}</td>
              <td>{{ preorder.phone || 'N/A' }}</td>
              <td>{{ preorder.product.name }}</td>
              <td>{{ preorder.deleted_by?.name }}</td>
              <td v-if="adminOnly">
                <button class="btn btn-success btn-sm" @click="restorePreorder(preorder.id)">Restore</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="pagination" v-if="hasLinks">
        <button v-for="(link, index) in preorders.links" :key="index" :disabled="!link.url" :class="{ 'btn-primary': link.active, 'btn-outline-primary': !link.active }" @click="fetchPreorders(getPageFromLink(link))" class="btn btn-sm mx-1">
          <span v-html="link.label"></span>
        </button>
      </div>

      <Logout />

    </div>
  </main>
</template>
<script>


export default {
  data() {
    return {
      preorders: {
        data: [],
        current_page: 1,
        per_page: 10,
        links: [],
      },
      searchQuery: "",
      orderBy: 1,
      adminOnly: localStorage.getItem('access_type') === 'admin',
    };
  },
  computed: {
    hasLinks() {
      return Array.isArray(this.preorders.links) && this.preorders.links.length > 0;
    },
  },
  methods: {
    async fetchPreorders(page = 1) {
      const params = {
        page,
        search: this.searchQuery,
        orderBy: this.orderBy,
        per_page: 10,
      };
      const response = await this.$axios.get("/preorders/trashed", { params });
      this.preorders = response.data;
      console.log(this.preorders);

    }, getPageFromLink(link) {
      if (link && link.url) {
        const urlParams = new URL(link.url).searchParams;
        return Number(urlParams.get("page"));
      }
      return null;
    },
    async restorePreorder(id) {
      if (confirm("Are you sure you want to restore this preorder?")) {
        await this.$axios.post(`/preorders/trashed/${id}/restore`);
        this.fetchPreorders(this.preorders.current_page);
      }
    },
  },
  mounted() {
    this.fetchPreorders();
  },
};
</script>

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

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination .btn {
  min-width: 40px;
}
</style>
