<script setup lang="ts">
import HomeHero from '@/Components/PageSpecific/Home/HomeHero.vue';
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import HomeHoverGroup from '@/Components/PageSpecific/Home/HomeHoverGroup.vue';
import { HomeHoverItem } from '@/types/Types';

defineProps({
  blogs: {
    required: true,
    type: Array as () => HomeHoverItem[],
  },
  recipes: {
    required: true,
    type: Array as () => HomeHoverItem[],
  },
});
</script>

<template>
  <HomeHero />

  <div class="flex flex-col space-y-2 lg:flex-row lg:space-y-0 lg:space-x-2">
    <div class="w-full lg:w-3/4 flex flex-col space-y-2">
      <Card>
        <h1 class="text-3xl font-semibold font-coeliac mb-3">
          Coeliac Sanctuary - Gluten Free Blog by Alison Peters
        </h1>

        <div class="prose max-w-none">
          <p>
            Our website is our own official sanctuary for Coeliacs to get tips, hints and tricks. Check out
            our blogs and recipes, heading out? Check out our eating out guide to find places to eat at,
            heading abroad? Don't forget your Coeliac travel cards from our shop!
          </p>
        </div>
      </Card>

      <Card>
        Dynamic homepage collection(s)
      </Card>

      <Card>
        Newsletter Sign up
      </Card>

      <HomeHoverGroup
        title="Latest Blogs"
        :items="blogs"
      />

      <HomeHoverGroup
        title="Latest Recipes"
        :items="recipes"
        :per-row="4"
      />
    </div>

    <div class="w-full lg:w-1/4">
      <Card
        class="space-y-4"
        theme="primary-light"
        faded
      >
        <img
          src="/images/misc/alison.jpg"
          alt="Alison Peters - Coeliac Sanctuary"
        >

        <p>
          <strong>Hey, I'm Alison</strong>, I was diagnosed with Coeliac in 2014, Coeliac Sanctuary blossomed
          from the tough time I was going through during diagnosis and almost 12 months of tests as a way to
          share recipes, information and keep track of places to eat safely, with a shop added later selling
          translation cards, wristbands and more.
        </p>

        <p>
          <Link
            class="font-semibold hover:text-primary-dark transition"
            href="/"
          >
            Read more about me
          </Link>
        </p>
      </Card>
    </div>
  </div>
</template>
