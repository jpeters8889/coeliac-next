<script lang="ts" setup>
defineProps({
  src: {
    required: true,
    type: String,
  },
  alt: {
    required: true,
    type: String,
  },
});
</script>

<template>
  <div
    style="padding-top: 52.5%"
    class="relative overflow-hidden"
  >
    <img
      class="absolute overflow-hidden lazy"
      style="top: -50%; filter: blur(10px); transform: scale(1.1)"
      :src="src"
      :alt="alt"
    >
    <div class="absolute top-0 h-full w-full flex justify-center">
      <img
        class="h-full w-auto lazy recipe-img"
        :src="src"
        :alt="alt"
      >
    </div>
  </div>
</template>
