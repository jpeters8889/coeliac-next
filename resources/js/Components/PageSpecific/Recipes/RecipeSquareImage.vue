<script lang="ts" setup>
defineProps<{ src: string; alt: string }>();
</script>

<template>
  <div
    class="relative overflow-hidden"
    style="padding-top: 52.5%"
  >
    <img
      :alt="alt"
      :src="src"
      class="lazy absolute overflow-hidden"
      style="top: -50%; filter: blur(10px); transform: scale(1.1)"
    />
    <div class="absolute top-0 flex h-full w-full justify-center">
      <img
        :alt="alt"
        :src="src"
        class="lazy recipe-img h-full w-auto"
      />
    </div>
  </div>
</template>
