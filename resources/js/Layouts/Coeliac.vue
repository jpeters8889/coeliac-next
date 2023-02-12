<script setup lang="ts">
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';
import CoeliacFooter from '@/Layouts/Components/CoeliacFooter.vue';

defineProps({

});
</script>

<template>
  <body class="bg-gray-100 min-h-screen flex flex-col">
    <CoeliacHeader />

    <section class="w-full mx-auto max-w-7xl flex-1 flex flex-col space-y-3 mb-3">
      <slot />
    </section>

    <CoeliacFooter />
  </body>
</template>
