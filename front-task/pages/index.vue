<script setup lang="ts">
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useFetch } from "#app";

const { data } = await useFetch("http://localhost:8000/api/tasks");

const router = useRouter();
const tasks = data.value.map((task: any) => ({
  id: task.id,
  name: task.name,
  description: task.description,
  due_date: task.due_date,
  status: task.status,
}));

const columns = [
  { key: "id", label: "ID" },
  { key: "name", label: "Name", sortable: true },
  { key: "description", label: "Description", sortable: true },
  { key: "due_date", label: "Due date", sortable: true },
  { key: "status", label: "Status", sortable: true },
  { key: "actions", label: "Action" },
];

const page = ref(1);
const pageCount = 12;

const paginable = computed(() => {
  return tasks.slice((page.value - 1) * pageCount, page.value * pageCount);
});

const goToTask = (id: string) => {
  router.push(`/${id}`);
};
</script>

<template>
  <div class="flex flex-col items-center min-h-screen pt-12">
    <div class="w-full max-w-7xl">
      <UTable :columns="columns" :rows="paginable" class="mb-4">
        <template #actions-data="{ row }">
          <UTooltip text="Ver" :popper="{ placement: 'left' }">
            <UButton
              color="gray"
              variant="ghost"
              icon="i-heroicons-ellipsis-horizontal-20-solid"
              @click="goToTask(row.id)"
            />
          </UTooltip>
        </template>
      </UTable>
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
