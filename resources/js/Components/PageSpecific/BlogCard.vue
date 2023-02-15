<script setup lang="ts">
import Card from '@/Components/Card.vue';
import { Link } from '@inertiajs/vue3';
import { BlogSimpleCard } from '@/types/BlogTypes';
import { formatDate } from '@/helpers';

defineProps({
  blog: {
    required: true,
    type: Object as () => BlogSimpleCard,
  },
  withFooter: {
    required: false,
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <Card>
    <Link
      :href="blog.link"
      class="group -m-2"
    >
      <img
        :src="blog.image"
        :alt="blog.title"
      >

      <div class="flex flex-col space-y-3 px-2">
        <h2
          class="text-lg font-semibold group-hover:text-primary-dark transition"
          v-text="blog.title"
        />

        <div class="flex flex-1">
          <p
            v-text="blog.description"
          />
        </div>
      </div>
    </Link>

    <div v-if="withFooter">
      Foo
    </div>
  </Card>
</template>
