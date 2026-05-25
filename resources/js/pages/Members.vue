<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-orange-400">Members</h1>
        <p class="text-gray-300 mt-2">View your member directory and contact information.</p>
      </div>
      <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Add Member</button>
    </div>

    <div class="bg-white/5 p-6 rounded-3xl border border-orange-500/20 shadow-orange-500/5 shadow-sm">
      <table class="w-full text-left border-separate border-spacing-y-3">
        <thead>
          <tr class="text-gray-400 text-sm uppercase tracking-[0.2em]">
            <th class="pb-4">ID</th>
            <th class="pb-4">Name</th>
            <th class="pb-4">Email</th>
            <th class="pb-4">Plan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="m in members" :key="m.id" class="bg-black/40 rounded-3xl">
            <td class="py-4 px-3">{{ m.id }}</td>
            <td class="py-4 px-3">{{ m.user ? m.user.name : '—' }}</td>
            <td class="py-4 px-3">{{ m.user ? m.user.email : '—' }}</td>
            <td class="py-4 px-3">{{ m.membership?.plan || 'Standard' }}</td>
          </tr>
          <tr v-if="members.length === 0">
            <td colspan="4" class="py-6 text-center text-gray-300">No members found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const members = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/members');
    members.value = Array.isArray(res.data) ? res.data : [];
  } catch (error) {
    console.error(error);
  }
});
</script>

<style scoped></style>
