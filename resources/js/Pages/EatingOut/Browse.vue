<script lang="ts" setup>
import useScreensize from '@/composables/useScreensize';
import { computed, ComputedRef, onMounted, Ref, ref } from 'vue';
import { fromLonLat, toLonLat, transformExtent } from 'ol/proj';
import { Coordinate } from 'ol/coordinate';
import { Cluster, OSM } from 'ol/source';
import Map from 'ol/Map';
import TileLayer from 'ol/layer/Tile';
import { Feature, MapBrowserEvent, View } from 'ol';
import { getDistance } from 'ol/sphere';
import SearchMap from '@/Components/PageSpecific/EatingOut/Browse/SearchMap.vue';
import FilterMap from '@/Components/PageSpecific/EatingOut/Browse/FilterMap.vue';
import axios, { AxiosResponse } from 'axios';
import {
  EateryBrowseResource,
  EateryFilterItem,
  EateryFilters,
  LatLng,
} from '@/types/EateryTypes';
import { DataResponse } from '@/types/GenericTypes';
import BaseLayer from 'ol/layer/Base';
import { Point } from 'ol/geom';
import { Fill, Icon, Stroke, Style, Text } from 'ol/style';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import CircleStyle from 'ol/style/Circle';
import { FeatureLike } from 'ol/Feature';
import Loader from '@/Components/Loader.vue';
import CoeliacCompact from '@/Layouts/CoeliacCompact.vue';
import { boundingExtent } from 'ol/extent';
import { Pixel } from 'ol/pixel';
import { usePage } from '@inertiajs/vue3';
import { DefaultProps } from '@/types/DefaultProps';
import 'ol/ol.css';

defineOptions({
  layout: CoeliacCompact,
});

const isLoading = ref(true);

const wrapper: Ref<HTMLDivElement> = ref() as Ref<HTMLDivElement>;

const mapFilters: Ref<EateryFilters | undefined> = ref();

const map: Ref<Map> = ref() as Ref<Map>;

const processedUrl: Ref<{
  latLng?: string;
  zoom?: string;
  categories?: string;
  venueTypes?: string;
  features?: string;
}> = ref({});

const { currentBreakpoint, screenIsGreaterThanOrEqualTo } = useScreensize();

const initialLatLng = computed((): Coordinate => {
  let latLng: [number, number] = [54.093409, -2.89479];

  if (processedUrl.value.latLng) {
    latLng = processedUrl.value.latLng
      .split(',')
      .map((str) => parseFloat(str)) as [number, number];
  }

  return fromLonLat(latLng.reverse());
});

const initialZoom = computed((): number => {
  if (processedUrl.value.zoom) {
    return parseFloat(processedUrl.value.zoom);
  }

  switch (currentBreakpoint()) {
    case 'sm':
    case 'xmd':
    case 'md':
    case 'lg':
    case 'xl':
    case '2xl':
      return 6;
    case 'xs':
    case 'xxs':
    default:
      return 5;
  }
});

const getViewableRadius = (): number => {
  const latLng = transformExtent(
    map.value.getView().calculateExtent(map.value.getSize()),
    'EPSG:3857',
    'EPSG:4326'
  );

  return getDistance([latLng[0], latLng[1]], [latLng[2], latLng[3]]) / 1609;
};

const getLatLng = (): LatLng => {
  const latLng = toLonLat(
    map.value.getView().getCenter() as Coordinate
  ).reverse();

  return {
    lat: latLng[0],
    lng: latLng[1],
  };
};

type UrlFilter = { [T in 'category' | 'venueType' | 'feature']?: string };

const setFilters: ComputedRef<{ filter: UrlFilter }> = computed(() => {
  const filter: UrlFilter = {};

  if (
    mapFilters.value?.categories.filter((f: EateryFilterItem) => f.checked)
      .length
  ) {
    filter.category = mapFilters.value?.categories
      .filter((f: EateryFilterItem) => f.checked)
      .map((f: EateryFilterItem) => f.value)
      .join(',');
  }

  if (
    mapFilters.value?.venueTypes.filter((f: EateryFilterItem) => f.checked)
      .length
  ) {
    filter.venueType = mapFilters.value?.venueTypes
      .filter((f: EateryFilterItem) => f.checked)
      .map((f: EateryFilterItem) => f.value)
      .join(',');
  }

  if (
    mapFilters.value?.features.filter((f: EateryFilterItem) => f.checked).length
  ) {
    filter.feature = mapFilters.value?.features
      .filter((f: EateryFilterItem) => f.checked)
      .map((f: EateryFilterItem) => f.value)
      .join(',');
  }

  return { filter };
});

