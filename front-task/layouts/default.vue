<script setup lang="ts"></script>

<template>
  <div class="flex flex-col min-h-screen">
    <TheHeader />
    <main class="flex-1">
      <slot />
    </main>
    <TheFooter />
  </div>
</template>
