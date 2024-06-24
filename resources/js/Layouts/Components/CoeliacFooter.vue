<script lang="ts" setup>
import FacebookIcon from '@/Icons/FacebookIcon.vue';
import TwitterIcon from '@/Icons/TwitterIcon.vue';
import InstagramIcon from '@/Icons/InstagramIcon.vue';
import CoeliacButton from '@/Components/CoeliacButton.vue';
import FormInput from '@/Components/Forms/FormInput.vue';

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
    <div class="mx-auto max-w-8xl p-4 lg:grid lg:grid-cols-4 lg:gap-x-4">
      <!-- Tagline -->
      <div class="mb-4">
        <h2 class="mb-2 text-xl font-semibold">Coeliac Sanctuary</h2>
        <p>
          Coeliac Sanctuary, more than a gluten free blog, find gluten free,
          coeliac safe places to eat, gluten free recipes, blogs, reviews, buy
          coeliac travel cards and more!
        </p>
      </div>

      <div class="sm:grid sm:grid-cols-3 lg:col-span-3 lg:gap-2">
        <!-- Links -->
        <ul class="grid grid-cols-2 gap-2">
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

        <!-- Newsletter -->
        <div class="mt-10 sm:col-span-2 sm:mt-0">
          <h3 class="mb-2 text-xl font-semibold">
            Subscribe to our newsletter
          </h3>
          <p>
            Enter your email address below to get our newsletter sent straight
            to your inbox!
          </p>
          <form class="mt-6 sm:flex sm:items-center">
            <FormInput
              id="email-address"
              label=""
              hide-label
              autocomplete="email"
              name="email-address"
              placeholder="Enter your email address..."
              required
              type="email"
              class="flex-1"
            />
            <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
              <CoeliacButton
                as="button"
                classes="w-full justify-center"
                label="Subscribe"
                theme="secondary"
                type="submit"
              />
            </div>
          </form>
        </div>
      </div>

      <div
        class="mt-4 sm:mt-8 sm:flex sm:flex-row-reverse sm:items-center sm:justify-between lg:col-span-4"
      >
        <div class="flex items-center justify-center space-x-3">
          <a
            href="https://www.facebook.com/coeliacsanctuary/"
            target="_blank"
          >
            <FacebookIcon />
          </a>
          <a
            href="https://twitter.com/coeliacsanc"
            target="_blank"
          >
            <TwitterIcon />
          </a>
          <a
            href="https://www.instagram.com/coeliacsanctuary"
            target="_blank"
          >
            <InstagramIcon />
          </a>
        </div>
        <p class="mt-8 text-center text-xs leading-5 sm:mt-0 sm:text-left">
          Copyright &copy; 2014 - {{ year }} Coeliac Sanctuary.
        </p>
      </div>
    </div>
  </footer>
</template>
