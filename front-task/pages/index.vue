<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

// Propiedad reactiva para el texto de búsqueda
const searchQuery = ref("");

// Página actual
const page = ref(1);

// Tamaño de la página
const pageSize = 10;

// Obtiene los datos de tareas desde el API
const { data } = await useFetch("http://localhost:8000/api/tasks");

// Mapea los datos recibidos a un formato de tarea
const tasks = data.value.map((task: any) => ({
  id: task.id,
  name: task.name,
  description: task.description,
  due_date: task.due_date,
  status: task.status,
}));

// Filtra las tareas según el texto de búsqueda
const filteredTasks = computed(() => {
  if (!searchQuery.value) return tasks; // Si no hay búsqueda, mostrar todas las tareas
  return tasks.filter(
    (task) =>
      task.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      task.description?.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Calcula el número total de páginas basándose en las tareas filtradas
const totalPageCount = computed(() =>
  Math.ceil(filteredTasks.value.length / pageSize)
);

// Devuelve las tareas que deben mostrarse en la página actual
const paginableTasks = computed(() => {
  return filteredTasks.value.slice(
    (page.value - 1) * pageSize,
    page.value * pageSize
  );
});

// Navega a la página de detalles de una tarea específica
const goToTask = (id: string) => {
  router.push(`/${id}`);
};

// Observa los cambios en el texto de búsqueda y reinicia la página actual a 1
watch(searchQuery, () => {
  page.value = 1;
});

// Definición de columnas para la tabla
const columns = [
  { key: "id", label: "ID" },
  { key: "name", label: "Name", sortable: true },
  { key: "description", label: "Description", sortable: true },
  { key: "due_date", label: "Due date", sortable: true },
  { key: "status", label: "Status", sortable: true },
  { key: "actions", label: "Action" }, // Asegúrate de incluir esta columna
];
</script>

<template>
  <div class="flex flex-col items-center min-h-screen pt-12">
    <div class="w-full max-w-7xl">
      <UInput
        v-model="searchQuery"
        color="primary"
        variant="outline"
        placeholder="Search..."
      />
      <UTable :columns="columns" :rows="paginableTasks" class="mb-4">
        <!-- Template para el estado (status) con clases condicionales -->
        <template #status-data="{ row }">
          <span
            :class="{
              'text-red-600': row.status === 'overdue',
              'text-yellow-500': row.status === 'pending',
              'text-green-600': row.status === 'completed',
            }"
          >
            {{ row.status }}
          </span>
        </template>

        <!-- Columna de acciones -->
        <template #actions-data="{ row }">
          <UButton
            color="gray"
            variant="ghost"
            icon="i-heroicons-ellipsis-horizontal-20-solid"
            @click="goToTask(row.id)"
          />
        </template>
      </UTable>
      <div
        class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
      >
        <UPagination
          v-model="page"
          :page-count="totalPageCount"
          :total="filteredTasks.length"
          @page-change="(newPage) => (page.value = newPage)"
        />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
