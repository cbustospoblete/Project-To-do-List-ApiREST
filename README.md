# Project-To-do-List-ApiREST

## Descripción

**Project-To-do-List-ApiREST** es una aplicación para gestionar tareas utilizando una API REST en el backend con Laravel y una interfaz de usuario moderna construida con Nuxt 3. Este proyecto permite crear, actualizar, eliminar y listar tareas de manera eficiente.

## Tecnologías Utilizadas

- **Frontend**:
  - Nuxt 3
  - Tailwind CSS
  - NuxtUI

- **Backend**:
  - Laravel
  - API REST

## Instalación

### Backend (Laravel)

1. Clona el repositorio que contiene tanto el backend como el frontend:
    

    git clone https://github.com/cbustospoblete/Project-To-do-List-ApiREST
    cd Project-To-do-List-ApiREST/backend-api


2. Instala las dependencias del backend:
    

    composer install


3. Copia el archivo de configuración de ejemplo y configura la base de datos en el archivo .env:
    

    cp .env.example .env

    Edita el archivo .env para configurar la conexión a la base de datos según tu entorno.

4. Levanta el servidor de desarrollo del backend:
    

    php artisan serve


### Frontend (Nuxt 3)

1. Navega al directorio del frontend dentro del repositorio clonado:
    

    cd ../front-task


2. Instala las dependencias del frontend:
    
bash
    npm install


3. Inicia el servidor de desarrollo del frontend:
    

    npm run dev


## Uso

1. **Frontend**: Accede a la aplicación en http://localhost:3000 para interactuar con la interfaz de usuario, crear tareas, y realizar otras operaciones CRUD.

2. **Backend**: La API REST del servidor está disponible en http://localhost:8000/api/tasks/. Puedes utilizar herramientas como Postman o Insomnia para probar las rutas de la API REST.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](./LICENSE) para más detalles.

## Contacto

Si tienes alguna pregunta o sugerencia, no dudes en contactarme en [cbustospoblete@gmail.com](mailto:cbustospoblete@gmail.com).
