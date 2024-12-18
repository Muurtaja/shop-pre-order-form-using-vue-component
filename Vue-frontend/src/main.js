import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axiosInstance from './api/axios'

const app = createApp(App)
app.config.globalProperties.$axios = axiosInstance;


app.use(router)

app.mount('#app')
