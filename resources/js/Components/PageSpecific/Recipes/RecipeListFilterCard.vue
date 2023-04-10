<script lang="ts" setup>
import { ArrowDownCircleIcon } from '@heroicons/vue/24/outline';
import {
  Listbox, ListboxButton, ListboxOption, ListboxOptions,
} from '@headlessui/vue';
import { Ref, ref, watch } from 'vue';
import Icon from '@/Components/Icon.vue';
import { SelectBoxItem } from '@/types/Types';

export type RecipeFilterOption = SelectBoxItem & { recipeCount: number };

const props = defineProps({
  label: {
    required: true,
    type: String,
  },
  options: {
    required: true,
    type: Array as () => RecipeFilterOption[],
  },
  currentOptions: {
    required: true,
    type: Array as () => string[],
  },
});

const selectedOptions: Ref<string[]> = ref(props.currentOptions);

const emit = defineEmits(['changed']);

watch(selectedOptions, () => emit('changed', selectedOptions.value));

const optionClasses = (disabled: boolean, selected: boolean): string[] => {
  const base = ['p-2', 'border-b', 'border-secondary', 'transition', 'cursor-pointer', 'last:border-b-0', 'flex', 'justify-between'];

  if (selected) {
    base.push('bg-primary-light', 'bg-opacity-50');
  }

  base.push(disabled ? 'text-grey-off-dark' : 'hover:bg-grey-light');

  return base;
};
</script>

<template>
  <div class="relative">
    <Listbox
      v-slot="{ open }"
      v-model="selectedOptions"
      multiple
    >
      <ListboxButton
        class="w-full bg-secondary transition hover:bg-opacity-100 p-2 font-semibold text-lg flex items-center justify-between"
        :class="open ? 'rounded-t-lg' : 'rounded-lg bg-opacity-70'"
      >
        <div class="flex items-center">
          <ArrowDownCircleIcon
            class="w-8 h-8 mr-2 transition transition-duration-500"
            :class="{'rotate-180': open}"
          />
          <span>{{ label }}</span>
        </div>
        <div v-if="selectedOptions.length">
          <span class="text-grey-dark font-normal">({{ selectedOptions.length }}/{{ options.length }})</span>
        </div>
      </ListboxButton>

      <transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-out"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <ListboxOptions class="z-10 absolute bg-white border-2 border-secondary rounded-b-lg w-full shadow-lg overflow-hidden">
          <ListboxOption
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            :class="optionClasses(option.disabled, selectedOptions.includes(option.value))"
            :disabled="option.disabled"
          >
            <div class="flex space-x-2">
              <Icon :name="option.value" />
              <span>{{ option.label }}</span>
            </div>
            <span>({{ option.recipeCount }} recipes)</span>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </Listbox>
  </div>
</template>
