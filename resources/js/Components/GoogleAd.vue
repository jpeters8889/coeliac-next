<script setup lang="ts">
import { computed, onMounted } from 'vue';

defineProps<{ code: string }>();

const hasGoogle = computed(() => !!window.adsbygoogle);

onMounted(() => {
  if (!hasGoogle.value) {
    return;
  }

  (adsbygoogle = window.adsbygoogle || []).push({});
});
</script>

<template>
  <div
    v-if="hasGoogle"
    class="w-full my-2 flex text-center"
  >
    <ins
      class="adsbygoogle"
      style="display: block; width: 100%"
      data-ad-client="ca-pub-1063051842575021"
      :data-ad-slot="code"
      data-ad-format="auto"
      data-full-width-responsive="true"
    />
  </div>
</template>
