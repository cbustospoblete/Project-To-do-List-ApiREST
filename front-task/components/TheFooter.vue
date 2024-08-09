<script setup lang="ts">
// Define los enlaces de navegación que se mostrarán en el encabezado. Cada enlace tiene una etiqueta, un ícono y una ruta.
const links = [
  {
    label: "Nuxt UI",
    to: "https://ui.nuxt.com/",
    target: "_blank",
  },
  {
    label: "Nuxt Docs",
    to: "https://nuxt.com",
    target: "_blank",
  },
  {
    label: "Vue Date Picker",
    to: "https://vue3datepicker.com/",
    target: "_blank",
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
