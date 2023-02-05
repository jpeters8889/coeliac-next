<script setup lang="ts">
defineProps({
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
});

const classes = (): string[] => {
  const base = [
    'flex-1', 'w-full', 'min-w-0', 'appearance-none', 'rounded-md', 'border-0', 'bg-white', 'px-[calc(theme(spacing.3)-1px)]',
    'py-[calc(theme(spacing[1.5])-1px)]', 'text-base', 'leading-7', 'text-gray-900', 'placeholder-gray-400', 'shadow-sm', 'outline-none',
    'sm:w-64', 'sm:text-sm', 'sm:leading-6', 'xl:w-full',
  ];

  return base;
};

</script>

<template>
  <input
    :type="type"
    :name="name"
    :required="required"
    :class="classes()"
    v-bind="{
      ...(id ? {id} : null),
      ...(autocomplete ? {autocomplete} : null),
      ...(placeholder ? {placeholder} : null),
    }"
  >
</template>
