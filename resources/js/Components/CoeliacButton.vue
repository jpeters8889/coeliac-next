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
    validator: (value: string) => ['primary', 'faded', 'secondary', 'light'].includes(value),
  },
  size: {
    required: false,
    type: String,
    default: 'md',
    validator: (value: string) => ['sm', 'md', 'lg', 'xl'].includes(value),
  },
  bold: {
    required: false,
    type: Boolean,
    default: false,
  },
  as: {
    required: false,
    type: String,
    default: 'Link',
    validator: (value: string) => ['Link', 'button', 'a'].includes(value),
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
    type: [String, Boolean, Function],
    default: false,
    validator: (value: String | Boolean | Function) => value !== true,
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
  classes: {
    type: String,
    required: false,
    default: '',
  },
});

const classes = computed((): string[] => {
  const base = ['inline-flex', 'items-center', 'rounded-md', 'border', 'border-transparent', 'font-medium', 'shadow-sm', 'transition', 'relative'];

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

  if (props.bold) {
    base.push('!font-semibold');
  }

  if (props.icon && props.iconPosition === 'left') {
    base.push('flex-row-reverse');
  }

  if (props.theme === 'primary') {
    base.push('bg-primary/80', 'hover:bg-primary', 'text-white');
  }

  if (props.theme === 'light') {
    base.push('bg-primary-light/80', 'hover:bg-primary-light', 'text-black');
  }

  if (props.theme === 'secondary') {
    base.push('bg-secondary/80', 'hover:bg-secondary', 'text-black');
  }

  base.push(props.classes);

  return base;
});

const primaryComponent = () => {
  if (props.as === 'Link') {
    return Link;
  }

  return props.as;
};

const emits = defineEmits(['click']);

</script>

<template>
  <component
    :is="primaryComponent()"
    :class="classes"
    v-bind="{
      ...(as === 'button' ? {type} : null),
      ...(as === 'Link' ? {href} : null)
    }"
    @click="emits('click')"
  >
    <div :class="{ 'opacity-0': loading }">
      {{ label }}

      <component
        :is="icon"
        v-if="icon"
        class="h-4 w-4"
        :class="iconPosition === 'right' ? 'ml-2 -mr-0.5' : 'mr-2 -ml-0.5'"
        aria-hidden="true"
      />
    </div>

    <div
      v-if="loading"
      class="top-0 left-0 absolute w-full h-full flex justify-center items-center"
    >
      <div class="w-6 h-6 border-4 border-white/20 border-t-white/80 rounded-full animate-spin" />
    </div>
  </component>
</template>
