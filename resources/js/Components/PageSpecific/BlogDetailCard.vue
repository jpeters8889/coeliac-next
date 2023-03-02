<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { BlogDetailCard } from '@/types/BlogTypes';
import { formatDate } from '@/helpers';

defineProps({
  blog: {
    required: true,
    type: Object as () => BlogDetailCard,
  },
});
</script>

<template>
  <Card>
    <Link
      :href="blog.link"
      class="-m-4 flex flex-col mb-0"
    >
      <img
        :src="blog.image"
        :alt="blog.title"
      >
    </Link>

    <div class="flex flex-col space-y-3 mt-4 flex-1">
      <Link :href="blog.link">
        <h2
          class="text-lg font-semibold hover:text-primary-dark transition"
          v-text="blog.title"
        />
      </Link>

      <div class="flex flex-1">
        <p
          v-text="blog.description"
        />
      </div>
    </div>

    <div class="bg-grey-light -m-4 mt-4 p-4 shadow-inner flex flex-col text-xs">
      <div class="flex flex-col">
        <h4 class="font-semibold mb-1">
          Tagged With
        </h4>
        <ul class="flex flex-wrap gap-2 gap-y-1">
          <li
            v-for="tag in blog.tags"
            :key="tag.slug"
            class="after:content-[','] last:after:content-['']"
          >
            <Link
              href="#"
              class="font-semibold text-primary-dark hover:text-black transition"
            >
              {{ tag.tag }}
            </Link>
          </li>
        </ul>
      </div>

      <div class="flex justify-between mt-4">
        <div>
          Added on {{ formatDate(blog.date) }}
        </div>

        <div>
          0 Comments
        </div>
      </div>
    </div>
  </Card>
</template>
