<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { TravelCardFeedbackItem } from '@/types/Shop';
import CtaGrid from '@/Components/PageSpecific/Shop/TravelCardLandingPage/CtaGrid.vue';
import TravelCardSearchLookup from '@/Components/PageSpecific/Shop/TravelCardSearchLookup.vue';
import CardDescriptions from '@/Components/PageSpecific/Shop/TravelCardLandingPage/CardDescriptions.vue';
import CardFeedback from '@/Components/PageSpecific/Shop/TravelCardLandingPage/CardFeedback.vue';

defineProps<{
  feedback: TravelCardFeedbackItem[];
}>();
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-2">
    <Heading
      :back-link="{ label: 'Back To Shop', href: '/shop' }"
      :border="false"
    >
      Gluten Free Travel and Translation Cards
    </Heading>
  </Card>

  <CtaGrid />

  <TravelCardSearchLookup />

  <CardDescriptions />

  <CardFeedback :feedback="feedback" />
</template>
