<script setup lang="ts">
defineProps({
  as: {
    required: false,
    type: String,
    default: 'h1',
  },
  border: {
    required: false,
    type: Boolean,
    default: true,
  },
});
</script>

<template>
  <div
    class="flex flex-col"
    :class="{'pb-2 border-b border-gray-light': border}"
  >
    <component
      :is="as"
      class="text-3xl font-semibold font-coeliac text-center md:text-4xl"
    >
      <slot />
    </component>
  </div>
</template>
