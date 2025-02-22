<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import FormInput from '@/Components/Forms/FormInput.vue';
import FormCheckbox from '@/Components/Forms/FormCheckbox.vue';
import useSearch from '@/composables/useSearch';
import {
  EaterySearchResult,
  SearchableItem,
  SearchParams,
  SearchResult,
} from '@/types/Search';
import { PaginatedResponse } from '@/types/GenericTypes';
import { nextTick, onMounted, Ref, ref, watch } from 'vue';
import { watchDebounced } from '@vueuse/core';
import Loader from '@/Components/Loader.vue';
import RecipeSquareImage from '@/Components/PageSpecific/Recipes/RecipeSquareImage.vue';
import { Link, router } from '@inertiajs/vue3';
import StaticMap from '@/Components/Maps/StaticMap.vue';
import { pluralise } from '@/helpers';
import eventBus from '@/eventBus';
import useInfiniteScrollCollection from '@/composables/useInfiniteScrollCollection';
import useBrowser from '@/composables/useBrowser';

const props = defineProps<{
  parameters: SearchParams;
  location: string;
  results: PaginatedResponse<SearchResult>;
  hasEatery: boolean;
  aiAssisted: boolean;
}>();

const formParamsToSearchParams = (): URLSearchParams => {
  return new URLSearchParams({
    q: props.parameters.q,
    blogs: props.parameters.blogs ? 'true' : 'false',
    recipes: props.parameters.recipes ? 'true' : 'false',
    eateries: props.parameters.eateries ? 'true' : 'false',
    shop: props.parameters.shop ? 'true' : 'false',
  });
};

const landmark: Ref<Element> = ref();

const { hasError, searchForm, latLng, submitSearch } = useSearch();

const { items, pause, reset, refreshUrl, requestOptions } =
  useInfiniteScrollCollection<SearchResult>('results', landmark);

onMounted(() => {
  pause.value = true;

  if (props.aiAssisted) {
    const url = new URL(useBrowser().currentUrl());
    url.search = formParamsToSearchParams().toString();

    nextTick(() => {
      history.pushState(null, '', url.toString());
      refreshUrl(url.pathname + url.search);
    });
  }

  if (latLng.value) {
    requestOptions.value = {
      headers: {
        'x-user-location': latLng.value,
      },
    };
  }

  nextTick(() => {
    pause.value = false;
  });
});

const stickyNav = ref(false);

eventBus.$on('sticky-nav-on', () => (stickyNav.value = true));
eventBus.$on('sticky-nav-off', () => (stickyNav.value = false));

searchForm.defaults(props.parameters).reset();

const isNotEatery = (type: SearchableItem): boolean => {
  return type !== 'Eatery' && type !== 'Nationwide Branch';
};

const formatDistance = (distance: number): string => {
  const roundedDistance = distance.toFixed(2);
  const label = pluralise('mile', distance);

  return `${roundedDistance} ${label} away`;
};

const itemTypeClasses = (type: SearchableItem): string[] => {
  const base = [
    'rounded-lg',
    'px-2',
    'py-2',
    'leading-none',
    'text-xs',
    'font-semibold',
    'lg:text-base',
    'lg:px-4',
  ];

  switch (type) {
    case 'Blog':
      base.push('bg-primary');
      break;
    case 'Recipe':
      base.push('bg-primary-light');
      break;
    case 'Eatery':
    case 'Nationwide Branch':
      base.push('bg-secondary');
      break;
    case 'Shop Product':
      base.push('bg-primary-other text-white');
      break;
  }

  return base;
};

const handleSearch = () => {
  pause.value = true;

  submitSearch({
    onSuccess: () => {
      pause.value = false;
      reset();
    },
  });
};

const goToEaterySearch = () => {
  router.post('/wheretoeat/search', {
    term: props.parameters.q,
    range: 5,
  });
};

watch(
  () => searchForm.blogs,
  () => handleSearch(),
);

watch(
  () => searchForm.recipes,
  () => handleSearch(),
);

watch(
  () => searchForm.eateries,
  () => handleSearch(),
);

watch(
  () => searchForm.shop,
  () => handleSearch(),
);

watch(
  () => latLng.value,
  () => {
    console.log('here');
    if (!latLng.value) {
      return;
    }

    requestOptions.value = {
      headers: {
        'x-search-location': latLng.value,
      },
    };
  },
);

watchDebounced(
  () => searchForm.q,
  () => handleSearch(),
  { debounce: 500 },
);
</script>

