<script setup lang="ts">
import HomeHero from '@/Components/PageSpecific/HomeHero.vue';
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import BlogCard from '@/Components/PageSpecific/BlogCard.vue';
import { BlogCard as BlogCardModel } from '@/types/BlogTypes';
import { formatDate } from '@/helpers';

defineProps({
  blogs: {
    required: true,
    type: Array as () => BlogCardModel[],
  },
});
</script>

<template>
  <HomeHero />

  <Card>
    <h1 class="text-3xl font-semibold font-coeliac text-center mb-3">
      Welcome to Coeliac Sanctuary
    </h1>

    <div class="prose max-w-none">
      <p>
        Here at Coeliac Sanctuary we make it our aim to offer more than just a gluten free blog. Fancy something
        different? We have plenty of gluten free recipes which I have personally tried and tested. Eating out?
        Let us help you find places to safely eat as a Coeliac with our eating out guide which is full of places
        recommended by you, our audience. Going abroad? We have our shop where you can buy translation cards
        aimed at making eating out with a language barrier easier and safer along with many more useful items
        for kids and adults alike.
      </p>

      <p>
        Our website is our own official sanctuary for Coeliacs to get tips, hints and tricks. If you have any
        recommendations or recipes you would like us to try please feel free to contact us!
      </p>
    </div>
  </Card>

  <section class="grid grid-cols-1 gap-3 sm:grid-cols-2">
    <Card class="sm:col-span-2">
      <h2 class="text-2xl font-semibold font-coeliac mb-3">
        Latest from the blog
      </h2>

      <p class="prose max-w-none">
        Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of
        Coeliac Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides, and
        more, we're sure you'll find something you'll love here!
      </p>
    </Card>

    <BlogCard
      v-for="blog in blogs"
      :key="blog.link"
      :blog="blog"
    />
  </section>
</template>
