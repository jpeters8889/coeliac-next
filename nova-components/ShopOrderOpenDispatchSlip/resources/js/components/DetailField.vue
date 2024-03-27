<template>
  <div
    class="@sm/peekable:flex-row @md/modal:flex-row @sm/peekable:py-0 @md/modal:py-0 @sm/peekable:space-y-0 @md/modal:space-y-0 -mx-6 flex flex-col space-y-2 px-6 py-2 md:flex-row md:space-y-0 md:py-0"
  >
    <div
      class="@sm/peekable:w-1/4 @md/modal:w-1/4 @sm/peekable:py-3 @md/modal:py-3 md:w-1/4 md:py-3"
    >
      <h4 class="@sm/peekable:break-all font-normal" />
    </div>
    <div
      class="@sm/peekable:w-3/4 @md/modal:w-3/4 @sm/peekable:py-3 @md/peekable:break-words @lg/modal:break-words break-all md:w-3/4 md/modal:py-3 md:py-3 lg:break-words"
    >
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
  </div>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value;
    },
  },
};
</script>
