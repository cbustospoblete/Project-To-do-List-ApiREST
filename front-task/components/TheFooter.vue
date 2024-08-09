<script setup lang="ts">
const links = [
  {
    label: "Nuxt UI",
    to: "https://ui.nuxt.com/",
  },
  {
    label: "Nuxt Docs",
    to: "https://nuxt.com",
  },
  {
    label: "Nuxt Studio",
    to: "https://nuxt.studio",
  },
];
</script>

<template>
  <UFooter :links="links">
    <template #left> Copyright © {{ new Date().getFullYear() }} </template>

    <template #right>
      <UButton
        icon="i-simple-icons-github"
        color="gray"
        variant="ghost"
        to="https://github.com/cbustospoblete/Project-To-do-List-ApiREST/tree/main"
        target="_blank"
      />
    </template>
  </UFooter>
</template>
