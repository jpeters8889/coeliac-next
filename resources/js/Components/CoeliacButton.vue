<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { computed, FunctionalComponent, HTMLAttributes, VNodeProps } from 'vue';
import Loader from '@/Components/Loader.vue';

const props = withDefaults(
  defineProps<{
    label?: string;
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
    disabled?: boolean;
    iconOnly?: boolean;
  }>(),
  {
    label: undefined,
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
    disabled: false,
    iconOnly: false,
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

  if (props.disabled) {
    base.push('cursor-not-allowed', 'opacity-50');
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
      ...(props.as === 'button' && props.disabled ? { disabled: true } : null),
    }"
    @click="emits('click')"
  >
    <div :class="{ 'opacity-0': loading }">
      <template v-if="!iconOnly">{{ label }}</template>

      <component
        :is="icon"
        v-if="icon"
        :class="{
          '-mr-0.5 ml-2': !iconOnly && iconPosition === 'right',
          '-ml-0.5 mr-2': !iconOnly && iconPosition === 'left',
          'h-5 w-5': iconOnly,
          'h-4 w-4': !iconOnly,
        }"
        aria-hidden="true"
      />
    </div>

    <Loader :display="loading || false" />
  </component>
</template>
