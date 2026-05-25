<template>
  <div>
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Chart, LineController, LineElement, PointElement, LinearScale, Title, CategoryScale } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, Title, CategoryScale);

const canvas = ref(null);

onMounted(() => {
  if (!canvas.value) return;
  new Chart(canvas.value.getContext('2d'), {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [
        {
          label: 'Check-ins',
          data: [100, 120, 150, 170, 160, 180],
          borderColor: 'rgba(255,165,0,0.9)',
          backgroundColor: 'rgba(255,165,0,0.2)',
          tension: 0.4,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } },
    },
  });
});
</script>

<style scoped>
canvas { width: 100%; height: 160px; }
</style>
