<script lang="ts" setup>
import CoeliacCompactHeader from '@/Layouts/Components/CoeliacCompactHeader.vue';
import CoeliacCompactFooter from '@/Layouts/Components/CoeliacCompactFooter.vue';
</script>

<template>
  <body class="flex min-h-screen flex-col bg-gray-100">
    <CoeliacCompactHeader />

    <section class="mx-auto mb-3 flex w-full flex-1 flex-col space-y-3">
      <slot />
    </section>

    <CoeliacCompactFooter />
  </body>
</template>
