<script setup lang="ts">
const { data } = await useFetch("http://localhost:8000/api/tasks");
// Obtiene datos de la API y los almacena en `data`.

const tasks = data.value.map((task: any) => ({
  id: task.id,
  name: task.name,
  description: task.description,
  due_date: task.due_date,
  status: task.status,
}));
// Mapea los datos a un formato más simple con las propiedades necesarias.
const columns = [
  {
    key: "id",
    label: "ID",
  },
  {
    key: "name",
    label: "Name",
    sortable: true,
  },
  {
    key: "description",
    label: "Description",
    sortable: true,
  },
  {
    key: "due_date",
    label: "Due date",
    sortable: true,
  },
  {
    key: "status",
    label: "Status",
    sortable: true,
  },
  {
    key: "action",
    label: "Action",
  },
];
// Define las columnas de la tabla y su configuración (sortable para algunas).

const page = ref(1);
// Define la página actual en la paginación.

const pageCount = 12;
// Número de elementos por página.

const paginable = computed(() => {
  // Calcula las tareas a mostrar en la página actual.
  return tasks.slice((page.value - 1) * pageCount, page.value * pageCount);
});
</script>

<template>
  <div class="flex flex-col items-center min-h-screen pt-12">
    <div class="w-full max-w-7xl">
      <UTable :columns="columns" :rows="paginable" class="mb-4" />
      <div
        class="flex justify-end px-3 py-3.5 border-t border-gray-200 dark:border-gray-700"
      >
        <UPagination
          v-model="page"
          :page-count="pageCount"
          :total="tasks.length"
        />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
