<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed, FunctionalComponent, HTMLAttributes, VNodeProps } from 'vue';
import Loader from '@/Components/Loader.vue';

const props = withDefaults(
  defineProps<{
    label: string;
    theme?: 'primary' | 'faded' | 'secondary' | 'light';
    size?: 'sm' | 'md' | 'lg' | 'xl' | 'xxl';
    bold?: boolean;
    as?: InstanceType<typeof Link> | 'button' | 'a';
    type?: 'submit' | 'button';
    href?: string;
    icon?:
      | string
      | false
      | FunctionalComponent<HTMLAttributes & VNodeProps>
      | Function;
    iconPosition?: 'left' | 'right';
    loading?: boolean;
    classes?: string;
  }>(),
  {
    theme: 'primary',
    size: 'md',
    bold: false,
    as: Link,
    type: undefined,
    href: undefined,
    icon: false,
    iconPosition: 'left',
    loading: false,
    classes: '',
  }
);

const classes = computed((): string[] => {
  const base = [
    'inline-flex',
    'items-center',
    'rounded-md',
    'border',
    'border-transparent',
    'font-medium',
    'shadow-sm',
    'transition',
    'relative',
  ];

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
    case 'xxl': {
      base.push('px-12', 'py-3', 'text-lg', 'font-semibold');
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

const emits = defineEmits(['click']);
</script>

<template>
  <component
    :is="props.as"
    :class="classes"
    v-bind="{
      ...(props.as === 'button' ? { type: props.type } : null),
      ...(props.as === Link || props.as === 'a' ? { href: props.href } : null),
    }"
    @click="emits('click')"
  >
    <div :class="{ 'opacity-0': loading }">
      {{ label }}

      <component
        :is="icon"
        v-if="icon"
        :class="iconPosition === 'right' ? '-mr-0.5 ml-2' : '-ml-0.5 mr-2'"
        aria-hidden="true"
        class="h-4 w-4"
      />
    </div>

    <Loader :display="loading || false" />
  </component>
</template>
