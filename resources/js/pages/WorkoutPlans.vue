<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-orange-400">Workout Plans</h1>
        <p class="text-gray-300 mt-2">Manage training programs and assigned regimens.</p>
      </div>
      <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Create Plan</button>
    </div>

    <div class="bg-white/5 p-6 rounded-3xl border border-yellow-500/20 shadow-sm shadow-yellow-500/10">
      <table class="w-full text-left border-separate border-spacing-y-4">
        <thead>
          <tr class="text-gray-400 text-sm uppercase tracking-[0.2em]">
            <th class="pb-4">ID</th>
            <th class="pb-4">Member</th>
            <th class="pb-4">Program</th>
            <th class="pb-4">Assigned</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="plan in plans" :key="plan.id" class="bg-black/40 rounded-3xl">
            <td class="py-4 px-3">{{ plan.id }}</td>
            <td class="py-4 px-3">{{ plan.member?.user?.name || 'Guest' }}</td>
            <td class="py-4 px-3">{{ plan.program_type }}</td>
            <td class="py-4 px-3">{{ plan.created_at ? new Date(plan.created_at).toLocaleDateString() : '—' }}</td>
          </tr>
          <tr v-if="plans.length === 0">
            <td colspan="4" class="py-6 text-center text-gray-300">No workout plans available.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plans = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/workout-plans');
    plans.value = Array.isArray(res.data) ? res.data : (res.data ? [res.data] : []);
  } catch (error) {
    console.error(error);
  }
});
</script>

<style scoped></style>
