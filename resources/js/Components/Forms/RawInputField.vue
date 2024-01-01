<script lang="ts" setup>
import { InputPropDefaults, InputProps } from '@/Components/Forms/Props';
import { defineModel } from 'vue';

const props = withDefaults(defineProps<InputProps>(), InputPropDefaults);

const [value, modifiers] = defineModel({
  set(v: string): string | number {
    if (modifiers.number) {
      return parseInt(v, 10);
    }

    return v;
  },
});

const emit = defineEmits(['update:modelValue']);

const classes = (): string[] => {
  const base = [
    'flex-1',
    'w-full',
    'min-w-0',
    'appearance-none',
    'rounded-md',
    'leading-7',
    'text-gray-900',
    'placeholder-gray-400',
    'outline-none',
    'xl:w-full',
    'focus:ring-0',
    'focus:outline-none transition',
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
    base.push('border border-grey-off focus:border-grey-dark shadow-sm');
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
  <input
    :class="classes()"
    :name="name"
    :required="required"
    :type="type"
    :value="modelValue"
    v-bind="{
      ...(id ? { id } : null),
      ...(autocomplete ? { autocomplete } : null),
      ...(placeholder ? { placeholder } : null),
      ...(min ? { min } : null),
      ...(max ? { max } : null),
    }"
    @input="emit('update:modelValue', $event.target.value)"
  />
</template>
