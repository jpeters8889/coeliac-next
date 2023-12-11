<script lang="ts" setup>
import CoeliacHeader from '@/Layouts/Components/CoeliacHeader.vue';
import CoeliacFooter from '@/Layouts/Components/CoeliacFooter.vue';
import { MetaProps } from '@/types/DefaultProps';

defineProps<{ meta: MetaProps }>();
</script>

<template>
  <body class="flex min-h-screen flex-col bg-gray-100">
    <CoeliacHeader :metas="meta" />

    <section
      class="mx-auto mb-3 flex w-full max-w-8xl flex-1 flex-col space-y-3"
    >
      <slot />
    </section>

    <CoeliacFooter />
  </body>
</template>
