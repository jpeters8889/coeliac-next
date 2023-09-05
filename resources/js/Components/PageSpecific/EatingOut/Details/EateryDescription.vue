<script lang="ts" setup>
import { DetailedEatery } from '@/types/EateryTypes';
import Card from '@/Components/Card.vue';
import { ref } from 'vue';
import ReportEateryModal from '@/Components/PageSpecific/EatingOut/Details/Modals/ReportEateryModal.vue';

defineProps<{
  eatery: DetailedEatery;
}>();

const showReportPlaceModal = ref(false);
</script>

<template>
  <Card class="space-y-2">
    <template v-if="eatery.restaurants.length">
      <div
        v-for="restaurant in eatery.restaurants"
        :key="restaurant.name"
      >
        <h4
          v-if="restaurant.name"
          class="font-semibold"
        >
          {{ restaurant.name }}
        </h4>

        <p class="text-sm">
          {{ restaurant.info }}
        </p>
      </div>
    </template>

    <template v-else>
      <p
        class="prose max-w-none md:prose-lg"
        v-html="eatery.info"
      />
    </template>

    <a
      class="mt-2 cursor-pointer text-xs font-semibold italic text-grey-dark transition hover:text-grey-darkest"
      @click.prevent="showReportPlaceModal = true"
    >
      Is there a problem with this location? Let us know.
    </a>
  </Card>

  <ReportEateryModal
    :eatery-name="eatery.name"
    :eatery-id="eatery.id"
    :show="showReportPlaceModal"
    @close="showReportPlaceModal = false"
  />
</template>
