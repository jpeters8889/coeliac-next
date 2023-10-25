<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { DefaultProps, MetaProps } from '@/types/DefaultProps';

const metas: MetaProps = (<DefaultProps>usePage().props).meta as MetaProps;
</script>

<template>
  <Head>
    <title>{{ metas.title }}</title>

    <meta
      name="description"
      :content="metas.description"
    />
    <meta
      name="keywords"
      :content="metas.tags.join(', ')"
    />

    <!--        <link rel="canonical" href="{{ $page->url }}"/>-->

    <meta
      property="og:type"
      content="article"
    />
    <meta
      property="og:locale"
      content="en_GB"
    />
    <meta
      property="og:site_name"
      content="Coeliac Sanctuary"
    />
    <meta
      property="og:description"
      :content="metas.description"
    />
    <meta
      property="og:title"
      :content="metas.title"
    />
    <meta
      property="og:image"
      :content="metas.image"
    />
    <meta
      property="og:image:type"
      content="image/jpeg"
    />
    <meta
      property="og:url"
      content=""
    />

    <meta
      name="twitter:card"
      content="summary_large_image"
    />
    <meta
      name="twitter:description"
      :content="metas.description"
    />
    <meta
      name="twitter:title"
      :content="metas.title"
    />
    <meta
      name="twitter:site"
      content="@coeliacsanc"
    />
    <meta
      name="twitter:domain"
      content="Coeliac Sanctuary"
    />
    <meta
      name="twitter:image:src"
      :content="metas.image"
    />
    <meta
      name="twitter:creator"
      content="@coeliacsanc"
    />

    <template v-if="metas.alternateMetas">
      <meta
        v-for="(content, property) in metas.alternateMetas"
        :key="property"
        :property="property"
        :content="content"
      />
    </template>

    <template v-if="metas.schema">
      {{ metas.schema }}
    </template>

    <meta
      v-if="metas.doNotTrack"
      name="”robots”"
      content="”noindex”"
    />
  </Head>
</template>
