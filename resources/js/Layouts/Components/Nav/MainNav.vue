<script setup lang="ts">
import NavItem from '@/Layouts/Components/Nav/NavItem.vue';
</script>

<template>
  <div class="mx-auto hidden w-full max-w-7xl md:flex md:items-center md:justify-center h-14">
    <nav
      class="flex h-full text-lg"
    >
      <NavItem
        label="Shop"
        href="/shop"
      />

      <NavItem
        label="Blogs"
        href="/blog"
      />

      <NavItem
        label="Eating Out"
        href="eating-out"
      />

      <NavItem
        label="Recipes"
        href="/recipe"
      />

      <NavItem
        label="Collections"
        href="/collection"
      />
    </nav>
  </div>
</template>
