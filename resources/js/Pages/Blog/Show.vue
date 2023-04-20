<script setup lang="ts">
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { Link, router } from '@inertiajs/vue3';
import Comments from '@/Components/PageSpecific/Shared/Comments.vue';
import { ref, Ref } from 'vue';
import { Page, PageProps } from '@inertiajs/core/types/types';
import { BlogPage } from '@/types/BlogTypes';
import { PaginatedResponse } from '@/types/GenericTypes';
import { Comment } from '@/types/Types';

const props = defineProps({
  blog: {
    required: true,
    type: Object as () => BlogPage,
  },
  comments: {
    required: true,
    type: Object as () => PaginatedResponse<Comment>,
  },
});

const allComments: Ref<PaginatedResponse<Comment>> = ref(props.comments);

const loadMoreComments = () => {
  if (!props.comments.links.next) {
    return;
  }

  router.get(props.comments.links.next, {}, {
    preserveScroll: true,
    preserveState: true,
    only: ['comments'],
    onSuccess: (event: Page<PageProps & { comments?: PaginatedResponse<Comment> }>) => {
      // eslint-disable-next-line no-restricted-globals
      history.pushState(null, '', `${window.location.origin}${window.location.pathname}`);

      if (!event.props.comments) {
        return true;
      }

      allComments.value.data.push(...event.props.comments.data);
      allComments.value.links = event.props.comments.links;
      allComments.value.meta = event.props.comments.meta;

      return false;
    },
  });
};

</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>
      {{ blog.title }}
    </Heading>

    <p
      class="prose prose-lg font-semibold max-w-none"
      v-text="blog.description"
    />

    <div class="bg-grey-light -m-4 !-mb-4 p-4 shadow-inner flex flex-col text-sm flex flex-col space-y-4">
      <div>
        <strong>Tagged With</strong>
        <ul class="flex flex-wrap space-x-1">
          <li
            v-for="tag in blog.tags"
            :key="tag.slug"
            class="after:content-[','] last:after:content-['']"
          >
            <Link
              :href="`/blog/tag/${tag.slug}`"
              class="font-semibold text-primary-dark hover:text-grey-dark"
            >
              {{ tag.tag }}
            </Link>
          </li>
        </ul>
      </div>

      <div>
        <p v-if="blog.updated">
          Last updated {{ blog.updated }}
        </p>
        <p>Published {{ blog.published }}</p>
      </div>
    </div>
  </Card>

  <Card no-padding>
    <img
      :src="blog.image"
      loading="lazy"
      :alt="blog.title"
    >
  </Card>

  <Card>
    <p
      class="prose prose-lg max-w-none"
      v-html="blog.body"
    />
  </Card>

  <Card
    theme="primary-light"
    faded
  >
    <div class="md:flex md:flex-row md:space-y-2">
      <img
        src="/images/misc/alison.jpg"
        class="rounded-full w-1/4 float-left mb-2 mr-2"
        alt="Alison Peters"
      >
      <div>
        <strong>Alison Peters</strong> has been Coeliac since June 2014 and launched Coeliac Sanctuary in August of that year, and since then
        has aimed to provide a one stop shop for Coeliacs, from blogs, to recipes, eating out guide and online shop.
      </div>
    </div>
  </Card>

  <Comments
    :id="blog.id"
    module="blog"
    :comments="allComments"
    @load-more="loadMoreComments"
  />
</template>
