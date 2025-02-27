import { computed, ComputedRef, Ref, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import useIntersect from '@/composables/useIntersect';
import { PaginatedResponse } from '@/types/GenericTypes';
import useBrowser from '@/composables/useBrowser';

export default <T>(propName: string, landmark: Ref<Element> | null = null) => {
  const value: () => PaginatedResponse<T> = () =>
    usePage().props[propName] as PaginatedResponse<T>;

  const items: Ref<T[]> = ref(value().data) as Ref<T[]>;

  const initialUrl = usePage().url;

  const canLoadMoreItems: ComputedRef<boolean> = computed(
    () => value().links.next !== null,
  );

  const { replaceHistory } = useBrowser();

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
        replace: true,
        onSuccess: () => {
          replaceHistory(initialUrl, null);

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
    loadMoreItems,
    reset: (): void => {
      items.value = value().data;
    },
    canLoadMoreItems,
  };
};
