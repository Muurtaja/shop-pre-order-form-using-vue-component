# Installation Guide for Laravel Backend and Vue Frontend

This repository contains two folders: `laravel-backend` for the Laravel backend and `vue-frontend` for the Vue.js frontend.

## Laravel Backend Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd laravel-backend
   ```

2. **Copy the `.env.example` file to `.env`:**
   ```bash
   cp .env.example .env
   ```

3. **Set up PostgreSQL database:**
   - Create a PostgreSQL database.
   - Provide your database credentials in the `.env` file:
     ```ini
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_username
     DB_PASSWORD=your_database_password
     ```

4. **Enable or Disable ReCAPTCHA (optional):**
   - Set `ENABLE_RECAPTCHA` to `true` or `false` to enable or disable ReCAPTCHA:
     ```ini
     ENABLE_RECAPTCHA=true
     RECAPTCHA_SECRET_KEY=your_recaptcha_secret_key
     ```

5. **Generate the application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations and seed the database:**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

---

## Vue Frontend Installation

1. **Navigate to the `vue-frontend` folder:**
   ```bash
   cd ../vue-frontend
   ```

2. **Copy the `.env.example` file to `.env`:**
   ```bash
   cp .env.example .env
   ```

3. **Set up the API URL and ReCAPTCHA Site Key:**
   - Provide your Laravel backend API URL:
     ```ini
     VITE_API_URL=base-url/api
     ```
   - Set the ReCAPTCHA site key (if enabled):
     ```ini
     VITE_RECAPTCHA_SITE_KEY=your_recaptcha_site_key
     ```

4. **Install dependencies:**
   ```bash
   npm install
   ```

5. **Run the development server:**
   ```bash
   npm run dev
   ```

---

## Access the Application

- For **preorder**: [http://localhost:5173](http://localhost:5173)
- For **user login**: [http://localhost:5173/login](http://localhost:5173/login)

### User Credentials:

- **Admin Access:**
  - Email: `admin@site.com`
  - Password: `admin`
  
- **Manager Access:**
  - Email: `manager@site.com`
  - Password: `manager`

