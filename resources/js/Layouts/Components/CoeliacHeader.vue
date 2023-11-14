<script setup lang="ts">
import {
  Bars3BottomLeftIcon,
  MagnifyingGlassIcon,
} from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import MobileNav from '@/Layouts/Components/Nav/MobileNav.vue';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MainNav from '@/Layouts/Components/Nav/MainNav.vue';
import Sealic from '@/Svg/Sealic.vue';
import { Link } from '@inertiajs/vue3';
import InputField from '@/Components/Forms/RawInputField.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';

const mobileNavOpen = ref(false);
</script>

<template>
  <CoeliacMetas />

  <div class="relative bg-primary shadow-lg">
    <div
      id="header"
      class="relative z-20"
    >
      <div
        class="mx-auto flex w-full max-w-8xl items-center justify-between px-2"
      >
        <div class="md:hidden">
          <a
            class="flex items-center justify-center rounded-md text-white/80 hover:text-white"
          >
            <Bars3BottomLeftIcon
              class="h-10 w-10"
              @click="mobileNavOpen = true"
            />
          </a>
        </div>

        <Link
          class="my-2 flex h-[6.5rem] flex-1 flex-col items-center xs:flex-row xs:justify-center md:my-4 md:ml-2 md:justify-start"
          href="/"
        >
          <Sealic class="-mb-3 xs:mb-0 xs:h-20 md:h-24" />

          <div class="flex flex-col">
            <h1
              class="mt-2 text-center font-coeliac text-xl xs:ml-2 xs:mt-0 xs:text-left xs:text-3xl md:text-4xl"
            >
              Coeliac Sanctuary
            </h1>
            <span class="text-center font-coeliac text-xs md:text-base">
              Gluten Free Blog by Alison Peters
            </span>
          </div>
        </Link>

        <div class="md:w-full md:max-w-xs">
          <div class="h-14 w-14 p-2 md:hidden">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-full bg-secondary"
            >
              <MagnifyingGlassIcon class="h-6 w-6" />
            </div>
          </div>

          <div class="hidden flex-col md:flex">
            <div
              class="flex items-center rounded-xl bg-white bg-opacity-50 pr-2 transition focus-within:bg-opacity-90"
            >
              <InputField
                type="search"
                name="search"
                model-value=""
                :background="false"
                placeholder="Search..."
              />

              <MagnifyingGlassIcon class="h-6 w-6" />
            </div>

            <div class="mt-2 flex justify-end space-x-2">
              <CoeliacButton
                label="Register"
                theme="secondary"
                size="sm"
                href="/register"
              />
              <CoeliacButton
                label="Login"
                theme="light"
                size="sm"
                href="/login"
              />
            </div>
          </div>
        </div>
      </div>

      <div
        class="mx-auto hidden h-px w-4/5 bg-gradient-to-r from-white/20 via-white/40 to-white/20 md:block"
      />

      <MainNav />
    </div>

    <MobileNav
      :open="mobileNavOpen"
      @close="mobileNavOpen = false"
    />
  </div>
</template>
