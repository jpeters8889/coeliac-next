<script setup lang="ts">
const props = defineProps({
  shadow: {
    required: false,
    type: Boolean,
    default: true,
  },
  theme: {
    required: false,
    type: String,
    validator: (value: string) => ['white', 'primary', 'primary-light', 'secondary'].includes(value),
    default: 'white',
  },
  faded: {
    required: false,
    type: Boolean,
    default: false,
  },
  noPadding: {
    required: false,
    type: Boolean,
    default: false,
  },
});

const classes = (): string[] => {
  const base: string[] = ['flex', 'flex-col', 'rounded'];

  if (!props.noPadding) {
    base.push('p-4');
  }

  if (props.shadow) {
    base.push('shadow');
  }

  if (props.theme === 'white') {
    base.push('bg-white');
  }

  if (props.theme === 'primary') {
    base.push('bg-primary');
  }

  if (props.theme === 'primary-light') {
    base.push('bg-primary-light');
  }

  if (props.theme === 'secondary') {
    base.push('bg-secondary');
  }

  if (props.faded) {
    base.push('bg-opacity-40');
  }

  return base;
};
</script>

<template>
  <div :class="classes()">
    <slot />
  </div>
</template>