const getPlaces = async (): Promise<EateryBrowseResource[]> => {
  const response: AxiosResponse<DataResponse<EateryBrowseResource[]>> =
    await axios.get('/api/wheretoeat/browse', {
      params: {
        ...getLatLng(),
        radius: getViewableRadius(),
        ...setFilters.value,
      },
    });

  return response.data.data;
};

const getMarkersLayer = (): VectorLayer<VectorSource> | undefined => {
  let rtr;

  map.value.getLayers().forEach((layer: BaseLayer) => {
    if (layer.get('name') !== undefined && layer.get('name') === 'markers') {
      rtr = layer;
    }
  });

  return rtr;
};

const clearMarkers = (): void => {
  map.value.removeLayer(getMarkersLayer() as VectorLayer<VectorSource>);
  map.value.removeLayer(getMarkersLayer() as VectorLayer<VectorSource>);
};

const getEateryLatLng = (eatery: EateryBrowseResource): Coordinate =>
  [eatery.location.lng, eatery.location.lat] as Coordinate;

const markerStyle = (): Style =>
  new Style({
    image: new Icon({
      // crossOrigin: 'anonymous',
      size: [50, 50],
      src: '/images/svg/marker.svg',
    }),
  });

const getZoom = (): number => map.value.getView().getZoom() as number;

const clusterStyle = (feature: FeatureLike) => {
  const size = feature.get('features').length;

  return new Style({
    image: new CircleStyle({
      radius: 20,
      stroke: new Stroke({
        color: '#000',
      }),
      fill: new Fill({
        color: '#ecd14a',
      }),
    }),
    text: new Text({
      text: size.toString(),
      fill: new Fill({
        color: '#000',
      }),
      scale: 2,
    }),
  });
};

const createMaMarkerLayer = (
  markers: Feature[]
): VectorLayer<VectorSource> | VectorLayer<Cluster> => {
  let zoomLimit = 13;

  if (screenIsGreaterThanOrEqualTo('lg')) {
    zoomLimit = 11;
  }

  if (getZoom() < zoomLimit) {
    return new VectorLayer({
      properties: {
        name: 'markers',
      },
      source: new Cluster({
        distance: 60,
        minDistance: 30,
        source: new VectorSource({
          features: markers,
        }),
      }),
      style: (feature) => clusterStyle(feature),
    });
  }

  return new VectorLayer({
    properties: {
      name: 'markers',
    },
    source: new VectorSource({
      features: markers,
    }),
  });
};

const populateMap = (): void => {
  isLoading.value = true;
  clearMarkers();

  getPlaces()
    .then((eateries: EateryBrowseResource[]) => {
      const markers = eateries
        .map(
          (eatery) =>
            new Feature({
              id: eatery.key,
              geometry: new Point(fromLonLat(getEateryLatLng(eatery))),
            })
        )
        .map((eatery: Feature) => {
          eatery.setStyle(markerStyle());

          return eatery;
        });

      map.value.addLayer(createMaMarkerLayer(markers));
    })
    .finally(() => {
      isLoading.value = false;
    });
};

const zoomIntoCluster = (pixel: Pixel) => {
  getMarkersLayer()
    ?.getFeatures(pixel)
    .then((clickedFeatures) => {
      if (clickedFeatures.length > 0) {
        // Get clustered Coordinates
        const features = clickedFeatures[0].get('features');
        if (features.length > 0) {
          const extent = boundingExtent(
            features.map((r: Feature) => r.getGeometry())
          );

          map.value
            .getView()
            .fit(extent, { duration: 500, padding: [50, 50, 50, 50] });

          setTimeout(() => {
            if (getZoom() >= 18) {
              map.value.getView().setZoom(18);
            }
          }, 600);
        }
      }
    });
};

type CurrentFilter = { [T in 'category' | 'venueType' | 'feature']?: string[] };

const currentFilters = computed((): CurrentFilter | undefined => {
  if (!mapFilters.value) {
    return undefined;
  }

  const { categories, features, venueTypes }: EateryFilters = mapFilters.value;

  const filters: CurrentFilter = {};

  if (categories.filter((feature) => feature.checked).length > 0) {
    filters.category = categories
      .filter((feature) => feature.checked)
      .map((feature) => feature.value);
  }

  if (features.filter((feature) => feature.checked).length > 0) {
    filters.feature = features
      .filter((feature) => feature.checked)
      .map((feature) => feature.value);
  }

  if (venueTypes.filter((venueType) => venueType.checked).length > 0) {
    filters.venueType = venueTypes
      .filter((venueType) => venueType.checked)
      .map((venueType) => venueType.value);
  }

  return filters;
});

