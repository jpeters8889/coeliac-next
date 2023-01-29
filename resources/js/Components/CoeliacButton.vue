<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  label: {
    required: true,
    type: String,
  },
  theme: {
    required: false,
    type: String,
    default: 'primary',
    validator: (value: string) => ['primary', 'faded', 'secondary'].includes(value),
  },
  size: {
    required: false,
    type: String,
    default: 'md',
    validator: (value: string) => ['sm', 'md', 'lg', 'xl'].includes(value),
  },
  as: {
    required: false,
    type: String,
    default: 'Link',
    validator: (value: string) => ['Link', 'button'].includes(value),
  },
  type: {
    required: false,
    type: String,
    default: null,
    validator: (value: string) => ['submit', 'button'].includes(value),
  },
  href: {
    required: false,
    type: String,
    default: null,
  },
  icon: {
    required: false,
    type: [String, Boolean],
    default: false,
    validator: (value: String | Boolean) => value !== true,
  },
  iconPosition: {
    required: false,
    type: String,
    default: 'left',
  },
  loading: {
    type: Boolean,
    required: false,
    default: false,
  },
});

const classes = computed((): string[] => {
  const base = ['inline-flex', 'items-center', 'rounded-md', 'border', 'border-transparent', 'font-medium', 'shadow-sm'];

  switch (props.size) {
    case 'sm': {
      base.push('px-3', 'py-2', 'text-sm leading-4');
      break;
    }
    case 'md':
    default: {
      base.push('px-4', 'py-2', 'text-sm');
      break;
    }
    case 'lg': {
      base.push('px-4', 'py-2', 'text-base');
      break;
    }
    case 'xl': {
      base.push('px-6', 'py-3', 'text-base');
      break;
    }
  }

  if (props.icon && props.iconPosition === 'right') {
    base.push('flex-row-reverse');
  }

  if (props.theme === 'primary') {
    base.push('bg-primary/90', 'hover:bg-primary', 'text-white');
  }

  if (props.theme === 'secondary') {
    base.push('bg-primary-light/90', 'hover:bg-primary-light', 'text-black');
  }

  if (props.theme === 'secondary') {
    base.push('bg-secondary/90', 'hover:bg-secondary', 'text-black');
  }

  return base;
});

const primaryComponent = () => {
  if (props.as === 'Link') {
    return Link;
  }

  return props.as;
};

</script>

<template>
  <component
    :is="primaryComponent()"
    :class="classes"
    v-bind="{
      ...(as === 'button' ? {type} : null),
      ...(as === 'Link' ? {href} : null)
    }"
  >
    {{ label }}

    <component
      :is="icon"
      v-if="icon"
      class="h-4 w-4"
      :class="iconPosition === 'left' ? 'ml-2 -mr-0.5' : 'mr-2 -ml-0.5'"
      aria-hidden="true"
    />
  </component>
</template>
