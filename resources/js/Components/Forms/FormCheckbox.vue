<script lang="ts" setup>
import { CheckboxProps, CheckboxPropsDefault } from '@/Components/Forms/Props';
import { ref, watch } from 'vue';

const props: CheckboxProps = withDefaults(
  defineProps<CheckboxProps>(),
  CheckboxPropsDefault
);

const emits = defineEmits(['update:modelValue']);

const value = ref(props.modelValue);

watch(value, () => {
  emits('update:modelValue', value.value);
});
</script>

<template>
  <div class="relative flex items-center py-1 xmd:py-2">
    <div
      :class="{ 'cursor-not-allowed': disabled }"
      class="min-w-0 flex-1"
    >
      <label
        :class="{
          'text-grey': !disabled,
          'text-grey-off': disabled,
          'font-semibold': value === true,
        }"
        :for="name"
        class="select-none text-sm text-gray-900 xmd:text-base"
        v-text="label"
      />
    </div>
    <div class="ml-3 flex items-center">
      <input
        :id="name"
        v-model="value"
        :disabled="disabled"
        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary xmd:h-5 xmd:w-5"
        type="checkbox"
      />
    </div>
  </div>
</template>
