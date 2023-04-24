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

    <p
      class="prose prose-lg font-semibold max-w-none"
      v-text="recipe.description"
    />

    <div class="flex flex-col xs:flex-row xs:justify-between space-y-2 xs:space-y-0">
      <div v-if="recipe.features.length">
        <h3 class="font-semibold text-base text-grey-darkest">
          This recipe is...
        </h3>
        <ul class="flex flex-row flex-wrap text-sm leading-tight gap-2 gap-y-1">
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
        <div class="bg-red-light bg-opacity-10 rounded p-3 w-full">
          <h3 class="font-semibold text-base text-grey-darkest">
            This recipe contains:
          </h3>
          <ul class="flex flex-row flex-wrap text-sm leading-tight gap-2 gap-y-1">
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
          Last updated {{ recipe.updated }}
        </p>
        <p>Published {{ recipe.published }}</p>
      </div>
      <div>
        <PrinterIcon class="w-8 h-8" />
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

  <Card>
    <!--        <div class="prose prose-lg max-w-none">-->
    <!--            <RenderedString>{{ recipe.body }}</RenderedString>-->
    <!--        </div>-->
  </Card>

  <!--    <Card-->
  <!--        theme="primary-light"-->
  <!--        faded-->
  <!--    >-->
  <!--        <div class="md:flex md:flex-row md:space-x-2 justify-center md:space-x-4">-->
  <!--            <img-->
  <!--                src="/images/misc/alison.jpg"-->
  <!--                class="rounded-full w-1/4 float-left mb-2 mr-2 max-w-[150px]"-->
  <!--                alt="Alison Peters"-->
  <!--            >-->
  <!--            <div class="prose max-w-2xl md:prose-xl">-->
  <!--                <strong>Alison Peters</strong> has been Coeliac since June 2014 and launched Coeliac Sanctuary in August of that year, and since then-->
  <!--                has aimed to provide a one stop shop for Coeliacs, from recipes, to recipes, eating out guide and online shop.-->
  <!--            </div>-->
  <!--        </div>-->
  <!--    </Card>-->

  <Comments
    :id="recipe.id"
    module="recipe"
    :comments="allComments"
    @load-more="loadMoreComments"
  />
</template>
