<script lang="ts" setup>
import { computed } from 'vue';

const props = withDefaults(
  defineProps<{
    absolute?: boolean;
    display: boolean;
    size?: string;
    width?: string;
    color?: 'white' | 'primary' | 'secondary';
    background?: boolean;
  }>(),
  {
    absolute: true,
    size: 'w-6 h-6',
    width: 'border-4',
    color: 'white',
    background: false,
  }
);

const classes = computed((): string[] => {
  const base = ['animate-spin', 'rounded-full'];

  base.push(props.size, props.width);

  switch (props.color) {
    default:
    case 'white':
      base.push('border-white/20', 'border-t-white/80');
      break;
    case 'secondary':
      base.push('border-secondary/20', 'border-t-secondary/80');
      break;
    case 'primary':
      base.push('border-primary/20', 'border-t-primary/80');
      break;
  }

  return base;
});
</script>

<template>
  <div
    v-if="display"
    class="left-0 top-0 flex h-full w-full items-center justify-center"
    :class="{
      absolute: absolute,
      'bg-black bg-opacity-50': background,
    }"
  >
    <div :class="classes" />
  </div>
</template>
