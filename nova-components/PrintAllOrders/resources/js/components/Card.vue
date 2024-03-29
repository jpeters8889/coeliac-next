<template>
  <Card class="flex justify-end">
    <div class="px-3 py-3">
      <DefaultButton
        size="sm"
        component="a"
        @click.stop="() => undefined"
        :href="`/cs-adm/order-dispatch-slip/all`"
        target="_blank"
        style="font-size: 20px; height: 3rem; padding: 0 20px"
      >
        Print All Orders
      </DefaultButton>
    </div>
  </Card>
</template>

<script>
export default {
  props: [
    'card',

    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],

  mounted() {
    //
  },
};
</script>
