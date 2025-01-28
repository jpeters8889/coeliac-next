<template>
  <div>
    <Button
      size="small"
      as="div"
      @click.stop="() => undefined"
    >
      <a
        :href="`/cs-adm/order-dispatch-slip/${fieldValue}`"
        target="_blank"
      >
        View Dispatch Slip
      </a>
    </Button>
  </div>
</template>

<script>
import { Button } from 'laravel-nova-ui';

export default {
  components: { Button },

  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value;
    },
  },
};
</script>
