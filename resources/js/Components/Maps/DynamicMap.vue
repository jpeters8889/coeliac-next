<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import { loadScript } from '@/helpers';
import { MapPropDefaults, MapProps } from '@/Components/Maps/Props';

const props = withDefaults(defineProps<MapProps>(), MapPropDefaults);

const mapElement = ref();

const apiKey: string = import.meta.env.VITE_GOOGLE_MAPS_DYNAMIC_KEY;

onMounted(() => {
  // this.googleEvent('event', 'dynamic-map', {
  //     event_category: 'dynamic-map',
  //     event_label: `dynamic-map-viewed-${this.lat},${this.lng}`,
  // });

  loadScript(`https://maps.google.com/maps/api/js?key=${apiKey}`).then(() => {
    const center = new google.maps.LatLng(props.lat, props.lng);

    const map = new google.maps.Map(mapElement.value, {
      center,
      zoom: props.zoom,
      mapTypeControl: false,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false,
    });

    // eslint-disable-next-line no-new
    new google.maps.Marker({
      position: center,
      map,
    });
  });
});
</script>

<template>
  <div
    ref="mapElement"
    class="h-[80vh]"
  />
</template>
