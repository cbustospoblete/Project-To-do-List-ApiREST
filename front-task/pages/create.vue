<script setup lang="ts">
import { ref } from "vue";
import type { FormSubmitEvent } from "#ui/types";

// Define el estado del formulario y los mensajes de error
const task = ref({
  name: "",
  description: "",
  status: "",
  due_date: "",
});

const errors = ref({
  name: "",
  description: "",
});

// Función para manejar el envío del formulario
async function onSubmit(event: FormSubmitEvent<typeof task.value>) {
  // Limpiar mensajes de error
  errors.value.name = "";
  errors.value.description = "";

  // Validar campos
  if (!task.value.name.trim()) {
    errors.value.name = "name is required";
  }
  if (!task.value.description.trim()) {
    errors.value.description = "description is required";
  }

  // Si hay errores, no enviar el formulario
  if (errors.value.name || errors.value.description) {
    return;
  }

  try {
    const response = await $fetch("http://localhost:8000/api/tasks", {
      method: "POST",
      body: JSON.stringify(event.data),
      headers: {
        "Content-Type": "application/json",
      },
    });

    console.log("Tarea creada con éxito:", response);
    // Limpia el formulario después de la creación exitosa
    task.value.name = "";
    task.value.description = "";
  } catch (error) {
    console.error("Error al crear la tarea:", error);
  }
}

const status = ["Pending", "Overdue", "Completed"];
</script>

<template>
  <div
    class="flex items-center justify-center pt-12 bg-gray-100 dark:bg-gray-900"
  >
    <div
      class="w-full max-w-xl p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg"
    >
      <UForm :state="task" class="space-y-4" @submit="onSubmit">
        <UFormGroup label="Name task" name="name">
          <UInput
            v-model="task.name"
            variant="outline"
            color="gray"
            placeholder="Name"
          />
          <p v-if="errors.name" class="text-red-500 text-sm">
            {{ errors.name }}
          </p>
        </UFormGroup>
        <USelect
          v-model="task.status"
          icon="i-heroicons-magnifying-glass-20-solid"
          :options="status"
          variant="outline"
          color="gray"
        />

        <UFormGroup label="Description" name="description">
          <UTextarea
            color="gray"
            variant="outline"
            placeholder="Add Task Description"
            v-model="task.description"
            rows="10"
          />
          <p v-if="errors.description" class="text-red-500 text-sm">
            {{ errors.description }}
          </p>
        </UFormGroup>
        <UButton
          type="submit"
          class="w-full bg-blue-500 text-white hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
        >
          Create Task
        </UButton>
      </UForm>
    </div>
  </div>
</template>
