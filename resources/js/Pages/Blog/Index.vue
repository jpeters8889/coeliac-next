<script setup lang="ts">
import Card from '@/Components/Card.vue';
import BlogDetailCard from '@/Components/PageSpecific/BlogDetailCard.vue';
import Heading from '@/Components/Heading.vue';
import Paginator from '@/Components/Paginator.vue';
import { router } from '@inertiajs/vue3';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import { AdjustmentsHorizontalIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { Ref, ref } from 'vue';
import BlogListSideBar from '@/Components/PageSpecific/BlogListSideBar.vue';
import { PaginatedResponse } from '@/types/GenericTypes';
import { BlogDetailCard as BlogDetailCardType, BlogTagCount } from '@/types/BlogTypes';

const props = defineProps({
  blogs: {
    required: true,
    type: Object as () => PaginatedResponse<BlogDetailCardType>,
  },
  tags: {
    required: true,
    type: Array as () => BlogTagCount[],
  },
  activeTags: {
    required: false,
    type: Array as () => string[],
    default: () => [],
  },
});

const showTags = ref(false);

const filteredTags: Ref<BlogTagCount[]> = ref([]);

const page = ref(1);

if (props.activeTags) {
  const currentTags: string[] = filteredTags.value.map((tag: BlogTagCount) => tag.slug);

  props.activeTags.forEach((activeTag) => {
    if (currentTags.includes(activeTag)) {
      return;
    }

    const tag: BlogTagCount | undefined = props.tags.find((t) => t.slug === activeTag);

    if (tag) {
      filteredTags.value.push(tag);
    }
  });
}

const refreshPage = () => {
  router.get('/blog', {
    ...(page.value > 1 ? { page: page.value } : undefined),
    ...(filteredTags.value.length > 0 ? { tags: filteredTags.value.map((tag) => tag.slug).join(',') } : undefined),
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

const filterTag = (tag: BlogTagCount): void => {
  filteredTags.value.push(tag);

  page.value = 1;
  refreshPage();
};

const removeTag = (tag: BlogTagCount): void => {
  filteredTags.value = filteredTags.value.filter((fTag) => fTag.slug !== tag.slug);

  page.value = 1;
  refreshPage();
};

</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>Coeliac Sanctuary Blogs</Heading>

    <p>
      Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of Coeliac
      Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides, and more, we're
      sure you'll find something you'll love here!
    </p>

    <div class="flex justify-between">
      <div>Search?</div>
      <div>
        <CoeliacButton
          label="Tags"
          as="a"
          :icon="AdjustmentsHorizontalIcon"
          bold
          classes="cursor-pointer"
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

  <Card v-if="filteredTags.length">
    <h3 class="mb-2 font-semibold text-sm">
      Showing blogs tagged with:
    </h3>
    <ul class="flex flex-wrap gap-2 text-xs">
      <li
        v-for="tag in filteredTags"
        :key="tag.slug"
        class="flex"
      >
        <span
          class="bg-primary flex-1 rounded-l-md flex px-2 py-1 justify-center items-center"
          v-text="tag.tag"
        />
        <span
          class="bg-secondary rounded-r-md flex px-1 py-1 justify-center items-center cursor-pointer"
          @click="removeTag(tag)"
        >
          <XMarkIcon class="w-4" />
        </span>
      </li>
    </ul>
  </Card>

  <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
    <BlogDetailCard
      v-for="blog in blogs.data"
      :key="blog.link"
      :blog="blog"
    />
  </div>

  <BlogListSideBar
    :tags="tags"
    :total-blogs="blogs.meta.total"
    :active-tags="filteredTags"
    :open="showTags"
    @close="closeTagSidebar()"
    @add-tag="filterTag"
    @remove-tag="removeTag"
  />
</template>
