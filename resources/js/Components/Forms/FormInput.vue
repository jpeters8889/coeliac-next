<script lang="ts" setup>
import { InputPropDefaults, InputProps } from '@/Components/Forms/Props';
import RawInputField from '@/Components/Forms/RawInputField.vue';
import { ref, watch } from 'vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid';

const props = withDefaults(
  defineProps<
    InputProps & {
      label: string;
    }
  >(),
  InputPropDefaults,
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
      :for="id"
      class="block font-medium leading-6 text-gray-900"
    >
      {{ label }}
    </label>
    <div class="relative rounded-md shadow-sm">
      <RawInputField
        :id="id"
        v-model="value"
        :autocomplete="autocomplete"
        :has-error="!!error"
        :name="name"
        :placeholder="placeholder"
        :required="required"
        :type="type"
        borders
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
