<script setup lang="ts">
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';

defineProps({

});
</script>

<template>
  <body>
    <CoeliacHeader />

    <section class="mx-auto max-w-8xl">
      <slot />
    </section>
  </body>
</template>
