<template>
  <div
    class="@sm/peekable:flex-row @md/modal:flex-row @sm/peekable:py-0 @md/modal:py-0 @sm/peekable:space-y-0 @md/modal:space-y-0 -mx-6 flex flex-col space-y-2 px-6 py-2 md:flex-row md:space-y-0 md:py-0"
  >
    <div
      class="@sm/peekable:w-1/4 @md/modal:w-1/4 @sm/peekable:py-3 @md/modal:py-3 md:w-1/4 md:py-3"
    >
      <h4 class="@sm/peekable:break-all font-normal"><span>Shipped</span></h4>
    </div>
    <div
      class="@sm/peekable:w-3/4 @md/modal:w-3/4 @sm/peekable:py-3 @md/peekable:break-words @lg/modal:break-words break-all md:w-3/4 md/modal:py-3 md:py-3 lg:break-words"
    >
      <div class="flex flex-col space-y-6">
        <template v-if="currentState !== states.CANCELLED">
          <span v-if="currentState === states.PAID"
            >No, order not printed yet</span
          >

          <Button
            v-else-if="currentState === states.READY"
            class="w-[150px] bg-green-500 hover:bg-green-700"
            size="small"
            @click.stop="handleShipOrder()"
          >
            Mark As Shipped
          </Button>

          <span v-if="currentState === states.SHIPPED">
            Yes, {{ fieldValue.shipped_at }}
          </span>

          <Button
            v-if="currentState !== states.SHIPPED"
            class="w-[150px] bg-red-500 hover:bg-red-700"
            size="small"
            @click.stop="confirmCancelOrder()"
          >
            Cancel Order
          </Button>
        </template>

        <span
          v-else
          class="font-semibold text-red-500"
        >
          Order Cancelled
        </span>
      </div>

      <ConfirmActionModal
        :action="actionPayload"
        :errors="{}"
        resource-name="orders"
        :selected-resources="[fieldValue.parent_id]"
        :show="showCancelModal"
        :working="working"
        @close="showCancelModal = false"
        @confirm="handleCancelOrder()"
      />
    </div>
  </div>
</template>

<script>
import { Button } from 'laravel-nova-ui';

export default {
  components: { Button },

  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  data: () => ({
    showCancelModal: false,
    working: false,
  }),

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value;
    },

    currentState() {
      return this.fieldValue.state_id;
    },

    states() {
      return {
        PAID: 3,
        READY: 4,
        SHIPPED: 5,
        REFUNDED: 6,
        CANCELLED: 7,
      };
    },

    actionPayload() {
      return {
        cancelButtonText: 'Cancel',
        component: 'confirm-action-modal',
        confirmButtonText: 'Run Action',
        confirmText: 'Are you sure you want to run this action?',
        destructive: true,
        authorizedToRun: null,
        name: 'Cancel Order',
        uriKey: 'cancel-order',
        fields: [],
        showOnDetail: true,
        showOnIndex: true,
        showOnTableRow: true,
        standalone: false,
        modalSize: '2xl',
        modalStyle: 'window',
        responseType: 'json',
        withoutConfirmation: false,
      };
    },
  },

  methods: {
    confirmCancelOrder() {
      this.showCancelModal = true;
    },

    handleCancelOrder() {
      Nova.$progress.start();

      const data = new FormData();

      data.append('resources', this.fieldValue.parent_id);

      Nova.request({
        method: 'post',
        url: '/nova-api/orders/action',
        params: this.actionQueryString('cancel-order'),
        data,
        responseType: 'json',
      })
        .then(async (response) => {
          this.showCancelModal = false;
          this.$emit('actionExecuted');
          Nova.$emit('refresh-resources');
        })
        .finally(() => {
          Nova.$progress.done();
        });
    },

    handleShipOrder() {
      Nova.$progress.start();

      const data = new FormData();

      data.append('resources', this.fieldValue.parent_id);

      Nova.request({
        method: 'post',
        url: '/nova-api/orders/action',
        params: this.actionQueryString('ship-order'),
        data,
        responseType: 'json',
      })
        .then(async (response) => {
          this.showCancelModal = false;
          this.$emit('actionExecuted');
          Nova.$emit('refresh-resources');
        })
        .finally(() => {
          Nova.$progress.done();
        });
    },

    actionQueryString(action) {
      return {
        action,
        pivotAction: false,
        search: '',
        filters: {},
        trashed: '',
      };
    },
  },
};
</script>

<style scoped>
.bg-green-500 {
  background-color: #22c55e;
}

.hover\:bg-green-700:hover {
  background-color: #15803d;
}

.hover\:bg-red-700:hover {
  background-color: #b91c1c;
}

.w-\[150px\] {
  width: 150px;
}
</style>
