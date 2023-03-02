<script setup lang="ts">
import Sidebar from '@/Components/Overlays/Sidebar.vue';
import { XMarkIcon } from '@heroicons/vue/20/solid';
import InputField from '@/Components/Forms/InputField.vue';
import { ref, watch } from 'vue';
import { BlogTagCount } from '@/types/BlogTypes';

const emits = defineEmits(['close', 'add-tag', 'remove-tag']);

const props = defineProps({
  open: {
    required: true,
    type: Boolean,
  },
  activeTags: {
    required: true,
    type: Array as () => BlogTagCount[],
  },
  totalBlogs: {
    required: true,
    type: Number,
  },
  tags: {
    required: true,
    type: Array as () => BlogTagCount[],
  },
});

const emitClose = () => emits('close');

const addTag = (tag: BlogTagCount) => emits('add-tag', tag);

const removeTag = (tag: BlogTagCount) => emits('remove-tag', tag);

const searchText = ref('');

const tagsToDisplay = (): BlogTagCount[] => {
  let tags = props.tags
    .filter((tag: BlogTagCount) => !props.activeTags.map((activeTag: BlogTagCount) => activeTag.slug).includes(tag.slug));

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

        <div v-if="activeTags.length">
          <ul class="flex flex-wrap gap-2 p-2">
            <li
              v-for="tag in activeTags"
              :key="tag.slug"
              class="flex"
            >
              <span
                class="bg-primary flex-1 rounded-l-md flex px-2 py-1 justify-center items-center"
                v-text="tag.tag"
              />
              <span
                class="bg-secondary rounded-r-md flex px-2 py-1 justify-center items-center cursor-pointer"
                @click="removeTag(tag)"
              >
                <XMarkIcon class="w-4" />
              </span>
            </li>
          </ul>
        </div>

        <div class="bg-primary-light/20 p-2">
          {{ totalBlogs }} Blogs shown
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
            class="flex justify-between items-center border-b border-dashed border-grey-off-dark py-2 hover:bg-grey-light transition cursor-pointer"
            @click="addTag(tag)"
          >
            <span v-text="tag.tag" />
            <span
              class="text-sm text-grey"
              v-text="`${tag.blogs_count} Blogs`"
            />
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
