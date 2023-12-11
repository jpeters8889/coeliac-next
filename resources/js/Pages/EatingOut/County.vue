<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import {
  CountyEatery as CountyEateryType,
  CountyPage,
} from '@/types/EateryTypes';
import CountyHeading from '@/Components/PageSpecific/EatingOut/County/CountyHeading.vue';
import CountyEatery from '@/Components/PageSpecific/EatingOut/County/CountyEatery.vue';
import CountyTown from '@/Components/PageSpecific/EatingOut/County/CountyTown.vue';

defineProps<{
  county: CountyPage;
  topRated: CountyEateryType[];
  mostRated: CountyEateryType[];
}>();
</script>

<template>
  <CountyHeading
    :eateries="county.eateries"
    :latlng="county.latlng"
    :image="county.image"
    :name="county.name"
    :reviews="county.reviews"
    :towns="county.towns.length"
  />

  <template v-if="topRated.length">
    <Card class="mt-3 flex flex-col space-y-4">
      <h2 class="text-2xl font-semibold md:text-3xl">
        Top rated places to eat gluten free in {{ county.name }}
      </h2>

      <p class="prose prose-lg max-w-none">
        Discover the best rated places to eat gluten free in
        <span class="font-semibold">{{ county.name }}</span
        >, voted by people like you! From cozy cafes to restaurants, these
        establishments offer exceptional gluten-free options. Enjoy a delightful
        meal or snack, tailored to your dietary needs.
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
        Most rated places to eat gluten free in {{ county.name }}
      </h2>

      <p class="prose prose-lg max-w-none">
        Discover the most reviewed and highly praised places to eat gluten free
        in <span class="font-semibold">{{ county.name }}</span
        >, loved by people just like you! These establishments have garnered a
        significant number of reviews, ensuring a great gluten free experience.
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
      Gluten Free {{ county.name }}
    </h2>

    <p class="prose prose-lg max-w-none">
      If you're heading to <span class="font-semibold">{{ county.name }}</span
      >, our eating out guide lists all the gluten free places in the towns,
      villages, and cities throughout the region. Explore the gluten-free
      options in <span class="font-semibold">{{ county.name }}s</span> diverse
      culinary scene.
    </p>

    <div class="group grid gap-3 md:grid-cols-3">
      <CountyTown
        v-for="town in county.towns"
        :key="town.name"
        :town="town"
      />
    </div>
  </Card>
</template>
