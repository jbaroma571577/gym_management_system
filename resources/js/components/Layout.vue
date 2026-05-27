<template>
  <div class="flex">
    <aside class="w-64 bg-black/60 border-r border-orange-500/20 min-h-screen p-6">
      <div class="mb-8">
        <h2 class="text-orange-400 text-xl font-bold">Gym Management</h2>
        <p class="text-gray-400 text-sm">Member Portal</p>
      </div>
      <nav class="space-y-2">
        <router-link :to="{ name: 'dashboard' }" class="block px-3 py-2 rounded hover:bg-white/5">Dashboard</router-link>
        <!-- Members list is admin-only; removed from member dashboard -->
        <a href="/membership" class="block px-3 py-2 rounded hover:bg-white/5">Apply Membership</a>
        <router-link :to="{ name: 'memberships' }" class="block px-3 py-2 rounded hover:bg-white/5">Memberships</router-link>
        <router-link :to="{ name: 'payments' }" class="block px-3 py-2 rounded hover:bg-white/5">Payments</router-link>
        <router-link :to="{ name: 'attendance' }" class="block px-3 py-2 rounded hover:bg-white/5">Attendance</router-link>
        <router-link :to="{ name: 'workout-plans' }" class="block px-3 py-2 rounded hover:bg-white/5">Workout Plans</router-link>
        <button @click="logout" class="w-full text-left px-3 py-2 rounded hover:bg-white/5 text-red-400">Logout</button>
      </nav>
    </aside>
    <main class="flex-1 p-8">
      <slot />
    </main>
  </div>
</template>

<script setup>
import axios from 'axios';

const logout = async () => {
  try {
    await axios.post('/logout');
    window.location.href = '/';
  } catch (error) {
    console.error('Logout failed', error);
  }
};
</script>

<style scoped></style>
