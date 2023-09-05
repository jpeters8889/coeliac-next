<script lang="ts" setup>
import {
  DetailedEatery,
  StarRating as StarRatingType,
} from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { computed } from 'vue';
import Icon from '@/Components/Icon.vue';
import StarRating from '@/Components/StarRating.vue';
import EateryHeaderLinks from '@/Components/PageSpecific/EatingOut/Details/EateryHeaderLinks.vue';

const props = defineProps<{
  eatery: DetailedEatery;
}>();

const icon = computed((): string => {
  if (props.eatery.type === 'Hotel / B&B') {
    return 'hotel';
  }

  if (props.eatery.type === 'Attraction') {
    return 'attraction';
  }

  return 'eatery';
});

const averageRating = (): StarRatingType =>
  parseFloat(props.eatery.reviews.average) as StarRatingType;
</script>

<template>
  <Card class="space-y-2">
    <div class="flex items-center justify-between space-x-2">
      <h1
        class="font-coeliac text-3xl font-semibold leading-tight"
        v-text="eatery.name"
      />

      <div class="w-6 pt-2 text-primary xs:w-7">
        <Icon
          :name="icon"
          class="h-10 w-10"
        />
      </div>
    </div>

    <div
      v-if="eatery.reviews.user_reviews?.length > 0"
      class="flex items-center justify-between sm:flex-row-reverse"
    >
      <span class="flex-1 sm:mr-2">
        Rated <strong>{{ eatery.reviews.average }} stars</strong> from
        <strong
          >{{ eatery.reviews.user_reviews.length }} review{{
            eatery.reviews.user_reviews.length > 1 ? 's' : ''
          }}</strong
        >
      </span>

      <StarRating
        :rating="averageRating()"
        show-all
      />
    </div>

    <div>
      <div class="flex flex-col text-sm font-semibold text-grey-darker">
        <a
          v-if="eatery.county.id === 1 && eatery.branch"
          class="hover:text-black"
          href="/wheretoeat/nationwide"
        >
          Nationwide Chain
        </a>
        <div>
          <span
            v-if="eatery.venue_type"
            v-text="eatery.venue_type"
          />
          <span
            v-if="eatery.cuisine"
            v-text="`, ${eatery.cuisine}`"
          />
        </div>
      </div>

      <div
        v-if="eatery.town.name !== 'Nationwide'"
        class="flex space-x-3 text-xs font-semibold text-grey-darker"
      >
        {{ eatery.town.name }}, {{ eatery.county.name }}
      </div>

      <div
        v-if="eatery.branch"
        class="flex space-x-3 text-xs font-semibold text-grey-darker"
      >
        {{ eatery.branch.town.name }}, {{ eatery.branch.county.name }}
      </div>
    </div>

    <EateryHeaderLinks :eatery="eatery" />
  </Card>
</template>
