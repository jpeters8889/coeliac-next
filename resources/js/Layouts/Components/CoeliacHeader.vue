<script setup lang="ts">
import { Bars3BottomLeftIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import MobileNav from '@/Layouts/Components/Nav/MobileNav.vue';
import CoeliacMetas from '@/Layouts/Components/CoeliacMetas.vue';
import MainNav from '@/Layouts/Components/Nav/MainNav.vue';
import Sealic from '@/Svg/Sealic.vue';
import { Link } from '@inertiajs/vue3';
import InputField from '@/Components/Forms/InputField.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';

const mobileNavOpen = ref(false);

</script>

<template>
  <CoeliacMetas />

  <div class="relative bg-primary shadow-lg">
    <div class="relative z-20">
      <div class="w-full mx-auto flex max-w-7xl items-center justify-between px-2">
        <div class="md:hidden">
          <a class=" flex items-center justify-center rounded-md text-white/80 hover:text-white">
            <Bars3BottomLeftIcon
              class="h-10 w-10"
              @click="mobileNavOpen = true"
            />
          </a>
        </div>

        <Link
          class="flex flex-col xs:flex-row flex-1 h-24 my-2 md:my-4 md:ml-2 items-center xs:justify-center md:justify-start"
          href="/"
        >
          <Sealic class="xs:h-20 md:h-24" />

          <div class="flex flex-col">
            <h1 class="text-center mt-2 xs:text-left xs:mt-0 xs:ml-2 text-xl xs:text-3xl md:text-4xl font-coeliac">
              Coeliac Sanctuary
            </h1>
            <span class="text-xs text-center font-coeliac md:text-base">
              Gluten Free Blog by Alison Peters
            </span>
          </div>
        </Link>

        <div class="md:w-full md:max-w-xs">
          <div class="p-2 w-14 h-14 md:hidden">
            <div class="bg-secondary rounded-full w-10 h-10 flex justify-center items-center">
              <MagnifyingGlassIcon class="w-6 h-6" />
            </div>
          </div>

          <div class="hidden md:flex flex-col">
            <div class="flex bg-white bg-opacity-50 rounded-xl items-center pr-2 focus-within:bg-opacity-90 transition">
              <InputField
                type="search"
                name="search"
                model-value=""
                :background="false"
                placeholder="Search..."
              />

              <MagnifyingGlassIcon class="w-6 h-6" />
            </div>

            <div class="flex justify-end space-x-2 mt-2">
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

      <div class="hidden md:block w-4/5 mx-auto h-px bg-gradient-to-r from-white/20 via-white/40 to-white/20" />

      <MainNav />
    </div>

    <MobileNav
      :open="mobileNavOpen"
      @close="mobileNavOpen = false"
    />
  </div>
</template>
