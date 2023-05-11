<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';
import { RecipeDetailCard } from '@/types/RecipeTypes';

defineProps({
  recipe: {
    required: true,
    type: Object as () => RecipeDetailCard,
  },
});
</script>

<template>
  <Card>
    <div class="group flex-1">
      <Link
        :href="recipe.link"
        class="-m-4 flex flex-col mb-0"
      >
        <img
          v-if="recipe.square_image"
          :src="recipe.image"
          :alt="recipe.title"
          loading="lazy"
        >
        <RecipeSquareImage
          v-else
          :src="recipe.image"
          :alt="recipe.title"
        />
      </Link>

      <div class="flex flex-col space-y-3 mt-4 flex-1">
        <Link :href="recipe.link">
          <h2
            class="text-xl font-semibold transition hover:text-primary-dark group-hover:text-primary-dark"
            v-text="recipe.title"
          />
        </Link>

        <div class="flex flex-1">
          <p
            v-text="recipe.description"
          />
        </div>
      </div>
    </div>

    <div class="bg-grey-light -m-4 mt-4 p-4 shadow-inner flex flex-col text-sm">
      <div class="flex flex-col space-y-4">
        <div
          v-if="recipe.features.length"
          class="flex flex-col"
        >
          <h4 class="font-semibold">
            This recipe is
          </h4>
          <ul class="flex flex-wrap gap-2 gap-y-1">
            <li
              v-for="feature in recipe.features"
              :key="feature.slug"
              class="after:content-[','] last:after:content-['']"
            >
              <Link
                :href="`/recipe?features=${feature.slug}`"
                class="font-semibold text-primary-dark hover:text-black transition"
              >
                {{ feature.feature }}
              </Link>
            </li>
          </ul>
        </div>

        <div class="flex flex-col">
          <span class="font-semibold">
            Makes {{ recipe.nutrition.servings }}
          </span>

          <span class="font-semibold">
            {{ recipe.nutrition.calories }} calories per {{ recipe.nutrition.portion_size }}
          </span>
        </div>
      </div>

      <div class="flex justify-between mt-4">
        <div>
          Added on {{ recipe.date }}
        </div>
      </div>
    </div>
  </Card>
</template>
