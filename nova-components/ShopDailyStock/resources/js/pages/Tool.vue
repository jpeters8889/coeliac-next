<template>
  <div>
    <Head title="Shop Daily Stock" />

    <Heading class="mb-6">Shop Daily Stock</Heading>

    <Card
      class="flex flex-col gap-4 p-4"
      style="min-height: 300px"
    >
      <div v-for="category in Object.keys(items)">
        <h2
          v-text="category"
          class="text-lg font-semibold"
        />
        <ul>
          <li
            v-for="(quantity, product) in items[category]"
            v-text="`${product} - ${quantity}`"
          />
        </ul>
      </div>
    </Card>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      required: true,
      type: Object,
    },
  },

  mounted() {
    //
  },
};
</script>

<style>
/* Scoped Styles */
</style>
