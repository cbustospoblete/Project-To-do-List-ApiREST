<script setup lang="ts">
const { data } = await useFetch("http://localhost:8000/api/tasks");

// Mapea los datos a un formato simple
const tasks = data.value.map((task: any) => ({
  id: task.id,
  name: task.name,
  description: task.description,
}));
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
    key: "action",
    label: "Action",
  },
];
const page = ref(1);
const pageCount = 12;

const paginable = computed(() => {
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
