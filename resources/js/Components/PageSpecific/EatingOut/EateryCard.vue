<script lang="ts" setup>
import { TownEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed } from 'vue';
import StaticMap from '@/Components/Maps/StaticMap.vue';
import EateryIntroduction from '@/Components/PageSpecific/EatingOut/EaterySnippetComponents/EateryIntroduction.vue';
import EateryReviews from '@/Components/PageSpecific/EatingOut/EaterySnippetComponents/EateryReviews.vue';
import EateryInfoBlock from '@/Components/PageSpecific/EatingOut/EaterySnippetComponents/EateryInfoBlock.vue';

const props = defineProps<{ eatery: TownEatery }>();

const isNotNationwide = computed(() => props.eatery.county.id !== 1);
</script>

<template>
  <Card>
    <div class="flex w-full">
      <div
        :class="{ 'sm:w-3/5 lg:w-2/3': isNotNationwide }"
        class="flex w-full flex-col"
      >
        <EateryIntroduction
          :cuisine="eatery.cuisine"
          :is-not-nationwide="isNotNationwide"
          :link="eatery.link"
          :name="eatery.name"
          :type="eatery.type"
          :venue-type="eatery.venue_type"
          :website="eatery.website"
        />

        <EateryInfoBlock
          :address="eatery.location.address"
          :info="eatery.info"
          :is-not-nationwide="isNotNationwide"
          :phone="eatery.phone"
          :restaurants="eatery.restaurants"
        />
      </div>

      <div
        v-if="isNotNationwide"
        class="hidden pl-4 sm:block sm:w-2/5 lg:w-1/3"
      >
        <StaticMap
          :lat="eatery.location.lat"
          :lng="eatery.location.lng"
        />
      </div>
    </div>

    <EateryReviews
      :link="eatery.link"
      :name="eatery.name"
      :reviews="eatery.reviews"
    />
  </Card>
</template>
