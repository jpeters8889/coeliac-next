<script setup lang="ts">
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import InputField from '@/Components/Forms/InputField.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { BlogTagCount } from '@/types/BlogTypes';

const emits = defineEmits(['close']);

const props = defineProps({
  open: {
    required: true,
    type: Boolean,
  },
  tags: {
    required: true,
    type: Array as () => BlogTagCount[],
  },
});

const emitClose = () => emits('close');

const searchText = ref('');

const tagsToDisplay = (): BlogTagCount[] => {
  let { tags } = props;

  if (searchText.value !== '') {
    tags = tags.filter((tag) => tag.tag.toLowerCase().includes(searchText.value.toLowerCase()));
  }

  return tags.slice(0, 15);
};

</script>

<template>
  <Sidebar
    :open="open"
    side="right"
    @close="emitClose()"
  >
    <div class="bg-white flex-1">
      <div class="flex flex-col">
        <div class="bg-grey-light p-2 border-b border-grey-off-light">
          <h3 class="text-xl font-semibold">
            Blog Tags
          </h3>
        </div>

        <div class="p-2">
          <InputField
            v-model="searchText"
            name="search"
            type="search"
            placeholder="Search Tags"
            borders
          />
        </div>

        <ul
          v-if="tagsToDisplay().length"
          class="flex flex-col px-3"
        >
          <li
            v-for="tag in tagsToDisplay()"
            :key="tag.slug"
          >
            <Link
              class="flex justify-between items-center border-b border-dashed border-grey-off-dark py-2 hover:bg-grey-light transition cursor-pointer"
              :href="`/blog/tags/${tag.slug}`"
            >
              <span v-text="tag.tag" />
              <span
                class="text-sm text-grey"
                v-text="`${tag.blogs_count} Blogs`"
              />
            </Link>
          </li>
        </ul>

        <span
          v-else
          class="px-3 font-italic"
          v-text="'No tags found...'"
        />
      </div>
    </div>
  </Sidebar>
</template>
