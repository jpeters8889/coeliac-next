<script setup lang="ts">
import Card from '@/Components/Card.vue';
import FormLookup from '@/Components/Forms/FormLookup.vue';
import CategoryProductCard from '@/Components/PageSpecific/Shop/CategoryProductCard.vue';
import Loader from '@/Components/Loader.vue';
import { ShopProductIndex } from '@/types/Shop';
import { nextTick, onMounted, ref } from 'vue';
import axios, { AxiosResponse } from 'axios';

type SearchResult = {
  term: string;
  type: string;
  products: ShopProductIndex[];
};

const lookup = ref<null | { reset: () => void }>(null);

const loadingResult = ref(false);
const searchResult = ref<SearchResult | null>(null);

const selectResult = (id: number) => {
  loadingResult.value = true;

  axios
    .get(`/api/shop/travel-card-search/${id}`)
    .then((response: AxiosResponse<SearchResult>) => {
      // eslint-disable-next-line @typescript-eslint/no-unsafe-call
      lookup.value?.reset();
      searchResult.value = response.data;
      loadingResult.value = false;
    });
};

const termFromSearch = ref();

const handleSearch = (results: { id: number }[]) => {
  if (!termFromSearch.value) {
    return;
  }

  selectResult(results[0].id);
};

const searchContainer = ref<null | HTMLElement>(null);

onMounted(() => {
  nextTick(() => {
    const url = new URL(window.location.href);
    if (url && url.searchParams && url.searchParams.has('term')) {
      setTimeout(() => {
        searchContainer.value?.scrollIntoView({
          behavior: 'smooth',
          inline: 'start',
        });

        termFromSearch.value = url.searchParams.get('term');
      }, 200);
    }
  });
});
</script>

<template>
  <Card class="flex justify-center items-center">
    <div
      ref="searchContainer"
      class="w-full flex flex-col space-y-4 items-center sm:w-2/3"
    >
      <h2 class="text-xl xl:text-2xl font-semibold">Where are you heading?</h2>

      <p class="prose max-w-none md:prose-lg xl:prose-xl">
        Enter the country or language below and we'll try and find the best
        travel card for you!
      </p>

      <FormLookup
        ref="lookup"
        label=""
        name=""
        placeholder="Search for country or language"
        size="large"
        hide-label
        borders
        class="w-full"
        lookup-endpoint="/api/shop/travel-card-search"
        :preselect-term="termFromSearch"
        @search="handleSearch"
      >
        <template #item="{ id, term, type }">
          <div
            class="flex space-x-2 text-left border-b border-grey-off transition cursor-pointer hover:bg-grey-lightest"
            @click="selectResult(id)"
          >
            <span
              class="flex-1 p-2"
              v-html="term"
            />
            <span
              class="font-semibold bg-grey-off-light text-grey-dark text-xs flex justify-center items-center w-[77px] sm:w-[100px]"
            >
              {{ type.charAt(0).toUpperCase() + type.slice(1) }}
            </span>
          </div>
        </template>

        <template #no-results>
          <div class="p-3 text-center flex flex-col space-y-2">
            <div>Sorry, nothing found</div>

            <div>
              Make sure you're searching for a country or a language, and not a
              city or place name, so search <strong>France</strong>, not
              <strong>Paris</strong> for example!
            </div>
          </div>
        </template>
      </FormLookup>
    </div>
  </Card>

  <template v-if="searchResult">
    <div
      v-if="loadingResult"
      class="w-full min-h-map justify-center items-center relative"
    >
      <Loader :display="true" />
    </div>

    <template v-else>
      <Card>
        <p
          v-if="searchResult.type === 'country'"
          class="text-lg font-semibold text-center"
        >
          Here are our travel cards that can be used in
          <span class="text-primary-dark">{{ searchResult.term }}</span>
        </p>

        <p
          v-else
          class="text-lg font-semibold text-center"
        >
          Here are our travel cards that can be used in
          <span class="text-primary-dark">{{ searchResult.term }}</span>
          speaking areas
        </p>
      </Card>

      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <CategoryProductCard
          v-for="product in searchResult.products"
          :key="product.id"
          :product="product"
        />
      </div>
    </template>
  </template>
</template>

<style scoped></style>
