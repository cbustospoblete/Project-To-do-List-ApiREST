<script setup lang="ts">
import { ref, onMounted, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useFetch } from "nuxt/app";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

// Obtiene la ruta actual y el router para navegar
const route = useRoute();
const router = useRouter();

// Obtiene el ID de la tarea de los parámetros de la ruta
const taskId = route.params.id as string;

// Computed property para verificar si estamos en modo de edición
const isEditing = computed(() => route.query.edit === "true");

// Usa `useFetch` para obtener los datos de la tarea desde la API
const { data, refresh } = await useFetch(
  `http://localhost:8000/api/tasks/${taskId}`
);

// Define el estado del formulario con campos vacíos
const form = ref({
  name: "",
  description: "",
  status: "",
  due_date: "",
});

// Opciones para el campo de estado
const statusOptions = ["pending", "overdue", "completed"];

// Variable reactiva para almacenar la fecha seleccionada
const date = ref(new Date());

// Estado para los mensajes de error
const errors = ref({
  name: "",
  description: "",
});

// Observa los cambios en `date` y actualiza `form.due_date` con la fecha formateada
watch(date, (newDate) => {
  form.value.due_date = formatDate(newDate);
});

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

// Función para activar el modo de edición
const editTask = () => {
  router.push({ query: { ...route.query, edit: "true" } });
};

// Función para guardar los cambios en la tarea editada
const saveTask = async () => {
  errors.value = {
    name: form.value.name ? "" : "Task name is required.",
    description: form.value.description ? "" : "Description is required.",
  };

  // Verifica si hay errores antes de proceder
  if (errors.value.name || errors.value.description) {
    return; // Detiene la función si hay errores
  }

  try {
    // Realiza una solicitud PUT a la API para actualizar la tarea
    const response = await fetch(`http://localhost:8000/api/tasks/${taskId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(form.value),
    });

    if (response.ok) {
      // Si la tarea se actualiza correctamente, refresca los datos
      await refresh();
      // Luego de guardar, regresa a la vista de la tarea
      goBack();
    } else {
      console.error("Error updating task:", response.statusText);
    }
  } catch (err) {
    // Maneja cualquier error que ocurra durante la actualización
    console.error("Error:", err);
  }
};

// Función para eliminar la tarea actual
const deleteTask = async () => {
  try {
    // Realiza una solicitud DELETE a la API para eliminar la tarea
    const response = await fetch(`http://localhost:8000/api/tasks/${taskId}`, {
      method: "DELETE",
    });

    if (response.ok) {
      router.push("/"); // Redirige a la lista de tareas después de eliminar
    } else {
      console.error("Error deleting task:", response.statusText);
    }
  } catch (err) {
    // Maneja cualquier error que ocurra durante la eliminación
    console.error("Error:", err);
  }
};

// Inicializa los datos del formulario si no estamos en modo de edición
onMounted(() => {
  if (!isEditing.value && data.value) {
    form.value = {
      name: data.value?.name || "",
      description: data.value?.description || "",
      status: data.value?.status || "",
      due_date: data.value?.due_date || "",
    };
    date.value = new Date(data.value?.due_date); // Inicializa la fecha seleccionada
  }
});

// Función para regresar a la vista de la tarea sin editar
const goBack = () => {
  router.push(`/${taskId}`); // Redirige a la vista de la tarea
};
</script>

<template>
  <UCard>
    <div class="pt-2 md:pt-8 mx-4 md:mx-6 lg:mx-8">
      <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg space-y-6">
        <!-- Encabezado -->
        <header class="flex items-center justify-between">
          <UButton
            color="gray"
            variant="ghost"
            size="xl"
            icon="i-material-symbols:arrow-back"
            @click="router.push(`/`)"
          />
          <h1
            class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mt-4"
          >
            {{ data.name }}
          </h1>
          <div class="text-sm text-gray-600 dark:text-gray-400">
            Task ID: {{ taskId }}
          </div>
        </header>

        <Placeholder class="h-8" />

        <!-- Vista de Edición -->
        <div v-if="isEditing" class="space-y-6">
          <UFormGroup label="Task Name:" name="name">
            <UInput
              v-model="form.name"
              variant="outline"
              color="secondary"
              placeholder="Enter task name"
            />
            <p v-if="errors.name" class="text-red-500 text-sm">
              {{ errors.name }}
            </p>
          </UFormGroup>

          <UFormGroup label="Description:" name="description">
            <UTextarea
              color="secondary"
              variant="outline"
              v-model="form.description"
              :rows="6"
              class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg"
            />
            <p v-if="errors.description" class="text-red-500 text-sm">
              {{ errors.description }}
            </p>
          </UFormGroup>

          <UFormGroup label="Due Date:" name="due_date">
            <VueDatePicker
              v-model="date"
              :clearable="false"
              dark
              placeholder="Select due date"
              class="w-full border border-gray-300 dark:border-gray-600 rounded-lg"
            />
          </UFormGroup>

          <UFormGroup label="Status:" name="status">
            <USelect
              v-model="form.status"
              :options="statusOptions"
              variant="outline"
              color="white"
              placeholder="Select status"
              class="w-full border border-gray-300 dark:border-gray-600 rounded-lg"
            />
          </UFormGroup>
          <footer class="flex justify-between mt-6 space-x-4">
            <UButton color="blue" @click="saveTask" class="flex-1">
              Save
            </UButton>
            <UButton color="gray" @click="goBack" class="flex-1">
              Back
            </UButton>
          </footer>
        </div>
        <div v-else class="text-gray-700 dark:text-gray-200">
          <p class="text-sm mb-2">Due Date: {{ data.due_date }}</p>
          <span class="flex items-center mb-2">
            <span class="mr-2">Status:</span>
            <p
              class="text-lg"
              :class="{
                'text-red-500': data.status === 'Overdue',
                'text-green-500': data.status === 'Completed',
                'text-yellow-500':
                  data.status !== 'Overdue' && data.status !== 'Completed',
              }"
            >
              {{ data.status }}
            </p>
          </span>
          <p class="text-lg mb-4">Description: {{ data.description }}</p>
          <footer class="flex justify-between mt-6 space-x-4">
            <UButton color="blue" @click="editTask" class="flex-1">
              Edit Task
            </UButton>
            <UButton color="red" @click="deleteTask" class="flex-1">
              Delete Task
            </UButton>
          </footer>
        </div>
      </div>
    </div>
  </UCard>
</template>
