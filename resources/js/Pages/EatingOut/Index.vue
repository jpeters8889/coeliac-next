<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import { ChevronDownIcon } from '@heroicons/vue/24/solid';
import {
  CountyEatery as CountyEateryType,
  EateryCountryListProp,
} from '@/types/EateryTypes';
import CountyEatery from '@/Components/PageSpecific/EatingOut/County/CountyEatery.vue';
import EateryCountryCard from '@/Components/PageSpecific/EatingOut/Index/EateryCountryCard.vue';
import LocationSearch from '@/Components/PageSpecific/EatingOut/LocationSearch.vue';

defineProps<{
  countries: EateryCountryListProp;
  topRated: CountyEateryType[];
  mostRated: CountyEateryType[];
}>();
</script>

<template>
  <h1
    class="mt-3 w-full bg-white p-2 text-center text-xl font-semibold shadow xxs:w-auto xxs:rounded xxs:bg-primary-light/90 xxs:px-8 xxs:text-lg xxs:shadow-lg xs:p-4 sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl"
  >
    Gluten Free Places to Eat and Visit
  </h1>

  <Card class="mt-3 flex flex-col space-y-4">
    <p class="prose prose-lg max-w-none">
      Our Where to Eat guide lists 1,000s of independent eateries all over the
      UK and Ireland that offer gluten free options or have a gluten free menu.
    </p>

    <p class="prose prose-lg max-w-none">
      Most of the places to eat listed in our guide are contributed by people
      like you, other Coeliac's or people with a gluten intolerance who know of
      local places in their local area and are kind enough to let us know
      through our
      <a
        href="/wheretoeat/recommend-a-place"
        target="_blank"
        >recommend a place</a
      >
      form.
    </p>
  </Card>

  <LocationSearch />

  <Card class="mt-3 flex flex-col space-y-4">
    <a
      class="flex flex-col items-center justify-center space-y-4 text-center text-xl"
      href="#guide"
    >
      <p>Or just browse our Eating Out guide...</p>
      <ChevronDownIcon
        class="h-16 w-16 animate-bounce stroke-2 md:h-24 md:w-24"
      />
    </a>
  </Card>

  <template v-if="topRated.length">
    <Card class="mt-3 flex flex-col space-y-4">
      <h2 class="text-2xl font-semibold md:text-3xl">
        Top rated places to eat gluten free around the UK and Ireland
      </h2>

      <p class="prose prose-lg max-w-none">
        These are the top rated places to eat gluten free in our eating out
        guide, voted by people just like you!
      </p>

      <div class="group grid gap-3 md:grid-cols-3">
        <CountyEatery
          v-for="eatery in topRated"
          :key="eatery.name"
          :eatery="eatery"
        />
      </div>
    </Card>
  </template>

  <template v-if="mostRated.length">
    <Card class="mt-3 flex flex-col space-y-4">
      <h2 class="text-2xl font-semibold md:text-3xl">
        Most rated places to eat gluten free around the UK and Ireland
      </h2>

      <p class="prose prose-lg max-w-none">
        These are the top gluten free places in our eating guide gluten that
        have had the most people leave reviews!
      </p>

      <div class="group grid gap-3 md:grid-cols-3">
        <CountyEatery
          v-for="eatery in mostRated"
          :key="eatery.name"
          :eatery="eatery"
        />
      </div>
    </Card>
  </template>

  <Card class="mt-3 flex flex-col space-y-4">
    <h2 class="text-2xl font-semibold md:text-3xl">
      Gluten Free around the UK and Ireland
    </h2>

    <p class="prose prose-lg max-w-none">
      Our eating out guide is split into countries, counties and then towns or
      cities, click or tap on a country below to get started!
    </p>

    <div class="flex flex-col space-y-3">
      <EateryCountryCard
        v-for="(details, country) in countries"
        :key="country"
        :country="country"
        :details="details"
      />
    </div>
  </Card>
</template>
