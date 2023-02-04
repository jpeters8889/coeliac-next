<script setup lang="ts">
import { defineComponent, h } from 'vue';
import FacebookIcon from '@/Icons/FacebookIcon.vue';
import TwitterIcon from '@/Icons/TwitterIcon.vue';
import InstagramIcon from '@/Icons/InstagramIcon.vue';

const year = new Date().getFullYear();

const navigation: { links: { label: string, url: string }[] } = {
  links: [
    { label: 'Shop', url: '/shop' },
    { label: 'Blogs', url: '/blogs' },
    { label: 'Eating Out', url: '/eating-out' },
    { label: 'Recipes', url: '/recipes' },
    { label: 'Contact', url: '/contact' },
    { label: 'Terms', url: '/contact' },
    { label: 'Privacy', url: '/contact' },
    { label: 'Work with Us', url: '/contact' },
  ],
};
</script>

<template>
  <footer class="bg-primary">
    <div class="mx-auto max-w-7xl p-4">
      <!-- Tagline -->
      <div class="mb-4">
        <h2 class="font-semibold text-xl mb-2">
          Coeliac Sanctuary
        </h2>
        <p>
          Coeliac Sanctuary, more than a gluten free blog, find gluten free, coeliac safe places to eat,
          gluten free recipes, blogs, reviews, buy coeliac travel cards and more!
        </p>
      </div>

      <div class="sm:grid sm:grid-cols-3 xl:grid-cols-3 xl:gap-8">
        <!-- Links -->
        <ul class="grid grid-cols-2 gap-2">
          <li
            v-for="item in navigation.links"
            :key="item.label"
          >
            <a
              :href="item.url"
              class="leading-6 hover:text-gray-900"
            >{{ item.label }}</a>
          </li>
        </ul>

        <!-- Newsletter -->
        <div class="mt-10 sm:mt-0 sm:col-span-2">
          <h3 class="font-semibold leading-6 text-gray-900">
            Subscribe to our newsletter
          </h3>
          <p class="mt-2 text-sm leading-6 text-gray-600">
            Enter your email address below to get our newsletter sent straight to your inbox!
          </p>
          <form class="mt-6 sm:flex sm:max-w-md">
            <label
              for="email-address"
              class="sr-only"
            >Email address</label>
            <input
              id="email-address"
              type="email"
              name="email-address"
              autocomplete="email"
              required=""
              class="w-full min-w-0 appearance-none rounded-md border-gray-300 bg-white px-[calc(theme(spacing.3)-1px)] py-[calc(theme(spacing[1.5])-1px)] text-base leading-7 text-gray-900 placeholder-gray-400 shadow-sm focus:border-indigo-600 focus:ring-indigo-600 sm:w-64 sm:text-sm sm:leading-6 xl:w-full"
              placeholder="Enter your email"
            >
            <div class="mt-4 sm:mt-0 sm:ml-4 sm:flex-shrink-0">
              <button
                type="submit"
                class="flex w-full items-center justify-center rounded-md bg-indigo-600 py-1.5 px-3 text-base font-semibold leading-7 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm sm:leading-6"
              >
                Subscribe
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="mt-4 sm:flex sm:flex-row-reverse sm:items-center sm:justify-between sm:mt-8">
        <div class="flex items-center justify-center space-x-3">
          <a href="#">
            <FacebookIcon />
          </a>
          <a href="#">
            <TwitterIcon />
          </a>
          <a href="#">
            <InstagramIcon />
          </a>
        </div>
        <p class="mt-8 text-xs text-center leading-5 sm:mt-0 sm:text-left">
          Copyright &copy; 2014 - {{ year }} Coeliac Sanctuary.
        </p>
      </div>
    </div>
  </footer>
</template>
