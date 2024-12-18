import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserLogin from '@/views/UserLogin.vue'
import PreorderList from '@/views/PreorderList.vue'
import TrashedPreorderList from '@/views/TrashedPreorderList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'login',
      component: UserLogin,
      meta: { requiresGuest: true },
    },
    {
      path: '/preorders',
      name: 'preorders',
      component: PreorderList,
      meta: { requiresAuth: true },
    }, 
    {
      path: '/preorders/trash',
      name: 'trash.preorders',
      component: TrashedPreorderList,
    },
  ],
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('access_token');
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next({ name: 'login' });
    } else {
      next();
    }
  }
  else if (to.matched.some(record => record.meta.requiresGuest)) {
    if (token) {
      next({ name: 'preorders' });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router
