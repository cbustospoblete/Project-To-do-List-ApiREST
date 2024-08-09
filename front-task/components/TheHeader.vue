<script setup lang="ts">
// Define los enlaces de navegación que se mostrarán en el encabezado. Cada enlace tiene una etiqueta, un ícono y una ruta.
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
</script>

<template>
  <UHeader>
    <template #left>
      <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-200">
        To-do List
      </h1>
    </template>
    <template #center>
      <div class="flex justify-center md:justify-start">
        <UNavigationTree :links="links" />
      </div>
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
  </UHeader>
</template>
