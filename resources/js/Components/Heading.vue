<script setup lang="ts">
defineProps({
  as: {
    required: false,
    type: String,
    default: 'h1',
  },
});
</script>

<template>
  <div class="flex flex-col pb-2 border-b border-gray-light">
    <component
      :is="as"
      class="text-3xl font-semibold font-coeliac text-center"
    >
      <slot />
    </component>
  </div>
</template>
