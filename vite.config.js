import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
      'tailwind.config.js': path.resolve(__dirname, 'tailwind.config.ts'),
    },
  },
  plugins: [
    laravel({
      input: 'resources/js/app.ts',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  optimizeDeps: {
    include: ['tailwind.config.ts'],
  },
  build: {
    commonjsOptions: {
      include: ['tailwind.config.ts', 'node_modules/**'],
    },
  },
});
