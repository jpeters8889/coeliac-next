<script lang="ts" setup>
import FacebookIcon from '@/Icons/FacebookIcon.vue';
import TwitterIcon from '@/Icons/TwitterIcon.vue';
import InstagramIcon from '@/Icons/InstagramIcon.vue';

const year = new Date().getFullYear();

const navigation: { links: { label: string; url: string }[] } = {
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
    <div class="mx-auto max-w-8xl">
      <p class="mx-auto my-2 text-center text-xs leading-5">
        Copyright &copy; 2014 - {{ year }} Coeliac Sanctuary.
      </p>

      <div
        class="flex w-full flex-col items-center justify-center p-4 pt-0 sm:flex-row sm:justify-between"
      >
        <!-- Links -->
        <ul class="flex flex-wrap gap-3">
          <li
            v-for="item in navigation.links"
            :key="item.label"
          >
            <a
              :href="item.url"
              class="leading-6 hover:text-gray-900"
              >{{ item.label }}</a
            >
          </li>
        </ul>

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
      </div>
    </div>
  </footer>
</template>
