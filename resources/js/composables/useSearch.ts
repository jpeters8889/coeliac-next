import { ref } from 'vue';
import { InertiaForm } from '@/types/Core';
import { useForm } from 'laravel-precognition-vue-inertia';
import { SearchParams } from '@/types/Search';
import { VisitOptions } from '@inertiajs/core';

export default () => {
  const latLng = ref<null | [string, string]>(null);
  const hasError = ref(false);

  navigator.geolocation.getCurrentPosition(
    (position) => {
      latLng.value = [
        position.coords.latitude.toString(),
        position.coords.longitude.toString(),
      ];
    },
    () => {
      //
    },
  );

  const searchForm: InertiaForm<SearchParams> = useForm('get', '/search', {
    q: '',
    blogs: true,
    recipes: true,
    eateries: false,
    shop: true,
  }) as InertiaForm<SearchParams>;

  const submitSearch = (options: Partial<VisitOptions> = {}) => {
    hasError.value = false;

    if (searchForm.q.length < 3) {
      hasError.value = true;

      return;
    }

    if (latLng.value) {
      options = {
        ...options,
        headers: {
          'x-search-location': latLng.value.join(),
        },
      };
    }

    searchForm.submit(options);
  };

  return { hasError, searchForm, submitSearch };
};
