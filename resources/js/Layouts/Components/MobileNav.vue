<script setup lang="ts">
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

defineProps({
  open: {
    type: Boolean,
    required: true,
  },
});

const close = () => emit('close');

const links: { label: string, href: string }[] = [
  { label: 'Home', href: '/' },
  { label: 'Shop', href: '/' },
  { label: 'Gluten Free Travel Cards', href: '/' },
  { label: 'Blogs', href: '/' },
  { label: 'Eating Out', href: '/' },
  { label: 'Recipes', href: '/' },
  { label: 'Collections', href: '/' },
  { label: 'Info', href: '/' },
  { label: 'About Us', href: '/' },
  { label: 'FAQ', href: '/' },
  { label: 'Contact', href: '/' },
];
</script>

<template>
  <Sidebar
    :open="open"
    @close="close()"
  >
    <div class="bg-primary flex-1">
      <nav class="w-full pt-10">
        <ul class="text-2xl text-white text-center flex flex-col space-y-2">
          <li
            v-for="(link, index) in links"
            :key="index"
          >
            <Link
              :href="link.href"
              class="block w-full px-2"
            >
              {{ link.label }}
            </Link>
          </li>
        </ul>
      </nav>
    </div>
  </Sidebar>
</template>
