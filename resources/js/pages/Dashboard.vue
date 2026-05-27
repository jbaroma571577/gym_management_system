<template>
  <div>
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-8">
      <div>
        <h1 class="text-4xl font-bold text-orange-400">Gym Management</h1>
        <p class="text-gray-300 mt-2">Member portal dashboard</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full sm:w-auto">
        <div :class="membershipCardClass">
          <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Membership</p>
          <p :class="['mt-3 text-3xl font-semibold', membershipTextClass]">{{ membershipPlan }}</p>
          <span :class="['inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold', membershipBadgeClass]">{{ membershipPlan }}</span>
          <p class="mt-2 text-gray-400">{{ membershipStatus }}</p>
          <p class="mt-3 text-sm text-gray-400">{{ membershipBenefitText }}</p>
        </div>

        <div class="bg-white/5 border border-indigo-500/20 p-5 rounded-3xl shadow-sm shadow-indigo-500/10">
          <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Payments</p>
          <p class="mt-3 text-3xl font-semibold text-indigo-300">{{ paymentAmount }}</p>
          <p class="mt-2 text-gray-400">{{ paymentStatus }}</p>
        </div>

        <div class="bg-white/5 border border-green-500/20 p-5 rounded-3xl shadow-sm shadow-green-500/10">
          <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Today’s check-ins</p>
          <p class="mt-3 text-3xl font-semibold text-green-300">{{ checkinsToday }}</p>
          <p class="mt-2 text-gray-400">Check-ins today</p>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.5fr_1fr] gap-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white/5 p-6 rounded-3xl border border-orange-500/20 shadow-xl shadow-orange-500/5">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h2 class="text-xl font-bold text-white">Activity</h2>
              <p class="text-gray-400">Attendance performance over time</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 text-xs uppercase">Weekly</span>
          </div>
          <MiniChart />
        </div>

        <div class="bg-white/5 p-6 rounded-3xl border border-slate-500/20 shadow-xl shadow-slate-500/5">
          <h2 class="text-xl font-bold text-white mb-4">Quick actions</h2>
          <div class="grid gap-3">
            <a href="/membership" class="block bg-slate-900/70 border border-slate-700 rounded-3xl p-4 hover:bg-slate-800 transition">
              <p class="text-sm text-gray-400">Apply for membership</p>
              <p class="mt-2 font-semibold text-white">Membership page</p>
            </a>
            <a href="/attendance" class="block bg-slate-900/70 border border-slate-700 rounded-3xl p-4 hover:bg-slate-800 transition">
              <p class="text-sm text-gray-400">Record your gym attendance</p>
              <p class="mt-2 font-semibold text-white">Attendance page</p>
            </a>
            <a :href="canBookTrainers ? '/trainer-booking' : '/membership'" :class="['block rounded-3xl p-4 transition', canBookTrainers ? 'bg-slate-900/70 border border-slate-700 hover:bg-slate-800' : 'bg-slate-800/50 border border-red-500/20 opacity-70 cursor-not-allowed']">
              <p class="text-sm text-gray-400">Book a trainer session</p>
              <p class="mt-2 font-semibold text-white">Trainer booking</p>
            </a>
            <a :href="canAccessGroupClasses ? '/classes' : '/membership'" :class="['block rounded-3xl p-4 transition', canAccessGroupClasses ? 'bg-slate-900/70 border border-slate-700 hover:bg-slate-800' : 'bg-slate-800/50 border border-red-500/20 opacity-70 cursor-not-allowed']">
              <p class="text-sm text-gray-400">Join instructor-led sessions</p>
              <p class="mt-2 font-semibold text-white">Group classes</p>
            </a>
            <a href="/payments" class="block bg-slate-900/70 border border-slate-700 rounded-3xl p-4 hover:bg-slate-800 transition">
              <p class="text-sm text-gray-400">Manage your invoices</p>
              <p class="mt-2 font-semibold text-white">Payments page</p>
            </a>
            <button @click="refreshMembership" class="block text-left bg-emerald-600/10 border border-emerald-500/20 rounded-3xl p-4 text-white hover:bg-emerald-600/20 transition">
              <p class="text-sm text-gray-300">Refresh membership status</p>
              <p class="mt-2 font-semibold text-white">Sync approved plan</p>
            </button>
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-white/5 p-6 rounded-3xl border border-blue-500/20 shadow-xl shadow-blue-500/5">
          <h2 class="text-xl font-bold text-white">Performance</h2>
          <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Active members</p>
              <p class="mt-2 text-3xl font-semibold text-orange-300">{{ activeMembers }}</p>
            </div>
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Workouts assigned</p>
              <p class="mt-2 text-3xl font-semibold text-teal-300">{{ workoutPlans.length }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white/5 p-6 rounded-3xl border border-violet-500/20 shadow-xl shadow-violet-500/5">
          <h2 class="text-xl font-bold text-white">Membership summary</h2>
          <div class="mt-4 space-y-3">
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Enrollment date</p>
              <p class="mt-2 text-white">{{ membershipDate }}</p>
            </div>
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Expires</p>
              <p class="mt-2 text-white">{{ membershipExpiresText }}</p>
            </div>
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Plan status</p>
              <p class="mt-2 text-white">{{ membershipStatus }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white/5 p-6 rounded-3xl border border-purple-500/20 shadow-xl shadow-purple-500/5">
          <h2 class="text-xl font-bold text-white">Assigned Trainer</h2>
          <div class="mt-4 space-y-3">
            <div class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Your Trainer</p>
              <p v-if="assignedTrainer" class="mt-2 text-white font-semibold">{{ assignedTrainer.name }}</p>
              <p v-else class="mt-2 text-gray-400">No trainer assigned yet</p>
            </div>
            <div v-if="assignedTrainer" class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Status</p>
              <p :class="['mt-2 font-semibold', assignedTrainer.is_available ? 'text-green-300' : 'text-red-300']">
                {{ assignedTrainer.is_available ? 'Available' : 'Not Available' }}
              </p>
            </div>
            <div v-if="assignedTrainer" class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-sm text-gray-400">Email</p>
              <p class="mt-2 text-white break-all">{{ assignedTrainer.email }}</p>
            </div>
            <a v-if="canBookTrainers" href="/trainer-booking" class="block rounded-3xl bg-purple-600/20 border border-purple-500/30 p-4 text-white hover:bg-purple-600/30 transition">
              <p class="text-sm text-gray-300">Book a session with your trainer</p>
              <p class="mt-2 font-semibold text-purple-300">Trainer booking</p>
            </a>
          </div>
        </div>

        <div class="bg-white/5 p-6 rounded-3xl border border-cyan-500/20 shadow-xl shadow-cyan-500/5">
          <h2 class="text-xl font-bold text-white">Workout Plans</h2>
          <p class="text-gray-400 mt-2">Assigned workout programs appear here once your membership is active.</p>
          <div class="mt-4 space-y-4">
            <div v-if="!hasActiveMembership" class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-gray-300" v-if="membershipStatus === 'No membership'">
                No membership found. Apply for membership to get a personalized workout plan.
              </p>
              <p class="text-gray-300" v-else>
                Your membership is currently <strong class="text-white">{{ membershipStatus }}</strong>. Workout programs are assigned once the admin activates your membership.
              </p>
            </div>
            <div v-else-if="workoutPlans.length === 0" class="rounded-3xl bg-slate-900/70 p-4">
              <p class="text-gray-300">No workout plan has been assigned yet. Once your membership is approved, the admin will assign your workout program.</p>
            </div>
            <div v-else v-for="plan in workoutPlans" :key="plan.id" class="rounded-3xl bg-slate-900/70 p-4 border border-cyan-500/10">
              <p class="text-sm text-gray-400">Plan ID {{ plan.id }}</p>
              <p class="text-lg font-semibold text-white mt-2">{{ plan.program_type || 'Workout Plan' }}</p>
              <p class="text-sm text-gray-400 mt-1">Assigned: {{ plan.created_at ? new Date(plan.created_at).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : 'Unknown' }}</p>
              <p class="text-gray-300 mt-2">{{ plan.description || getPlanDescription(plan.program_type) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import MiniChart from '../components/MiniChart.vue';

const activeMembers = ref('—');
const checkinsToday = ref('—');
const workoutPlans = ref([]);
const rawMembership = ref(null);
const membershipPlan = ref('No plan');
const membershipStatus = ref('No membership');
const membershipDate = ref('-');
const membershipExpires = ref('-');
const membershipFeature = ref('');
const paymentAmount = ref('₱0.00');
const paymentStatus = ref('No payment records');
const assignedTrainer = ref(null);

const planStyles = {
  Basic: { border: 'border-slate-500/20', text: 'text-slate-200', badge: 'bg-slate-600/15 text-slate-200' },
  Premium: { border: 'border-sky-500/20', text: 'text-sky-300', badge: 'bg-sky-500/15 text-sky-300' },
  VIP: { border: 'border-yellow-400/20', text: 'text-yellow-300', badge: 'bg-yellow-400/15 text-yellow-500' },
};

const hasActiveMembership = computed(() => rawMembership.value?.status === 'active' && rawMembership.value?.expires_at && new Date(rawMembership.value.expires_at) > new Date());

const membershipCardClass = computed(() => {
  const style = planStyles[rawMembership.value?.plan] || planStyles.Basic;
  return ['bg-white/5', style.border, 'p-5', 'rounded-3xl', 'shadow-sm', rawMembership.value?.plan === 'VIP' ? 'shadow-yellow-400/10' : 'shadow-slate-500/10'];
});

const membershipTextClass = computed(() => planStyles[rawMembership.value?.plan]?.text ?? 'text-slate-200');
const membershipBadgeClass = computed(() => planStyles[rawMembership.value?.plan]?.badge ?? planStyles.Basic.badge);

const canBookTrainers = computed(() => hasActiveMembership.value && ['Premium', 'VIP'].includes(rawMembership.value?.plan));
const canAccessGroupClasses = computed(() => hasActiveMembership.value && ['Premium', 'VIP'].includes(rawMembership.value?.plan));

const membershipExpiresText = computed(() => {
  if (!rawMembership.value?.expires_at) {
    return '-';
  }
  return new Date(rawMembership.value.expires_at).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' });
});

const planBenefits = {
  Basic: 'Access to gym equipment only, 1 check-in per day, and basic workout plans.',
  Premium: 'Unlimited attendance, group classes, trainer booking 2x/month, and premium perks.',
  VIP: 'Unlimited access, personalized plans, VIP lounge, and full premium dashboard.',
};

const membershipBenefitText = computed(() => rawMembership.value?.plan ? planBenefits[rawMembership.value.plan] ?? '' : 'No active membership plan yet.');

const isPendingMembership = computed(() => rawMembership.value && rawMembership.value.status !== 'active');

const formatCurrency = (value) => new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2 }).format(Number(value || 0));

const refreshMembership = async () => {
  try {
    const membershipRes = await axios.get('/api/memberships');
    const membership = membershipRes.data || null;
    rawMembership.value = membership;
    if (membership) {
      membershipPlan.value = membership.plan || 'No plan';
      membershipStatus.value = membership.status ? membership.status.charAt(0).toUpperCase() + membership.status.slice(1) : 'No membership';
      if (membership.status === 'active' && membership.expires_at && new Date(membership.expires_at) <= new Date()) {
        membershipStatus.value = 'Expired';
      }
      membershipDate.value = membership.created_at ? new Date(membership.created_at).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
    }
  } catch (error) {
    console.error('Membership refresh failed', error);
  }
};

const planDescriptions = {
  Strength: 'Build strength through resistance and weight training exercises.',
  Cardio: 'Improve endurance with heart-pumping cardio workouts.',
  Flexibility: 'Increase mobility and reduce injury risk with stretching routines.',
  Hypertrophy: 'Grow muscle size using moderate loads and targeted volume.',
  'Weight Loss': 'Burn calories and tone your body through fat-burning workouts.',
  Endurance: 'Sustain longer workouts with paced conditioning sessions.',
  Recovery: 'Focus on active rest, mobility, and gentle recovery training.',
};

const getPlanDescription = (type) => {
  if (!type) {
    return 'A custom workout plan assigned by your gym admin.';
  }
  return planDescriptions[type] || 'A custom workout plan assigned by your gym admin.';
};

const loadDashboard = async () => {
  try {
    const [membersRes, attendanceRes, membershipRes, paymentsRes, workoutsRes] = await Promise.all([
      axios.get('/api/members'),
      axios.get('/api/today-status'),
      axios.get('/api/memberships'),
      axios.get('/api/payments'),
      axios.get('/api/workout-plans'),
    ]);

    activeMembers.value = Array.isArray(membersRes.data) ? membersRes.data.length : '—';
    checkinsToday.value = attendanceRes.data ? 1 : 0;
    workoutPlans.value = Array.isArray(workoutsRes.data) ? workoutsRes.data : [];

    // Get assigned trainer from member data
    if (Array.isArray(membersRes.data) && membersRes.data.length > 0) {
      const member = membersRes.data[0];
      assignedTrainer.value = member.trainer || null;
    }

    const membership = membershipRes.data || null;
    rawMembership.value = membership;
    if (membership) {
      membershipPlan.value = membership.plan || 'No plan';
      membershipStatus.value = membership.status ? membership.status.charAt(0).toUpperCase() + membership.status.slice(1) : 'No membership';
      if (membership.status === 'active' && membership.expires_at && new Date(membership.expires_at) <= new Date()) {
        membershipStatus.value = 'Expired';
      }
      membershipDate.value = membership.created_at ? new Date(membership.created_at).toLocaleDateString('en-PH', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
    }

    workoutPlans.value = hasActiveMembership.value && Array.isArray(workoutsRes.data) ? workoutsRes.data : [];

    const payments = Array.isArray(paymentsRes.data) ? paymentsRes.data : [];
    if (payments.length > 0) {
      const paidPayments = payments.filter(p => p.status === 'paid');
      paymentAmount.value = formatCurrency(paidPayments.reduce((sum, p) => sum + Number(p.amount || 0), 0));
      paymentStatus.value = paidPayments.length > 0 ? 'Paid' : 'Pending';
    }
  } catch (error) {
    console.error('Dashboard load failed', error);
  }
};

onMounted(loadDashboard);
</script>

<style scoped></style>
