<script lang="ts" setup>
import { PaginatedResponse } from '@/types/GenericTypes';
import { ref, Ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { RecipePage } from '@/types/RecipeTypes';
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import Comments from '@/Components/PageSpecific/Shared/Comments.vue';
import { PrinterIcon } from '@heroicons/vue/20/solid';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';
import RecipeNutritionTable from '@/Components/PageSpecific/Recipes/RecipeNutritionTable.vue';

const props = defineProps({
  recipe: {
    required: true,
    type: Object as () => RecipePage,
  },
  comments: {
    required: true,
    type: Object as () => PaginatedResponse<Comment>,
  },
});

const allComments: Ref<PaginatedResponse<Comment>> = ref(props.comments);

const loadMoreComments = () => {
  if (!props.comments.links.next) {
    return;
  }

  router.get(props.comments.links.next, {}, {
    preserveScroll: true,
    preserveState: true,
    only: ['comments'],
    onSuccess: (event: { props: { comments?: PaginatedResponse<Comment> } }) => {
      // eslint-disable-next-line no-restricted-globals
      history.pushState(null, '', `${window.location.origin}${window.location.pathname}`);

      if (!event.props.comments) {
        return true;
      }

      allComments.value.data.push(...event.props.comments.data);
      allComments.value.links = event.props.comments.links;
      allComments.value.meta = event.props.comments.meta;

      return false;
    },
  });
};
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>
      {{ recipe.title }}
    </Heading>

    <div
      class="prose prose-lg font-semibold max-w-none"
      v-text="recipe.description"
    />

    <div class="flex flex-col xs:flex-row xs:justify-between space-y-2 xs:space-y-0 md:text-lg">
      <div v-if="recipe.features.length">
        <h3 class="font-semibold text-grey-darkest">
          This recipe is...
        </h3>
        <ul class="flex flex-row flex-wrap leading-tight gap-2 gap-y-1">
          <li
            v-for="feature in recipe.features"
            :key="feature.slug"
            class="after:content-[','] last:after:content-['']"
          >
            <Link
              class="font-semibold text-primary-dark hover:text-grey-darker"
              :href="`/recipe?features=${feature.slug}`"
            >
              {{ feature.feature }}
            </Link>
          </li>
        </ul>
      </div>

      <div v-if="recipe.allergens.length">
        <div class="bg-red-light bg-opacity-10 rounded p-3 pr-12 w-full">
          <h3 class="font-semibold text-grey-darkest">
            This recipe contains:
          </h3>
          <ul class="flex flex-row flex-wrap leading-tight gap-2 gap-y-1">
            <li
              v-for="allergen in recipe.allergens"
              :key="allergen.slug"
              class="font-semibold text-primary-dark after:content-[','] last:after:content-['']"
              v-text="allergen.allergen"
            />
          </ul>
        </div>
      </div>
    </div>

    <div class="bg-grey-light -m-4 !-mb-4 p-4 shadow-inner flex justify-between">
      <div>
        <p v-if="recipe.updated">
          <span class="font-semibold">Last updated</span> {{ recipe.updated }}
        </p>
        <p><span class="font-semibold">Added</span> {{ recipe.published }}</p>
        <p><span class="font-semibold">Recipe by</span> <span v-html="recipe.author" /></p>
      </div>

      <div>
          <a :href="recipe.print_url" target="_blank">
        <PrinterIcon class="w-12 h-12" />
          </a>
      </div>
    </div>
  </Card>

  <Card no-padding>
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
  </Card>

  <Card class="space-y-3 pb-0">
    <h2 class="font-semibold text-xl text-primary-dark">
      Ingredients
    </h2>

    <div
      class="prose prose-lg max-w-none"
      v-html="recipe.ingredients"
    />

    <ul class="bg-grey-light border-t border-grey-off-light -m-4 mt-4 p-4">
      <li><strong class="font-semibold">Preparation Time:</strong> {{ recipe.timing.prep_time }}</li>
      <li><strong class="font-semibold">Cooking Time:</strong> {{ recipe.timing.cook_time }}</li>
      <li><strong class="font-semibold">This recipe makes {{ recipe.nutrition.servings }}</strong></li>
    </ul>
  </Card>

  <Card class="space-y-3">
    <h3 class="font-semibold text-xl text-primary-dark">
      Method
    </h3>

    <article
      class="prose prose-lg max-w-none"
      v-html="recipe.method"
    />

    <h3 class="text-base font-semibold mt-4 mb-2">
      Nutritional Information (Per {{ recipe.nutrition.portion_size }})
    </h3>

    <RecipeNutritionTable :nutrition="recipe.nutrition" />
  </Card>

  <Comments
    :id="recipe.id"
    module="recipe"
    :comments="allComments"
    @load-more="loadMoreComments"
  />
</template>
