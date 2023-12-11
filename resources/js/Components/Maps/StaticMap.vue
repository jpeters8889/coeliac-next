<script lang="ts" setup>
import { ref } from 'vue';
import Modal from '@/Components/Overlays/Modal.vue';
import DynamicMap from '@/Components/Maps/DynamicMap.vue';
import { MapPropDefaults, MapProps } from '@/Components/Maps/Props';

const props = withDefaults(
  defineProps<MapProps & { mapClasses?: string[] }>(),
  {
    ...MapPropDefaults,
    mapClasses: () => [
      'min-h-map-small',
      'md:min-h-map',
      'lg:min-h-map-small',
      'xl:min-h-map',
    ],
  }
);

const zoom = ref(false);

const apiKey: string = import.meta.env.VITE_GOOGLE_MAPS_STATIC_KEY;

const backgroundUrl = new URL('https://maps.googleapis.com/maps/api/staticmap');
backgroundUrl.searchParams.set('center', `${props.lat},${props.lng}`);
backgroundUrl.searchParams.set('size', '600x600');
backgroundUrl.searchParams.set('maptype', 'roadmap');
backgroundUrl.searchParams.set(
  'markers',
  `color:red|label:|${props.lat},${props.lng}`
);
backgroundUrl.searchParams.set('key', apiKey);

const styles = () => ({
  background: `url(${backgroundUrl.toString()}) no-repeat 50% 50%`,
  lineHeight: 0,
  cursor: 'pointer',
});
</script>

<template>
  <div class="mb-1 h-full">
    <div
      :class="mapClasses"
      :style="styles()"
      class="w-full"
      @click.stop="zoom = true"
    />
  </div>

  <Modal
    :open="zoom"
    no-padding
    size="large"
    width="w-full"
    @close="zoom = false"
  >
    <div class="min-w-full">
      <DynamicMap
        :lat="lat"
        :lng="lng"
      />
    </div>
  </Modal>
</template>
