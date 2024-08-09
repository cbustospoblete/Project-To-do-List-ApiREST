<template>
  <!-- Contenedor principal que ocupa toda la altura de la pantalla -->
  <div class="flex flex-col min-h-screen">
    <!-- Encabezado de la página -->
    <TheHeader />
    <!-- Contenido principal que se ajusta al espacio disponible -->
    <main class="flex-1">
      <!-- Contenido inyectado en el componente (slot) -->
      <slot />
    </main>
    <!-- Pie de página -->
    <TheFooter />
  </div>
</template>
