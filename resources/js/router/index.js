import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../pages/Dashboard.vue';
import Memberships from '../pages/Memberships.vue';
import Payments from '../pages/Payments.vue';
import Attendance from '../pages/Attendance.vue';
import WorkoutPlans from '../pages/WorkoutPlans.vue';

const routes = [
  { path: '/', name: 'dashboard', component: Dashboard },
  { path: '/memberships', name: 'memberships', component: Memberships },
  { path: '/payments', name: 'payments', component: Payments },
  { path: '/attendance', name: 'attendance', component: Attendance },
  { path: '/workout-plans', name: 'workout-plans', component: WorkoutPlans },
  { path: '/:catchAll(.*)*', redirect: { name: 'dashboard' } },
];

const router = createRouter({
  history: createWebHistory('/dashboard'),
  routes,
});

export default router;
