<script lang="ts" setup>
import { RecipePage } from '@/types/RecipeTypes';

defineProps({
  nutrition: {
    required: true,
    type: Object as () => RecipePage['nutrition'],
  },
});
</script>

<template>
  <div class="flex text-xs xs:text-sm sm:text-base">
    <div class="grid grid-rows-2 leading-none">
      <div class="grid grid-cols-6 divide-x-2 divide-primary bg-primary-light bg-opacity-50 border-b-2 border-primary font-semibold">
        <div class="xs:hidden p-2">
          Cals
        </div>
        <div class="hidden !border-l-transparent xs:block p-2">
          Calories
        </div>
        <div class="p-2">
          Carbs
        </div>
        <div class="p-2">
          Fibre
        </div>
        <div class="p-2">
          Fat
        </div>
        <div class="p-2">
          Sugar
        </div>
        <div class="p-2">
          Protein
        </div>
      </div>

      <div class="grid grid-cols-6 divide-x-2 divide-primary border-b-2 border-primary">
        <div class="p-2">
          {{ nutrition.calories }}
        </div>
        <div class="p-2">
          {{ nutrition.carbs }}<sub>g</sub>
        </div>
        <div class="p-2">
          {{ nutrition.fibre }}<sub>g</sub>
        </div>
        <div class="p-2">
          {{ nutrition.fat }}<sub>g</sub>
        </div>
        <div class="p-2">
          {{ nutrition.sugar }}<sub>g</sub>
        </div>
        <div class="p-2">
          {{ nutrition.protein }}<sub>g</sub>
        </div>
      </div>
    </div>
  </div>
</template>
