import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../pages/HomePage.vue'),
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../pages/LoginPage.vue'),
  },
  {
    path: '/registro',
    name: 'Register',
    component: () => import('../pages/RegisterPage.vue'),
  },
  {
    path: '/optativas/:id',
    name: 'OptativaDetail',
    component: () => import('../pages/OptativaDetailPage.vue'),
  },
  {
    path: '/perfil',
    name: 'Profile',
    component: () => import('../pages/ProfilePage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin',
    name: 'Admin',
    component: () => import('../pages/AdminPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const user = JSON.parse(localStorage.getItem('user') || 'null')

  if (to.meta.requiresAuth && !token) {
    return next('/login')
  }
  if (to.meta.requiresAdmin && user?.role !== 'admin') {
    return next('/')
  }
  next()
})

export default router
