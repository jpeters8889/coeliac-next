<template>
  <Card class="flex justify-end">
    <div class="px-3 py-3">
      <Button
        as="div"
        size="small"
        style="font-size: 20px; height: 3rem; padding: 0 20px"
        @click.stop="() => undefined"
      >
        <a
          href="/cs-adm/order-dispatch-slip/all"
          target="_blank"
        >
          Print All Orders
        </a>
      </Button>
    </div>
  </Card>
</template>

<script>
import { Button } from 'laravel-nova-ui';

export default {
  components: { Button },

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
