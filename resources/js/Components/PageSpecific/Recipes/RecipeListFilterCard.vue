<script lang="ts" setup>
import { AdjustmentsHorizontalIcon } from '@heroicons/vue/20/solid';
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

watch(selectedOptions, () => emit('changed', selectedOptions));
</script>

<template>
  <div class="relative">
    <Listbox
      v-slot="{ open }"
      v-model="selectedOptions"
      multiple
    >
      <ListboxButton
        class="w-full bg-secondary transition hover:bg-opacity-100 p-2 font-semibold text-lg flex items-center"
        :class="open ? 'rounded-t-lg' : 'rounded-lg bg-opacity-70'"
      >
        <AdjustmentsHorizontalIcon class="w-4 h-4 mr-2" />
        <span>{{ label }}</span>
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
            class="p-2 border-b border-secondary transition cursor-pointer last:border-b-0 flex justify-between"
            :class="option.disabled ? 'text-grey-off-dark' : 'hover:bg-grey-light'"
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
