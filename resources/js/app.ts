import './bootstrap';
import '../css/app.css';
import { Component, createApp, h, Plugin } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import Coeliac from '@/Layouts/Coeliac.vue';
import ArticleHeader from '@/Components/ArticleHeader.vue';
import ArticleImage from '@/Components/ArticleImage.vue';
import vClickOutside from 'v-click-outside';
import { InertiaPage } from '@/types/Core';

const appName = 'Coeliac Sanctuary';

void createInertiaApp({
  title: (title) =>
    title
      ? `${title} - ${appName}`
      : 'Coeliac Sanctuary - Coeliac Blog, Gluten Free Places to Eat, Reviews, and more!',

  progress: {
    color: '#4B5563',
  },

  resolve: (name) => {
    const pages: { [T: string]: InertiaPage } = import.meta.glob(
      './Pages/**/*.vue',
      { eager: true },
    );

    const page: InertiaPage = pages[`./Pages/${name}.vue`];

    page.default.layout = page.default.layout || (Coeliac as Component);

    return page;
  },

  setup({ el, App, props, plugin }) {
    const pinia = createPinia();

    createApp({ render: () => h(App, props) })
      .component('article-header', ArticleHeader as Component)
      .component('article-image', ArticleImage as Component)
      .use(plugin)
      .use(pinia)
      .use(vClickOutside as Plugin)
      .mount(el);
  },
});
