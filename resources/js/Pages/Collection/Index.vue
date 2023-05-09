<script setup lang="ts">
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import Paginator from '@/Components/Paginator.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { PaginatedResponse } from '@/types/GenericTypes';
import { CollectionDetailCard as CollectionDetailCardType } from '@/types/CollectionTypes';

defineProps({
  collections: {
    required: true,
    type: Object as () => PaginatedResponse<CollectionDetailCardType>,
  },
});

const page = ref(1);

const refreshPage = (preserveScroll = true) => {
  router.get('/collection', {
    ...(page.value > 1 ? { page: page.value } : undefined),
  }, {
    only: ['collections'],
    preserveState: true,
    preserveScroll,
  });
};

const gotoPage = (p: number) => {
  page.value = p;

  refreshPage(false);
};

</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <Heading>
      Coeliac Sanctuary Collections
    </Heading>

    <Paginator
      v-if="collections.meta.last_page > 1"
      :to="collections.meta.last_page"
      :current="collections.meta.current_page"
      @change="gotoPage"
    />
  </Card>

  <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-0">
    <!--    <CollectionDetailCard-->
    <!--      v-for="collection in collections.data"-->
    <!--      :key="collection.link"-->
    <!--      class="transition transition-duration-500 sm:scale-95 sm:hover:scale-100 sm:hover:shadow-lg"-->
    <!--      :collection="collection"-->
    <!--    />-->
  </div>

  <Paginator
    v-if="collections.meta.last_page > 1"
    :to="collections.meta.last_page"
    :current="collections.meta.current_page"
    @change="gotoPage"
  />
</template>
