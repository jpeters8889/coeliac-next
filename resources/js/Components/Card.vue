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
  const base: string[] = ['rounded-sm'];

  if (!props.noFlex) {
    base.push('flex', 'flex-col');
  }

  if (!props.noPadding) {
    base.push('p-4');
  }

  if (props.shadow) {
    base.push('shadow-sm');
  }

  if (props.theme === 'white') {
    base.push(props.faded ? 'bg-white/40' : 'bg-white');
  }

  if (props.theme === 'primary') {
    base.push(props.faded ? 'bg-primary/40' : 'bg-primary');
  }

  if (props.theme === 'primary-light') {
    base.push(props.faded ? 'bg-primary-light/40' : 'bg-primary-light');
  }

  if (props.theme === 'secondary') {
    base.push(props.faded ? 'bg-secondary/40' : 'bg-secondary');
  }

  return base;
};
</script>

<template>
  <div :class="classes()">
    <slot />
  </div>
</template>
