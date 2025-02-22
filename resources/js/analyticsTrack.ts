import { Page } from '@inertiajs/core';
import { router } from '@inertiajs/vue3';
import { getTitle } from '@/helpers';

export default () => {
  type Event = { detail: { page: Page<{ meta?: { title?: string } }> } };

  /** @ts-ignore */
  router.on('navigate', (event: Event) => {
    if (typeof window === 'undefined') {
      return;
    }

    window.gtag('event', 'page_view', {
      page_location: event.detail.page.url,
      page_title: getTitle(event.detail.page.props?.meta?.title),
    });
  });
};