const updateUrl = (latLng?: LatLng, zoom?: number) => {
  if (!latLng) {
    latLng = getLatLng();
  }

  if (!zoom) {
    zoom = getZoom();
  }

  const paths = [`${latLng.lat},${latLng.lng}`, Math.round(zoom)];

  const queryStrings: { [T in keyof EateryFilters]: string | undefined } = {
    categories: currentFilters.value?.category
      ? currentFilters.value.category.join(',')
      : undefined,
    venueTypes: currentFilters.value?.venueType
      ? currentFilters.value.venueType.join(',')
      : undefined,
    features: currentFilters.value?.feature
      ? currentFilters.value.feature.join(',')
      : undefined,
  };

  const { baseUrl } = usePage<DefaultProps>().props.meta;

  const url = new URL(`${baseUrl}/wheretoeat/browse/${paths.join('/')}`);

  Object.keys(queryStrings).forEach((key) => {
    const value: string | undefined = queryStrings[key as keyof EateryFilters];

    if (!value) {
      return;
    }

    url.searchParams.set(key, value);
  });

  window.history.pushState(null, '', url);
};

const handleMapClick = (event: MapBrowserEvent<MouseEvent>) => {
  try {
    getMarkersLayer()
      ?.getFeatures(event.pixel)
      .then((feature) => {
        if (!feature.length) {
          return;
        }

        let zoomLimit = 13;

        if (screenIsGreaterThanOrEqualTo('lg')) {
          zoomLimit = 11;
        }

        if (getZoom() < zoomLimit) {
          // cluster view
          zoomIntoCluster(event.pixel);

          return;
        }

        const eatery = feature[0];

        // this.placeDetails = {};
        // this.getPlaceDetails(feature.get('id'));
        //
        // if (this.placeDetails === {}) {
        //   return;
        // }
        //
        // this.showSidebar = true;
      });
  } catch (e) {
    //
  }
};

const handleMapMove = () => {
  updateUrl();
  populateMap();
};

const handleFiltersChange = ({ filters }: { filters: EateryFilters }): void => {
  mapFilters.value = filters;

  handleMapMove();
};

const createMap = () => {
  map.value = new Map({
    layers: [
      new TileLayer({
        source: new OSM(),
      }),
    ],
    target: 'map',
    view: new View({
      center: initialLatLng.value,
      zoom: initialZoom.value,
    }),
  });

  map.value.on('moveend', handleMapMove);

  map.value.on('click', handleMapClick);

  map.value.on('pointermove', (event: MapBrowserEvent<MouseEvent>) => {
    if (event.dragging) {
      return;
    }

    map.value.getTargetElement().style.cursor = map.value.hasFeatureAtPixel(
      map.value.getEventPixel(event.originalEvent)
    )
      ? 'pointer'
      : '';
  });
};

const parseUrl = () => {
  const url = new URL(window.location.href);

  let paths = url.pathname.replace('/wheretoeat/browse', '');
  const queryStrings = url.searchParams;

  if (paths.charAt(0) === '/') {
    paths = paths.replace('/', '');
  }

  const [latLng, zoom] = paths.split('/');

  processedUrl.value.latLng = latLng;
  processedUrl.value.zoom = zoom;

  ['categories', 'venueTypes', 'features'].forEach((key) => {
    if (queryStrings.has(key)) {
      processedUrl.value[key as keyof EateryFilters] = queryStrings.get(
        key
      ) as string;
    }
  });
};

onMounted(async () => {
  parseUrl();

  createMap();

  populateMap();
});
</script>

<template>
  <div
    ref="wrapper"
    class="relative -mb-3 flex max-h-full min-h-[500px] flex-1 overflow-hidden"
  >
    <Loader
      class="z-50"
      size="w-16 h-16"
      width="border-8"
      :display="isLoading"
      background
    />

    <SearchMap />

    <FilterMap @filters-updated="handleFiltersChange($event)" />

    <div
      id="map"
      class="w-full"
    />
  </div>
</template>

<style>
.ol-zoom {
  left: auto;
  right: 0.5em;
  z-index: 50;
}
</style>
