<script lang="ts" setup>
import { InputPropDefaults, InputProps } from '@/Components/Forms/Props';
import RawInputField from '@/Components/Forms/RawInputField.vue';
import { defineModel, ref, watch } from 'vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid';

const props = withDefaults(defineProps<InputProps>(), InputPropDefaults);

const emits = defineEmits(['update:modelValue']);

const [value, modifiers] = defineModel({
  set(v: string): string | number {
    if (modifiers.number) {
      return parseInt(v, 10);
    }

    return v;
  },
});

watch(value, () => {
  emits('update:modelValue', value.value);
});

watch(
  () => props.modelValue,
  () => {
    if (props.modelValue !== value.value) {
      value.value = props.modelValue;
    }
  }
);
</script>

<template>
  <div>
    <label
      v-if="hideLabel === false"
      :for="id"
      class="block font-semibold leading-6 text-primary-dark"
      :class="
        size === 'large'
          ? 'text-base md:text-lg xl:text-xl'
          : 'text-base xl:text-lg'
      "
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red"
        v-text="'*'"
      />
    </label>
    <div
      class="relative rounded-md"
      :class="borders ? 'shadow-sm' : ''"
    >
      <RawInputField
        :id="id"
        v-model="value"
        :autocomplete="autocomplete"
        :has-error="!!error"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :label="label"
        :type="type"
        :borders="borders"
        :size="size"
        :min="min"
        :max="max"
        :disabled="disabled"
      />
      <div
        v-if="error"
        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
      >
        <ExclamationCircleIcon
          aria-hidden="true"
          class="h-5 w-5 text-red"
        />
      </div>
    </div>

    <p
      v-if="error"
      :id="`${name}-error`"
      class="mt-2 text-sm text-red"
      v-text="error"
    />
  </div>
</template>
