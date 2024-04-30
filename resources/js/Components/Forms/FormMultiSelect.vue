<script lang="ts" setup>
import {
  FormMultiSelectProps,
  FormMultiSelectPropsDefaults,
} from '@/Components/Forms/Props';
import { ref, watch } from 'vue';
import RawMultiSelectField from '@/Components/Forms/RawMultiSelectField.vue';

const props = withDefaults(
  defineProps<FormMultiSelectProps>(),
  FormMultiSelectPropsDefaults
);

const emits = defineEmits(['update:modelValue']);

const value = ref(props.modelValue);

watch(value, () => {
  emits('update:modelValue', value.value);
});
</script>

<template>
  <div>
    <label
      v-if="hideLabel === false"
      :for="id"
      class="block font-semibold leading-6 text-primary-dark"
      :class="
        size === 'large'
          ? 'text-base sm:text-lg xl:text-xl'
          : 'text-base sm:text-lg'
      "
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red"
        v-text="'*'"
      />
    </label>

    <RawMultiSelectField
      v-model="value"
      :name="name"
      :options="options"
      :placeholder="placeholder"
      :borders="borders"
      :allow-other="allowOther"
    ></RawMultiSelectField>

    <p
      v-if="error"
      :id="`${name}-error`"
      class="mt-2 text-sm text-red"
      v-text="error"
    />
  </div>
</template>
