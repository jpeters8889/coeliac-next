import './bootstrap';
import '../css/app.css';
import { createApp, DefineComponent, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import Coeliac from '@/Layouts/Coeliac.vue';
import ArticleHeader from '@/Components/ArticleHeader.vue';
import ArticleImage from '@/Components/ArticleImage.vue';
import vClickOutside from 'v-click-outside';

const appName = 'Coeliac Sanctuary';

createInertiaApp({
  title: (title) =>
    title
      ? `${title} - ${appName}`
      : 'Coeliac Sanctuary - Coeliac Blog, Gluten Free Places to Eat, Reviews, and more!',

  progress: {
    color: '#4B5563',
  },

  resolve: (name) => {
    const pages: { [T: string]: DefineComponent } = import.meta.glob(
      './Pages/**/*.vue',
      { eager: true }
    );
    const page: DefineComponent = pages[`./Pages/${name}.vue`];

    page.default.layout = page.default.layout || Coeliac;

    return page;
  },

  setup({ el, App, props, plugin }) {
    const pinia = createPinia();

    createApp({ render: () => h(App, props) })
      .component('article-header', ArticleHeader)
      .component('article-image', ArticleImage)
      .use(plugin)
      .use(pinia)
      .use(vClickOutside)
      .mount(el);
  },
});
