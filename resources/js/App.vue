<template>
  <div class="min-h-screen bg-gray-900 text-white">
    <Layout>
      <router-view />
    </Layout>
  </div>
</template>

<script>
import Layout from './components/Layout.vue';

export default {
  components: { Layout },
};
</script>

<style></style>
