<script lang="ts" setup>
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';
import CoeliacFooter from '@/Layouts/Components/CoeliacFooter.vue';
</script>

<template>
  <body class="flex min-h-screen flex-col bg-gray-100">
    <CoeliacHeader />

    <section
      class="mx-auto mb-3 flex w-full max-w-7xl flex-1 flex-col space-y-3"
    >
      <slot />
    </section>

    <CoeliacFooter />
  </body>
</template>
