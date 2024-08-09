<script setup lang="ts">
import type { NavItem } from "@nuxt/content";

const navigation = inject<Ref<NavItem[]>>("navigation", ref([]));

const links = [
  {
    label: "Home",
    icon: "i-heroicons-book-open",
    to: "/",
  },
  {
    label: "Create Task",
    icon: "i-heroicons-square-3-stack-3d",
    to: "/create",
  },
];
function mapContentNavigation(navigation: Ref<NavItem[]>): NavItem[] {
  return navigation.value; // Ajusta esta función según tus necesidades
}
</script>

<template>
  <UHeader :links="links">
    <template #left>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200">
        To-do List
      </h1>
    </template>
    <template #right>
      <UColorModeButton />

      <UButton
        to="https://github.com/cbustospoblete/Project-To-do-List-ApiREST/tree/main"
        target="_blank"
        icon="i-simple-icons-github"
        color="gray"
        variant="ghost"
      />
    </template>

    <template #panel>
      <UNavigationTree :links="mapContentNavigation(navigation)" />
    </template>
  </UHeader>
</template>

<style>
.nuxt-ui-pro-text {
  display: none;
}
</style>
