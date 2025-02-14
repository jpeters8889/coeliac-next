<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import Heading from '@/Components/Heading.vue';
import Card from '@/Components/Card.vue';
</script>

<template>
  <div class="grid lg:grid-cols-2 gap-4">
    <Card class="flex flex-col space-y-4">
      <Heading>Coeliac Travel Cards</Heading>

      <p class="prose max-w-none md:max-xl:prose-lg xl:prose-xl">
        Our standard coeliac gluten free travel and translation cards come in
        two languages for the price of one card, one on each side of the card,
        and available in over 50 different languages!
      </p>

      <p class="prose max-w-none md:max-xl:prose-lg xl:prose-xl flex-1">
        Our standard gluten free travel cards are perfect for those who have
        coeliac without any other allergies or foods they must avoid, each
        language is professionally translated to explain coeliac disease and a
        gluten free diet, what you can and can't eat, cross contamination, and
        what to look out for.
      </p>

      <CoeliacButton
        :as="Link"
        href="/shop/standard-coeliac-travel-cards"
        size="xl"
        label="View all Coeliac Travel Cards"
        classes="items-center justify-center text-2xl! font-semibold lg:text-3xl!"
      />
    </Card>

    <Card class="flex flex-col space-y-4">
      <Heading>Coeliac+ Travel Cards</Heading>

      <p class="prose max-w-none md:max-xl:prose-lg xl:prose-xl">
        Unlike our standard travel and translation cards, our Coeliac+ travel
        and translation cards come in just one language per card, and are
        currently available in our 10 most popular languages.
      </p>

      <p class="prose max-w-none md:max-xl:prose-lg xl:prose-xl flex-1">
        The first side of the card covers the gluten free diet, professionally
        translated to explain coeliac disease and a gluten free diet, what you
        can and can't eat, cross contamination, and what to look out for, the
        other side of the card has a series of checkboxes for you to check any
        other allergens you have or foods you must avoid, or other dietary
        requirements like vegetarian and vegan.
      </p>

      <CoeliacButton
        :as="Link"
        href="/shop/coeliac-cards"
        size="xl"
        label="View all Coeliac+ Travel Cards"
        classes="items-center justify-center text-2xl! font-semibold lg:text-3xl!"
      />
    </Card>
  </div>
</template>
