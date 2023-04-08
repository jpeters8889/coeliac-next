<script setup lang="ts">
import Card from '@/Components/Card.vue';
import BlogDetailCard from '@/Components/PageSpecific/Blogs/BlogDetailCard.vue';
import Heading from '@/Components/Heading.vue';
import Paginator from '@/Components/Paginator.vue';
import { router } from '@inertiajs/vue3';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { AdjustmentsHorizontalIcon, ArrowUturnLeftIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { Ref, ref } from 'vue';
import BlogListSideBar from '@/Components/PageSpecific/Blogs/BlogListSideBar.vue';
import { PaginatedResponse } from '@/types/GenericTypes';
import { BlogDetailCard as BlogDetailCardType, BlogTag, BlogTagCount } from '@/types/BlogTypes';

defineProps({
  blogs: {
    required: true,
    type: Object as () => PaginatedResponse<BlogDetailCardType>,
  },
  tags: {
    required: true,
    type: Array as () => BlogTagCount[],
  },
  activeTag: {
    required: false,
    type: Object as () => BlogTag,
    default: () => undefined,
  },
});

const showTags = ref(false);

const page = ref(1);

const refreshPage = () => {
  router.get('/blog', {
    ...(page.value > 1 ? { page: page.value } : undefined),
  }, {
    preserveState: true,
    only: ['blogs', 'tags'],
  });
};

const gotoPage = (p: number) => {
  page.value = p;

  refreshPage();
};

const openTagSidebar = (): void => {
  showTags.value = true;
};

const closeTagSidebar = (): void => {
  showTags.value = false;
};
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading v-if="!activeTag">
      Coeliac Sanctuary Blogs
    </Heading>
    <Heading v-else>
      Coeliac Sanctuary Blogs tagged with {{ activeTag.tag }}
    </Heading>

    <p>
      Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of Coeliac
      Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides, and more, we're
      sure you'll find something you'll love here!
    </p>

    <div class="flex justify-between">
      <div>
        <CoeliacButton
          v-if="activeTag"
          label="Back to all Blogs"
          as="Link"
          :icon="ArrowUturnLeftIcon"
          bold
          classes="cursor-pointer"
          href="/blog"
        />
      </div>
      <div>
        <CoeliacButton
          label="Tags"
          as="a"
          :icon="AdjustmentsHorizontalIcon"
          bold
          classes="cursor-pointer"
          icon-position="right"
          @click="openTagSidebar()"
        />
      </div>
    </div>

    <Paginator
      v-if="blogs.meta.last_page > 1"
      :to="blogs.meta.last_page"
      :current="blogs.meta.current_page"
      @change="gotoPage"
    />
  </Card>

  <div class="grid sm:grid-cols-2 xl:grid-cols-3">
    <BlogDetailCard
      v-for="blog in blogs.data"
      :key="blog.link"
      class="transition transition-duration-500 sm:scale-95 sm:hover:scale-100 sm:hover:shadow-lg"
      :blog="blog"
    />
  </div>

  <Paginator
    v-if="blogs.meta.last_page > 1"
    :to="blogs.meta.last_page"
    :current="blogs.meta.current_page"
    @change="gotoPage"
  />

  <BlogListSideBar
    :tags="tags"
    :open="showTags"
    @close="closeTagSidebar()"
  />
</template>
