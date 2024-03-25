<template>
  <div>
    <DefaultButton
      size="sm"
      component="a"
      @click.stop="() => undefined"
      :href="`/cs-adm/order-dispatch-slip/${fieldValue}`"
      target="_blank"
    >
      View Dispatch Slip
    </DefaultButton>
  </div>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value;
    },
  },
};
</script>
