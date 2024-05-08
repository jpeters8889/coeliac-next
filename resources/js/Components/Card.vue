<script lang="ts" setup>
const props = withDefaults(
  defineProps<{
    shadow?: boolean;
    theme?: 'white' | 'primary' | 'primary-light' | 'secondary' | 'transparent';
    faded?: boolean;
    noPadding?: boolean;
    noFlex?: boolean;
  }>(),
  {
    theme: 'white',
    shadow: true,
    faded: false,
    noPadding: false,
    noFlex: false,
  },
);

const classes = (): string[] => {
  const base: string[] = ['rounded'];

  if (!props.noFlex) {
    base.push('flex', 'flex-col');
  }

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
