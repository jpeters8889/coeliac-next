<script lang="ts" setup>
import { TextareaProps, TextareaPropsDefaults } from '@/Components/Forms/Props';
import { ref, watch } from 'vue';
import RawTextareaField from '@/Components/Forms/RawTextareaField.vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid';

const props = withDefaults(defineProps<TextareaProps>(), TextareaPropsDefaults);

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
    <div class="relative rounded-md shadow-sm">
      <RawTextareaField
        :id="id"
        v-model="value"
        :autocomplete="autocomplete"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :label="label"
        :max="max"
        :rows="rows"
        borders
      />
      <div
        v-if="error"
        class="pointer-events-none absolute inset-y-0 right-0 flex pr-3 pt-3"
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
