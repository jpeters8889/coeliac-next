<script setup lang="ts">
import { PopoverGroup } from '@headlessui/vue';
import NavItem from '@/Layouts/Components/Nav/NavItem.vue';
import { usePage } from '@inertiajs/vue3';
import { DefaultProps } from '@/types/DefaultProps';

const { navigation } = <DefaultProps>usePage().props;

</script>

<template>
  <div class="hidden xmd:flex xmd:flex-1 xmd:items-center xmd:justify-between h-14">
    <PopoverGroup
      as="nav"
      class="flex h-full text-lg"
    >
      <NavItem
        label="Shop"
        has-dropdown
      />

      <NavItem
        label="Blogs"
        has-dropdown
        :items="navigation.blogs"
        view-more="See all Blogs"
        view-more-link="/blogs"
      />

      <NavItem
        label="Eating Out"
        has-dropdown
      />

      <NavItem
        label="Recipes"
        has-dropdown
      />

      <NavItem
        label="Collections"
        has-dropdown
      />
    </popovergroup>
  </div>
</template>
