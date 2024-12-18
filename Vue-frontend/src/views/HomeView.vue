<template>
  <main>
    <div class="container mt-5">
      <div class="form-container">
        <h2 class="text-center form-title mb-4">Pre-Order Form</h2>
        <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
          {{ successMessage }}
          <button @click="reloadPage" class="btn btn-primary btn-sm ms-1">
            Submit new
          </button>
        </div>
        <div v-if="errorMessage.length > 0" class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            <li v-for="error in errorMessage" :key="error">{{ error }}</li>
          </ul>
          <button type="button" class="btn-close" @click="errorMessage = ''"></button>
        </div>
        <form v-if="!successMessage" @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" v-model="formData.name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" v-model="formData.email" required>
          </div>
          <div class="mb-3" v-if="requiresPhoneField">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" v-model="formData.phone" required>
          </div>
          <div class="mb-3">
            <label for="product" class="form-label">Select Product</label>
            <select class="form-select" id="product" v-model="formData.product" required>
              <option value="" disabled selected>Select a product</option>
              <option v-for="product in products" :key="product.id" :value="product.id">
                {{ product.name }}
              </option>
            </select>
          </div>
          <div class="mb-3" v-if="recaptchaStatus === true">
            <div class="g-recaptcha" :data-sitekey="recaptchaSiteKey"></div>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary" :disabled="loading">{{ loading ? 'Submitting...' : 'Place Pre-Order' }}</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<style>
body {
  background-color: #f8f9fa;
  font-family: Arial, sans-serif;
}

.form-container {
  max-width: 600px;
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

<script>

export default {
  data() {
    return {
      products: [],
      formData: {
        name: '',
        email: '',
        phone: '',
        product: '',
      },
      loading: false,
      successMessage: '',
      errorMessage: [],
      recaptchaSiteKey: import.meta.env.VITE_RECAPTCHA_SITE_KEY,
      recaptchaStatus: false,
    };
  },
  created() {
    this.getSiteConfigs();
    this.fetchProducts();
  },
  computed: {
    requiresPhoneField() {
      return this.formData.email.endsWith('@xyz.com');
    },
  },
  mounted() {
    // this.loadRecaptchaScript();
  },
  methods: {
    reloadPage() {
      window.location.reload(); // Reloads the entire page
    },
    loadRecaptchaScript() {
      if (typeof grecaptcha === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
      }
    },
    async fetchProducts() {
      try {
        const response = await this.$axios.get('/preorder/products');
        this.products = response.data.products;
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    async getSiteConfigs() {
      try {
        const response = await this.$axios.get('/site-configs');
        this.recaptchaStatus = response.data.recaptchaStatus;

        this.recaptchaStatus === true && this.loadRecaptchaScript();
      } catch (error) {
        console.error('Error fetching site config:', error);
      }
    },
    async handleSubmit() {

      if (this.recaptchaStatus === true) {
        const captchaResponse = grecaptcha.getResponse();
        if (!captchaResponse) {
          alert("Please verify you are not a robot.");
          return;
        }
        this.formData["g-recaptcha-response"] = captchaResponse;
      }
      console.log('Form Data:', this.formData);

      this.loading = true;
      this.successMessage = '';
      this.errorMessage = [];

      try {
        const response = await this.$axios.post(
          '/preorder/store',
          this.formData
        );

        this.successMessage = response.data.message || 'Pre-order submitted successfully!';
        this.formData = {
          name: '',
          email: '',
          phone: '',
          product: '',
        };
      } catch (error) {
        console.log(error.response);

        if (error.response && error.response.status === 422) {
          this.errorMessage = Object.values(error.response.data.errors).flat();
        } else if (error.response && error.response.status === 429) {
          this.errorMessage = [error.response.data.message];
        } else {
          this.errorMessage = ['An unexpected error occurred. Please try again.'];
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
