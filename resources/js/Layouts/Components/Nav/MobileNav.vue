<script lang="ts" setup>
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

defineProps<{ open: boolean }>();

const close = () => emit('close');

const links: { label: string; href: string }[] = [
  { label: 'Home', href: '/' },
  { label: 'Shop', href: '/shop' },
  { label: 'Gluten Free Travel Cards', href: '/' },
  { label: 'Blogs', href: '/blog' },
  { label: 'Eating Out', href: '/eating-out' },
  { label: 'Recipes', href: '/recipe' },
  { label: 'Collections', href: '/collection' },
  { label: 'About Us', href: '/' },
  { label: 'FAQ', href: '/' },
  { label: 'Work With Us', href: '/work-with-us' },
  { label: 'Contact', href: '/' },
];
</script>

<template>
  <Sidebar
    :open="open"
    side="right"
    @close="close()"
  >
    <div class="flex-1 bg-primary">
      <nav class="w-full pt-10">
        <ul class="flex flex-col space-y-2 text-center text-2xl text-white">
          <li
            v-for="(link, index) in links"
            :key="index"
          >
            <Link
              :href="link.href"
              class="block w-full px-2"
              @click="close()"
            >
              {{ link.label }}
            </Link>
          </li>
        </ul>
      </nav>
    </div>
  </Sidebar>
</template>
