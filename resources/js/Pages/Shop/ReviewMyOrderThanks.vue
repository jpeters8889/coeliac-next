<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>Thanks for reviewing your order!</Heading>

    <div class="flex items-center justify-center text-center text-green">
      <CheckCircleIcon class="h-24 w-24" />
    </div>

    <p class="prose max-w-none sm:prose-lg">
      Thank you for sending your feedback, it really does mean a lot and will
      continuously help me improve Coeliac Sanctuary!
    </p>

    <a
      class="mt-3 block w-full rounded-lg bg-primary-light p-2 text-center transition-all hover:bg-primary-light/75"
      href="/"
    >
      Go back home!
    </a>
  </Card>
</template>
