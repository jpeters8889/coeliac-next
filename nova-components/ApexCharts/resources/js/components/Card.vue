<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3 w-full">
      <div class="flex justify-between itesm-center">
        <h1
          class="text-3xl text-gray-500 font-light"
          v-text="card.name"
        />

        <div class="flex space-x-2 items-center">
          <SelectControl
            v-if="!loading"
            v-model="selectedDateRange"
            :options="dateRangeOptions"
            @selected="handleDateRangeChange"
          />

          <input
            v-if="selectedDateRange === 'custom'"
            v-model="startDate"
            type="date"
            :max="endDate"
            class="pl-2appearance-none rounded-md h-8 w-full focus:bg-white focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
            @change="getChartable"
          />

          <input
            v-if="selectedDateRange === 'custom'"
            v-model="endDate"
            type="date"
            :min="startDate"
            class="pl-2appearance-none rounded-md h-8 w-full focus:bg-white focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600"
            @change="getChartable"
          />
        </div>
      </div>

      <LoadingView :loading="loading">
        <div class="w-full">
          <apex-chart
            width="100%"
            :type="chart.type"
            :options="chart.options"
            :series="chart.data"
          />
        </div>
      </LoadingView>
    </div>
  </Card>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import dayjs from 'dayjs';

export default {
  components: {
    'apex-chart': VueApexCharts,
  },

  props: {
    card: {
      required: true,
      type: Object,
    },
  },

  data: () => ({
    loading: true,
    dateRanges: [],
    selectedDateRange: undefined,
    chart: undefined,
    startDate: dayjs().subtract(1, 'day').format('YYYY-MM-DD'),
    endDate: dayjs().format('YYYY-MM-DD'),
  }),

  computed: {
    dateRangeOptions() {
      return [
        ...this.dateRanges,
        ...(this.card.customDateRange
          ? [{ label: 'Custom', value: 'custom' }]
          : []),
      ];
    },
  },

  mounted() {
    this.getChartable();
  },

  methods: {
    getChartable() {
      this.loading = true;

      Nova.request()
        .get(this.buildUrl())
        .then((response) => {
          this.dateRanges = response.data.dates;
          this.selectedDateRange = response.data.selectedDateRange;
          this.chart = response.data.chart;

          this.loading = false;
        })
        .catch((error) => {
          Nova.error(error?.response?.data);
        });
    },

    buildUrl() {
      const url = '/nova-vendor/apex-charts';

      const params = new URLSearchParams();

      params.append('chartable', this.card.chartable);

      if (this.selectedDateRange) {
        params.append('selectedDateRange', this.selectedDateRange);

        if (this.selectedDateRange === 'custom') {
          params.append('startDate', this.startDate);
          params.append('endDate', this.endDate);
        }
      }

      return url + '?' + params.toString();
    },

    handleDateRangeChange(e) {
      console.log(e);
      this.getChartable();
    },

    watch: {
      selectedDateRange: function (a, b) {
        console.log(this.selectedDateRange);
        console.log({ a, b });
      },
    },
  },
};
</script>
