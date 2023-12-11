<script lang="ts" setup>
import {
  FormSelectProps,
  FormSelectPropsDefaults,
} from '@/Components/Forms/Props';

const props = withDefaults(
  defineProps<FormSelectProps>(),
  FormSelectPropsDefaults
);

const emit = defineEmits(['update:modelValue']);

const classes = (): string[] => {
  const base = [
    'min-w-0',
    'appearance-none',
    'rounded-md',
    'leading-7',
    'text-gray-900',
    'placeholder-gray-400',
    'shadow-sm',
    'outline-none',
    'focus:ring-0',
    'focus:outline-none transition',
    'w-full',
  ];

  if (props.size === 'large') {
    base.push(
      'text-base md:text-lg px-[calc(theme(spacing.4)-1px)] py-[calc(theme(spacing[1.75])-1px)]'
    );
  } else {
    base.push(
      'px-[calc(theme(spacing.3)-1px)] py-[calc(theme(spacing[1.5])-1px)] text-base sm:text-sm sm:leading-6'
    );
  }

  if (props.borders) {
    base.push('border border-grey-off focus:border-grey-dark');
  } else {
    base.push('border-0');
  }

  if (props.background) {
    base.push('bg-white');
  } else {
    base.push('bg-transparent');
  }

  if (props.error) {
    base.push('!border-red', 'focus:border-red-dark');

    if (!props.borders && props.background) {
      base.push('!bg-red/90');
    }
  }

  return base;
};
</script>

<template>
  <select
    :value="modelValue"
    :name="name"
    :class="classes()"
    :disabled="disabled"
    :required="required"
    v-bind="{
      ...(id ? { id } : null),
      ...(autocomplete ? { autocomplete } : null),
    }"
    @input="emit('update:modelValue', $event.target.value)"
  >
    <option
      v-if="placeholder"
      value=""
      disabled
      class="text-grey"
      v-text="placeholder"
    />

    <option
      v-for="option in options"
      :key="option.value"
      :value="option.value"
      v-text="option.label"
    />
  </select>
</template>
