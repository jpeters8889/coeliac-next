<script setup lang="ts">
import NavItem from '@/Layouts/Components/Nav/NavItem.vue';
import { onMounted, ref } from 'vue';

const isSticky = ref(false);

onMounted(() => {
  new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      isSticky.value = !entry.isIntersecting;
    });
  }, {
    threshold: 0.5,
    rootMargin: '0px',
  }).observe(document.getElementById('header'));
});
</script>

<template>
  <div
    id="main-nav"
    class="mx-auto hidden w-full max-w-7xl md:flex md:items-center md:justify-center"
    :class="{
      'fixed bg-primary top-0 h-10': isSticky,
      'h-14': !isSticky,
    }"
  >
    <nav
      class="flex h-full text-lg"
    >
      <NavItem
        v-if="isSticky"
        label="Home"
        href="/"
        :active="$page.component === 'Home'"
      />

      <NavItem
        label="Shop"
        href="/shop"
        :active="$page.url.startsWith('/shop')"
      />

      <NavItem
        label="Blogs"
        href="/blog"
        :active="$page.url.startsWith('/blog')"
      />

      <NavItem
        label="Eating Out"
        href="eating-out"
      />

      <NavItem
        label="Recipes"
        href="/recipe"
        :active="$page.url.startsWith('/recipe')"
      />

      <NavItem
        label="Collections"
        href="/collection"
      />
    </nav>
  </div>
</template>
