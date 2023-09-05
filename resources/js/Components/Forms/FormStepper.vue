<script lang="ts" setup>
import {
  FormStepperPropsDefaults,
  FormStepperProps,
  FormSelectOption,
} from '@/Components/Forms/Props';
import { computed, Ref, ref, watch } from 'vue';

const props = withDefaults(
  defineProps<FormStepperProps>(),
  FormStepperPropsDefaults
);

const emits = defineEmits(['update:modelValue']);

const value: Ref<string | number | boolean> = ref(props.modelValue);

const hoveringOn = ref<null | number>(null);
const selectedOption = ref('');
const currentIndex = ref<null | number>(null);

watch(value, () => {
  emits('update:modelValue', value.value);
});

const displayText = computed(() => {
  if (hoveringOn.value !== null) {
    return props.options[hoveringOn.value].label || '';
  }

  if (selectedOption.value !== '') {
    return selectedOption.value;
  }

  return props.defaultText;
});

const selectOption = (option: FormSelectOption, index: number): void => {
  value.value = option.value;
  currentIndex.value = index;
  selectedOption.value = option.label || '';
};

const isSelected = (index: number): boolean => {
  if (hoveringOn.value !== null && index <= hoveringOn.value) {
    return true;
  }

  if (currentIndex.value !== null && index <= currentIndex.value) {
    return true;
  }

  return false;
};
</script>

<template>
  <div>
    <span
      v-if="label"
      class="block text-lg font-semibold text-primary-dark"
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red"
        v-text="'*'"
      />
    </span>

    <div class="flex max-w-[600px] items-center">
      <div
        class="flex justify-start"
        :class="wrapperClasses"
      >
        <template
          v-for="(option, index) in options"
          :key="option.value"
        >
          <span
            class="cursor-pointer"
            :class="[isSelected(index) ? selectedClass : baseClass]"
            @mouseover="hoveringOn = index"
            @mouseleave="hoveringOn = null"
            @click.prevent="selectOption(option, index)"
          >
            <component
              :is="!isSelected(index) && unselectedIcon ? unselectedIcon : icon"
              :class="iconClasses"
            />
          </span>
        </template>
      </div>

      <template v-if="!hideOptionsText">
        <transition
          enter-active-class="duration-300 ease-out"
          enter-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="duration-200 ease-in"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div class="flex h-6 min-w-[180px] flex-1 items-center transition">
            <div
              class="border-[0.75rem] border-transparent border-r-secondary"
            />
            <div
              class="flex h-6 w-full items-center bg-secondary px-4 text-center text-sm font-semibold xxs:text-base xs:text-base"
            >
              {{ displayText }}
            </div>
          </div>
        </transition>
      </template>
    </div>
  </div>
</template>
