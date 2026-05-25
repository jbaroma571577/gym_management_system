<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-orange-400">Memberships</h1>
        <p class="text-gray-300 mt-2">Review all membership applications and plan statuses.</p>
      </div>
      <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">New Plan</button>
    </div>

    <div class="bg-white/5 p-6 rounded-3xl border border-orange-500/20 shadow-sm shadow-orange-500/10">
      <table class="w-full text-left border-separate border-spacing-y-4">
        <thead>
          <tr class="text-gray-400 text-sm uppercase tracking-[0.2em]">
            <th class="pb-4">ID</th>
            <th class="pb-4">Member</th>
            <th class="pb-4">Plan</th>
            <th class="pb-4">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in memberships" :key="item.id" class="bg-black/40 rounded-3xl">
            <td class="py-4 px-3">{{ item.id }}</td>
            <td class="py-4 px-3">{{ item.member?.user?.name || 'Guest' }}</td>
            <td class="py-4 px-3">{{ item.plan }}</td>
            <td class="py-4 px-3 capitalize">{{ item.status }}</td>
          </tr>
          <tr v-if="memberships.length === 0">
            <td colspan="4" class="py-6 text-center text-gray-300">No memberships available.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const memberships = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/memberships');
    memberships.value = Array.isArray(res.data) ? res.data : (res.data ? [res.data] : []);
  } catch (error) {
    console.error(error);
  }
});
</script>

<style scoped></style>
