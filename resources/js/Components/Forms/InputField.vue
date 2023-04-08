<script setup lang="ts">
const props = defineProps({
  modelValue: {
    required: true,
    type: String,
  },
  type: {
    required: false,
    type: String,
    default: 'text',
  },
  name: {
    required: true,
    type: String,
  },
  id: {
    required: false,
    type: String,
  },
  required: {
    required: false,
    type: Boolean,
    default: false,
  },
  autocomplete: {
    required: false,
    type: String,
    default: undefined,
  },
  placeholder: {
    required: false,
    type: String,
    default: undefined,
  },
  borders: {
    required: false,
    type: Boolean,
    default: false,
  },
  background: {
    required: false,
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const classes = (): string[] => {
  const base = [
    'flex-1', 'w-full', 'min-w-0', 'appearance-none', 'rounded-md', 'px-[calc(theme(spacing.3)-1px)]',
    'py-[calc(theme(spacing[1.5])-1px)]', 'text-base', 'leading-7', 'text-gray-900', 'placeholder-gray-400', 'shadow-sm', 'outline-none',
    'sm:w-64', 'sm:text-sm', 'sm:leading-6', 'xl:w-full', 'focus:ring-0', 'focus:outline-none transition',
  ];

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

  return base;
};

</script>

<template>
  <input
    :type="type"
    :name="name"
    :required="required"
    :class="classes()"
    :value="modelValue"
    v-bind="{
      ...(id ? {id} : null),
      ...(autocomplete ? {autocomplete} : null),
      ...(placeholder ? {placeholder} : null),
    }"
    @input="emit('update:modelValue', $event.target.value)"
  >
</template>
