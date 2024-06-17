import { computed, ComputedRef, Ref, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import useIntersect from '@/composables/useIntersect';
import { PaginatedCollection } from '@/types/GenericTypes';

export default <T>(propName: string, landmark: Ref<Element> | null = null) => {
  const value: () => PaginatedCollection<T> = () =>
    usePage().props[propName] as PaginatedCollection<T>;

  const items: Ref<T[]> = ref(value().data) as Ref<T[]>;

  const initialUrl = ref(usePage().url);

  const canLoadMoreItems: ComputedRef<boolean> = computed(
    () => value().next_page_url !== null,
  );

  const pause: Ref<boolean> = ref(false);

  const refreshUrl = (url: string) => {
    initialUrl.value = url;
  };

  const loadMoreItems = (): void => {
    if (pause.value || !canLoadMoreItems.value) {
      return;
    }

    router.get(
      <string>value().next_page_url,
      {},
      {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
          window.history.replaceState(null, '', initialUrl.value);

          items.value = [...items.value, ...value().data];
        },
      },
    );
  };

  if (landmark !== null) {
    useIntersect(landmark, loadMoreItems, {
      rootMargin: '0px 0px 150px 0px',
    });
  }

  return {
    items,
    pause,
    refreshUrl,
    loadMoreItems,
    reset: (): void => {
      items.value = value().data;
    },
    canLoadMoreItems,
  };
};
