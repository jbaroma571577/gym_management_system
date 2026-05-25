<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-orange-400">Attendance</h1>
        <p class="text-gray-300 mt-2">Check in members and monitor attendance status.</p>
      </div>
      <button
        @click="checkIn"
        :disabled="loading"
        class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded disabled:opacity-60"
      >
        <span v-if="!checkedIn">Check In</span>
        <span v-else>Checked In</span>
      </button>
    </div>

    <div class="bg-white/5 p-6 rounded-3xl border border-indigo-500/20 shadow-indigo-500/10 shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <div>
          <p class="text-gray-300">Attendance records and analytics</p>
          <p class="text-sm text-green-300 mt-1" v-if="checkedIn">You are checked in for today.</p>
          <p class="text-sm text-gray-400 mt-1" v-else>No check-in yet today.</p>
        </div>
        <div class="rounded-2xl bg-indigo-500/10 px-4 py-2 text-indigo-200">
          Status: <span class="font-semibold">{{ checkedIn ? 'Checked In' : 'Pending' }}</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
          <p class="text-sm text-gray-400">Last recorded check-in</p>
          <p class="mt-2 text-xl font-semibold">{{ lastCheckIn || 'No data' }}</p>
        </div>
        <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
          <p class="text-sm text-gray-400">Attendance streak</p>
          <p class="mt-2 text-xl font-semibold">{{ streak }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const checkedIn = ref(false);
const loading = ref(false);
const lastCheckIn = ref('—');
const streak = ref('7 days');

const fetchStatus = async () => {
  try {
    const res = await axios.get('/api/today-status');
    checkedIn.value = !!res.data;
    lastCheckIn.value = res.data?.time_in ? res.data.time_in : 'No data';
  } catch (e) {
    console.error(e);
  }
};

const checkIn = async () => {
  loading.value = true;
  try {
    const res = await axios.post('/api/attendance/checkin');
    if (res.status === 200) {
      checkedIn.value = true;
      lastCheckIn.value = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchStatus);
</script>

<style scoped></style>
