<script lang="ts" setup>
import { TextareaProps } from '@/Components/Forms/Props';
import { ref, watch } from 'vue';
import RawTextareaField from '@/Components/Forms/RawTextareaField.vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  label: {
    required: true,
    type: String,
  },
  ...TextareaProps,
});

const emits = defineEmits(['update:modelValue']);

const value = ref(props.modelValue);

watch(value, () => {
  emits('update:modelValue', value.value);
});
</script>

<template>
  <div>
    <label
      :for="id"
      class="block font-medium leading-6 text-gray-900"
    >
      {{ label }}
    </label>
    <div class="relative rounded-md shadow-sm">
      <RawTextareaField
        :id="id"
        v-model="value"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :autocomplete="autocomplete"
        borders
      />
      <div
        v-if="error"
        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"
      >
        <ExclamationCircleIcon
          class="h-5 w-5 text-red"
          aria-hidden="true"
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
