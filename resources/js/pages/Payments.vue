<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-3xl font-bold text-orange-400">Payments</h1>
        <p class="text-gray-300 mt-2">Track membership payments and submit your invoices.</p>
      </div>
    </div>

    <div v-if="currentMembership" class="bg-white/5 p-6 rounded-3xl border border-green-500/20 shadow-sm shadow-green-500/10 mb-6">
      <h2 class="text-xl font-bold text-orange-400 mb-4">Your current membership</h2>
      <p class="text-gray-300 mb-2">Plan: <span class="font-semibold text-white">{{ currentMembership.plan }}</span></p>
      <p class="text-gray-300 mb-2">Status: <span class="font-semibold text-white">{{ currentMembership.status }}</span></p>
      <p class="text-gray-300 mb-4">Expected amount: <span class="font-semibold text-white">{{ formatCurrency(planAmounts[currentMembership.plan] ?? 0) }}</span></p>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-gray-200 mb-2">Amount</label>
          <input type="number" step="0.01" min="0" v-model="form.amount" class="w-full p-3 rounded-lg bg-black/40 border border-white/10 text-white" />
        </div>
        <div>
          <label class="block text-gray-200 mb-2">Reference Number</label>
          <input type="text" v-model="form.reference_number" class="w-full p-3 rounded-lg bg-black/40 border border-white/10 text-white" />
        </div>
      </div>

      <div class="mt-4 flex flex-wrap gap-3 items-center">
        <button @click="submitPayment" :disabled="loading" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded disabled:opacity-60">
          {{ loading ? 'Submitting...' : 'Submit Payment' }}
        </button>
        <span v-if="successMessage" class="text-green-300">{{ successMessage }}</span>
        <span v-if="errorMessage" class="text-red-300">{{ errorMessage }}</span>
      </div>
    </div>

    <div v-if="!currentMembership" class="bg-white/5 p-6 rounded-3xl border border-orange-500/20 shadow-sm shadow-orange-500/10 mb-6">
      <p class="text-gray-300">You don’t have an active membership yet.</p>
      <a href="/membership" class="inline-block mt-4 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Apply for Membership</a>
    </div>

    <div class="bg-white/5 p-6 rounded-3xl border border-green-500/20 shadow-sm shadow-green-500/10">
      <h2 class="text-xl font-bold text-orange-400 mb-4">Payment history</h2>
      <table class="w-full text-left border-separate border-spacing-y-4">
        <thead>
          <tr class="text-gray-400 text-sm uppercase tracking-[0.2em]">
            <th class="pb-4">ID</th>
            <th class="pb-4">Plan</th>
            <th class="pb-4">Amount</th>
            <th class="pb-4">Reference</th>
            <th class="pb-4">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="payment in payments" :key="payment.id" class="bg-black/40 rounded-3xl">
            <td class="py-4 px-3">{{ payment.id }}</td>
            <td class="py-4 px-3">{{ payment.membership?.plan || '—' }}</td>
            <td class="py-4 px-3">{{ formatCurrency(payment.amount) }}</td>
            <td class="py-4 px-3">{{ payment.reference_number || '—' }}</td>
            <td class="py-4 px-3 capitalize">{{ payment.status }}</td>
          </tr>
          <tr v-if="payments.length === 0">
            <td colspan="5" class="py-6 text-center text-gray-300">No payments found yet.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const payments = ref([]);
const currentMembership = ref(null);
const loading = ref(false);
const successMessage = ref('');
const errorMessage = ref('');
const form = ref({ amount: '', reference_number: '' });

const planAmounts = {
  Basic: 500.00,
  Premium: 800.00,
  VIP: 1200.00,
};

const currencyFormatter = new Intl.NumberFormat('en-PH', {
  style: 'currency',
  currency: 'PHP',
  minimumFractionDigits: 2,
});

const formatCurrency = (value) => currencyFormatter.format(Number(value || 0));

const loadMembership = async () => {
  try {
    const res = await axios.get('/api/memberships');
    currentMembership.value = res.data && !Array.isArray(res.data) ? res.data : null;
    if (currentMembership.value) {
      form.value.amount = planAmounts[currentMembership.value.plan] ?? '';
    }
  } catch (error) {
    console.error(error);
  }
};

const loadPayments = async () => {
  try {
    const res = await axios.get('/api/payments');
    payments.value = Array.isArray(res.data) ? res.data : [];
  } catch (error) {
    console.error(error);
  }
};

const submitPayment = async () => {
  errorMessage.value = '';
  successMessage.value = '';

  if (!currentMembership.value) {
    errorMessage.value = 'Please apply for a membership first.';
    return;
  }

  loading.value = true;

  try {
    const res = await axios.post('/api/payments', {
      membership_id: currentMembership.value.id,
      amount: form.value.amount,
      reference_number: form.value.reference_number,
    });

    successMessage.value = res.data.message || 'Payment submitted.';
    await loadPayments();
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Could not submit payment.';
    console.error(error);
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  await loadMembership();
  await loadPayments();
});
</script>

<style scoped></style>
