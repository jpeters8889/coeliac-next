<template>
  <div class="flex flex-col space-y-6">
    <template v-if="currentState !== states.CANCELLED">
      <span v-if="currentState === states.PAID">No, order not printed yet</span>

      <DefaultButton
        v-else-if="currentState === states.READY"
        class="w-[150px] bg-green-500 hover:bg-green-700"
        size="sm"
        @click.stop="handleShipOrder()"
      >
        Mark As Shipped
      </DefaultButton>

      <span v-if="currentState === states.SHIPPED">
        Yes, {{ fieldValue.shipped_at }}
      </span>

      <DefaultButton
        v-if="currentState !== states.SHIPPED"
        class="w-[150px] bg-red-500 hover:bg-red-700"
        size="sm"
        @click.stop="confirmCancelOrder()"
      >
        Cancel Order
      </DefaultButton>
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
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  data: () => ({
    showCancelModal: false,
    working: false,
  }),

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
