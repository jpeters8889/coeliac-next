import { computed, ComputedRef, Ref, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import useIntersect from '@/composables/useIntersect';
import { PaginatedResponse } from '@/types/GenericTypes';

export default <T>(propName: string, landmark: Ref<Element> | null = null) => {
  // @ts-ignore
  const value: () => PaginatedResponse<T> = () => usePage().props[propName];

  // @ts-ignore
  const items: Ref<T[]> = ref(value().data);

  const initialUrl = usePage().url;

  const canLoadMoreItems: ComputedRef<boolean> = computed(
    () => value().links.next !== null
  );

  const loadMoreItems = (): void => {
    if (!canLoadMoreItems.value) {
      return;
    }

    router.get(
      <string>value().links.next,
      {},
      {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          window.history.replaceState({}, '', initialUrl);

          items.value = [...items.value, ...value().data];
        },
      }
    );
  };

  if (landmark !== null) {
    useIntersect(landmark, loadMoreItems, {
      rootMargin: '0px 0px 150px 0px',
    });
  }

  return {
    items,
    loadMoreItems,
    reset: (): void => {
      items.value = value().data;
    },
    canLoadMoreItems,
  };
};
