<template>
  <PanelItem
    :index="index"
    :field="field"
  >
    <template #value>
      <div class="map-container flex flex-col space-y-2">
        <div class="address-container flex flex-col space-y-2">
          <p
            v-html="address"
            type="text"
            class="w-full"
          />
        </div>
        <div
          ref="map"
          class="map h-full w-full"
        >
          Map
        </div>
      </div>
    </template>
  </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

  data: () => ({
    address: '',
    latitude: 55.309322,
    longitude: -4.174804,
    zoom: 4,
    mapOptions: {},
    map: null,
    marker: null,
  }),

  mounted() {
    this.value = JSON.parse(this.field.value);

    this.address = this.value.address.replaceAll('\n', '<br />');
    this.latitude = this.value.latitude;
    this.longitude = this.value.longitude;
    this.zoom = 16;

    this.initMap();
  },

  methods: {
    initMap() {
      this.mapOptions = {
        center: new google.maps.LatLng(this.latitude, this.longitude),
        zoom: this.zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        gestureHandling: 'greedy',
        mapTypeControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
      };

      this.map = new google.maps.Map(this.$refs.map, this.mapOptions);

      this.marker = new google.maps.Marker({
        position: new google.maps.LatLng(this.latitude, this.longitude),
        map: this.map,
      });
    },
  },
};
</script>

<style>
.map {
  min-height: 250px;
}
</style>
