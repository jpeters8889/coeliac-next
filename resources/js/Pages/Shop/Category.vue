<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { ShopCategoryIndex, ShopProductIndex } from '@/types/Shop';
import CategoryProductCard from '@/Components/PageSpecific/Shop/CategoryProductCard.vue';
import { ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

defineProps<{
  category: ShopCategoryIndex;
  products: ShopProductIndex[];
}>();
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
    <nav>
      <ol
        role="list"
        class="flex items-center space-x-2"
      >
        <li>
          <div class="flex items-center text-sm">
            <Link
              href="/shop"
              class="inline-flex items-center font-medium text-gray-500 hover:text-primary-dark xl:text-lg"
            >
              <ArrowUturnLeftIcon class="h-6 w-6 pr-2 xl:h-8 xl:w-8" />
              <span class="leading-none"> Back to all categories </span>
            </Link>
          </div>
        </li>
      </ol>
    </nav>

    <Heading>{{ category.title }}</Heading>

    <p
      class="prose max-w-none md:prose-lg xl:prose-xl"
      v-text="category.description"
    />
  </Card>

  <div
    class="grid grid-cols-1 gap-y-4 p-3 sm:grid-cols-2 sm:gap-3 lg:grid-cols-3 2xl:p-0"
  >
    <CategoryProductCard
      v-for="product in products"
      :key="product.link"
      :product="product"
    />
    >
  </div>
</template>
