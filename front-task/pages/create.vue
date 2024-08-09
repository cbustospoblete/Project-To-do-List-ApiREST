<script setup lang="ts">
import { ref } from "vue";
import type { FormSubmitEvent } from "#ui/types";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

// Variable reactiva para almacenar la fecha seleccionada
const date = ref(new Date());

// Función para formatear la fecha en el formato 'Y-m-d H:i:s'
const formatDate = (date: Date): string => {
  const day = date.getDate().toString().padStart(2, "0");
  const month = (date.getMonth() + 1).toString().padStart(2, "0");
  const year = date.getFullYear();
  const hours = date.getHours().toString().padStart(2, "0");
  const minutes = date.getMinutes().toString().padStart(2, "0");
  const seconds = date.getSeconds().toString().padStart(2, "0");

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
};

// Define el estado del formulario y los mensajes de error
const task = ref({
  name: "",
  description: "",
  status: "",
  due_date: formatDate(new Date()), // Inicializa con la fecha actual formateada
});

const errors = ref({
  name: "",
  description: "",
  status: "",
});

// Observa los cambios en `date` y actualiza `task.due_date` con la fecha formateada
watch(date, (newDate) => {
  task.value.due_date = formatDate(newDate);
});

// Función para manejar el envío del formulario
async function onSubmit(event: FormSubmitEvent<typeof task.value>) {
  // Limpiar mensajes de error
  errors.value.name = "";
  errors.value.description = "";
  errors.value.status = "";

  // Validar campos del formulario
  if (!task.value.name.trim()) {
    errors.value.name = "Name is required";
  }
  if (!task.value.description.trim()) {
    errors.value.description = "Description is required";
  }
  if (!task.value.status.trim()) {
    errors.value.status = "Status is required";
  }

  // Si hay errores, no enviar el formulario
  if (errors.value.name || errors.value.description || errors.value.status) {
    return;
  }

  try {
    // Enviar los datos del formulario al servidor para crear la tarea
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
    task.value.status = "";
    task.value.due_date = "";
  } catch (error) {
    // Maneja cualquier error que ocurra durante la creación de la tarea
    console.error("Error al crear la tarea:", error);
  }
}

// Opciones de estado para el campo `status` en el formulario
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
        <VueDatePicker :clearable="false" dark v-model="date"></VueDatePicker>
        <USelect
          v-model="task.status"
          icon="i-heroicons-magnifying-glass-20-solid"
          :options="status"
          variant="outline"
          placeholder="Select status"
          color="gray"
        />
        <p v-if="errors.status" class="text-red-500 text-sm">
          {{ errors.status }}
        </p>
        <UFormGroup label="Description" name="description">
          <UTextarea
            color="gray"
            variant="outline"
            placeholder="Add Task Description"
            v-model="task.description"
            :rows="10"
          />
          <p v-if="errors.description" class="text-red-500 text-sm">
            {{ errors.description }}
          </p>
        </UFormGroup>
        <UButton color="white" type="submit"> Create Task </UButton>
      </UForm>
    </div>
  </div>
</template>
