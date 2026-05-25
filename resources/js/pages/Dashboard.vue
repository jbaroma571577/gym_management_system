<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-8">
      <div>
        <h1 class="text-4xl font-bold text-orange-400">Premium Dashboard</h1>
        <p class="text-gray-300 mt-2">All member, attendance, and workout metrics in one place.</p>
      </div>
      <div class="rounded-3xl bg-white/5 border border-white/10 p-5 shadow-lg shadow-orange-500/10">
        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Monthly revenue</p>
        <p class="mt-2 text-3xl font-semibold text-green-300">₱24,560</p>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.5fr_1fr] gap-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white/5 p-6 rounded-3xl border border-orange-500/20 shadow-xl shadow-orange-500/5">
          <h3 class="text-orange-300 font-bold mb-4">Active Members</h3>
          <p class="text-4xl font-semibold">{{ activeMembers }}</p>
          <p class="mt-2 text-gray-400">Members currently enrolled in the gym.</p>
        </div>

        <div class="bg-white/5 p-6 rounded-3xl border border-indigo-500/20 shadow-xl shadow-indigo-500/5">
          <h3 class="text-indigo-300 font-bold mb-4">Today’s Check-ins</h3>
          <p class="text-4xl font-semibold">{{ checkinsToday }}</p>
          <p class="mt-2 text-gray-400">Total member check-ins so far today.</p>
        </div>
      </div>

      <div class="bg-white/5 p-6 rounded-3xl border border-green-500/20 shadow-xl shadow-green-500/5">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-green-300 font-bold">Check-ins trend</h3>
            <p class="text-sm text-gray-400">Last 6 months</p>
          </div>
        </div>
        <MiniChart />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MiniChart from '../components/MiniChart.vue';

const activeMembers = ref('—');
const checkinsToday = ref('—');

onMounted(async () => {
  try {
    const members = await axios.get('/api/members');
    activeMembers.value = Array.isArray(members.data) ? members.data.length : '—';

    const attendance = await axios.get('/api/today-status');
    checkinsToday.value = attendance.data ? 1 : 0;
  } catch (error) {
    console.error(error);
  }
});
</script>

<style scoped></style>
