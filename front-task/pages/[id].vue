<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useFetch } from "nuxt/app";

const route = useRoute();
const router = useRouter();
const taskId = route.params.id as string;

// Determine if we are in editing mode based on query parameter
const isEditing = computed(() => route.query.edit === "true");

const { data, refresh } = await useFetch(
  `http://localhost:8000/api/tasks/${taskId}`
);

const form = ref({
  name: "",
  description: "",
});

const editTask = () => {
  router.push({ query: { ...route.query, edit: "true" } });
};

const saveTask = async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/tasks/${taskId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(form.value),
    });

    if (response.ok) {
      // Actualiza los datos usando refresh
      await refresh();
    } else {
      console.error("Error updating task:", response.statusText);
    }
  } catch (err) {
    console.error("Error:", err);
  }
};

const deleteTask = async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/tasks/${taskId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      router.push("/"); // Redirige a la lista de tareas
    } else {
      console.error("Error deleting task:", response.statusText);
    }
  } catch (err) {
    console.error("Error:", err);
  }
};

// Initialize form data for editing
onMounted(() => {
  if (!isEditing.value && data.value) {
    form.value = {
      name: data.value.name,
      description: data.value.description,
    };
  }
});

const goBack = () => {
  router.push(`/${taskId}`); // Redirige a la vista de la tarea
};
</script>

<template>
  <div class="pt-4 md:pt-8 mx-4 md:mx-6 lg:mx-8">
    <div class="p-4 bg-white rounded-xl shadow-md space-y-4">
      <header class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 flex justify-between mt-4">
          {{ data.name }}
        </h1>
        <div class="text-sm text-gray-600">Task ID: {{ taskId }}</div>
      </header>
      <div v-if="isEditing" class="space-y-4">
        <UFormGroup
          label="Task:"
          name="name"
          class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md"
        >
          <UInput
            v-model="form.name"
            variant="outline"
            color="secondary"
            class="bg-white p-2 dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md"
          />
        </UFormGroup>

        <UFormGroup
          label="Description:"
          name="description"
          class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md"
        >
          <UTextarea
            color="secondary"
            variant="outline"
            placeholder="maximum 500 characters"
            v-model="form.description"
            rows="10"
            class="bg-white p-2 dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 rounded-md"
          />
        </UFormGroup>
        <footer class="flex justify-between mt-4">
          <UButton color="white" @click="saveTask">Save</UButton>
          <UButton color="blue" @click="goBack">Back</UButton>
        </footer>
      </div>

      <div v-else class="text-gray-700">
        <p class="text-lg">{{ data.description }}</p>
        <footer class="flex justify-between mt-4">
          <UButton color="white" @click="editTask">Edit Task</UButton>
          <UButton color="red" @click="deleteTask">Delete Task</UButton>
        </footer>
      </div>
    </div>
  </div>
</template>