<template>
  <div class="flex flex-col space-y-4 xmd:flex-row xmd:space-x-4 xmd:space-y-0">
    <div class="xmd:shrink-0 xmd:w-1/4 xmd:max-w-[215px]">
      <Card
        class="mt-3 mx-3 rounded-lg bg-primary-light/40! xmd:bg-primary-light/10! xmd:border-2 xmd:border-primary xmd:rounded-lg xmd:p-3 xmd:fixed xmd:max-w-[195px]"
        :class="stickyNav ? 'xmd:top-[40px]' : 'xmd:top-auto'"
        faded
        :shadow="false"
      >
        <form
          class="flex flex-col space-y-4"
          @submit.prevent="undefined"
        >
          <FormInput
            v-model="searchForm.q"
            label=""
            type="search"
            name="q"
            placeholder="Search..."
            class="flex-1"
            hide-label
            borders
          />

          <p
            v-if="hasError"
            class="text-red font-semibold break-words"
          >
            Please enter at least 3 characters
          </p>

          <div class="grid grid-cols-2 gap-2 xmd:grid-cols-1">
            <FormCheckbox
              v-model="searchForm.blogs"
              label="Blogs"
              layout="left"
              name="blogs"
              xl
            />

            <FormCheckbox
              v-model="searchForm.recipes"
              label="Recipes"
              layout="left"
              name="recipes"
              xl
            />

            <FormCheckbox
              v-model="searchForm.eateries"
              label="Eateries"
              layout="left"
              name="eateries"
              xl
            />

            <FormCheckbox
              v-model="searchForm.shop"
              label="Shop"
              layout="left"
              name="shop"
              xl
            />
          </div>
        </form>
      </Card>
    </div>

    <Card
      v-if="searchForm.processing"
      class="w-full mt-4!"
    >
      <Loader
        color="primary"
        :display="true"
        :absolute="false"
        size="size-12"
      />
    </Card>

    <Card
      v-else-if="items.length === 0"
      class="w-full mt-4!"
    >
      <div
        class="py-8 px-4 text-center text-xl font-semibold text-primary-dark"
      >
        No results found!
      </div>
    </Card>

    <div
      v-else
      class="group xmd:pt-2 xmd:-ml-3! flex flex-col space-y-2 min-h-screen"
    >
      <Card
        v-if="hasEatery"
        class="mx-4 rounded-xl border-2 border-primary"
      >
        <p class="prose lg:prose-xl">
          If you're looking for places to eat in
          <strong v-text="location" />, you can find more detailed results in
          our
          <a
            class="inline-block font-semibold cursor-pointer"
            @click.prevent="goToEaterySearch()"
          >
            Eating Out guide
          </a>
        </p>
      </Card>

      <Card
        v-for="item in items"
        :key="item.link"
        class="transition-all transform scale-95 hover:scale-100 p-4 group/item group-hover:opacity-50 hover:opacity-100!"
      >
        <Link
          :href="item.link"
          class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0"
          prefetch
        >
          <div class="w-full sm:max-xl:w-1/4 xl:w-1/5">
            <RecipeSquareImage
              v-if="item.type === 'Recipe'"
              :src="item.image"
              :alt="item.title"
            />
            <img
              v-else-if="isNotEatery(item.type)"
              :src="item.image"
              :alt="item.title"
            />
            <StaticMap
              v-else
              :lng="(<EaterySearchResult>item).image.lng"
              :lat="(<EaterySearchResult>item).image.lat"
              :can-expand="false"
            />
          </div>

          <div class="flex flex-col space-y-4 sm:flex-1 sm:space-y-2">
            <h2
              class="text-primary-dark text-xl font-semibold group-hover/item:text-black transition lg:max-xl:text-2xl xl:text-3xl"
              v-text="item.title"
            />

            <p
              v-if="typeof item.description === 'string'"
              class="prose max-w-none lg:prose-xl flex-1"
              v-text="item.description"
            />

            <div
              v-for="(restaurant, index) in item.description"
              v-else
              :key="index"
            >
              <p
                class="prose-xl max-w-none lg:prose-2xl flex-1 font-semibold"
                v-text="restaurant.title"
              />
              <p
                class="prose max-w-none lg:prose-xl flex-1"
                v-text="restaurant.info"
              />
            </div>

            <div class="flex justify-between items-end mt-auto">
              <div
                :class="itemTypeClasses(item.type)"
                v-text="item.type"
              />
              <div
                v-if="(<EaterySearchResult>item)?.distance"
                class="text-sm text-grey-off-dark group-hover/item:text-grey-dark lg:text-base"
                v-text="
                  formatDistance(<number>(<EaterySearchResult>item).distance)
                "
              />
            </div>
          </div>
        </Link>
      </Card>
    </div>
    <div ref="landmark" />
  </div>
</template>
