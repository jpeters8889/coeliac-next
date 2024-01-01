<script lang="ts" setup>
import Card from '@/Components/Card.vue';
import Heading from '@/Components/Heading.vue';
import { ShopCategoryIndex, ShopProductIndex } from '@/types/Shop';
import CategoryProductCard from '@/Components/PageSpecific/Shop/CategoryProductCard.vue';

defineProps<{
  category: ShopCategoryIndex;
  products: ShopProductIndex[];
}>();
</script>

<template>
  <Card class="mt-3 flex flex-col space-y-4">
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
