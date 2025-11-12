# 🎵 LSPoty — Proyectos Web 2  
### Grupo 08  

**Miembros:**  
- Nil Bagaria Nofre  
- Álvaro Bello Garrido  

---

## 📘 Introducción

**LSPoty** es una aplicación web desarrollada como parte de la asignatura **Proyectos Web 2** en la Universidad **La Salle**.  
El proyecto ha sido construido utilizando el framework **CodeIgniter**, dentro de contenedores **Docker**, y programado con el entorno de desarrollo **PhpStorm**.

LSPoty permite **buscar y reproducir canciones**, **descubrir artistas y álbumes**, y **crear o explorar playlists personalizadas**.  
Se integra con la **API de Jamendo** para obtener información musical actualizada, e incluye autenticación de usuarios, gestión de perfil y playlists, y control completo de reproducción.

---

## ⚙️ Funcionamiento

### 1. 🏠 Inicio
- Accede al landing-page (`/`).
- Acceder a la ventana de registro (2 opciones):
  - Botón `Registro` (parte inferior de la página).
  - Botón `Registro` en el menú (parte superior derecha)
- Regístrate con tu correo y contraseña respetando los requisitos.
- Inicia sesión en `/sign-in` (2 opciones):
  - Acceder des del landing-page `Iniciar Sesión` (botón parte inferior de la página).
  - Acceder des del menú `Iniciar Sesión`(parte superior derecha).

---

### 2. 🎧 Home
- Al entrar se muestra un listado de **10 canciones populares aleatorias**.
- Puedes **reproducir** una canción haciendo clic en el icono `Play`. El audio se reproducirá en el **reproductor global** de la parte inferior.
- Pulsa `+` para **añadir una canción a una playlist** (debes haber creado al menos una playlist previamente).

---

### 3. 🔍 Búsqueda
- Usa la **barra de búsqueda** para filtrar por nombre.
- Puedes buscar entre:
  - **Canciones**, **Álbumes**, **Artistas** o **Playlists**.
- Cada elemento es interactivo:
  - Clic en el **nombre del artista** → Detalles del artista (álbumes publicados).
  - Clic en el **nombre del álbum** → Detalles del álbum (canciones incluidas).
  - Clic en el **nombre de la canción** → Redirige al álbum correspondiente.
  - Clic en el **nombre de la playlist** → Detalles de la playlist.

> 💡 Dentro de los detalles de álbum, playlist o artista, puedes reproducir directamente las canciones que contengan con el botón `Play`.  
> 💡 Para volver al inicio, haz clic en **LSPoty** (arriba a la izquierda) o usa la flecha “atrás” del navegador.

---

### 4. 👤 Perfil de usuario (`/profile`)
- Accede desde el menú superior → **Perfil**.
- Consulta tu **nombre**, **correo**, **edad** y **foto de perfil**.
- Desde **Editar perfil** (`/profile/edit`) puedes actualizar:
  - Imagen de perfil  
  - Correo electrónico  
  - Edad  
  - Contraseña  

---

### 5. 🎵 Playlists (`/my-playlists`)
- Accede a tus playlists desde el menú → **Mis listas de reproducción**.
- Permite:
  - Ver tus playlists.
  - Reproducir canciones dentro de cada lista.
  - Eliminar o modificar playlists.
- Crear nuevas playlists desde `/create-playlist`, indicando nombre e imagen.
- Para añadir canciones a una lista, utiliza el botón `+` desde `/home`.

---

### 6. 📂 Menú superior
- **LSPoty (logo):** vuelve a `/home` o `/` (si no has iniciado sesión).  
- **Mis listas de reproducción:** gestiona tus playlists.  
- **Perfil:** consulta o edita tus datos personales.  
- **Desconectar:** cierra sesión y vuelve al *landing page*.

---

## 🌐 Idiomas

La aplicación está disponible en **español** e **inglés**, con detección automática del idioma del navegador.

---

## 🛠️ Entorno de desarrollo

Framework: CodeIgniter

Entorno: PhpStorm

Infraestructura: Contenedores Docker (Docker Compose)

Lenguaje: PHP

Frontend: HTML, CSS, JavaScript

Universidad: La Salle — Proyectos Web 2

---

## 🧩 Dependencias principales

| Dependencia | Uso |
|--------------|-----|
| **Guzzle** | Realizar peticiones HTTP a la API de Jamendo. |
| **Carbon** | Gestión de fechas y duraciones musicales. |

---

## 🐳 Ejecución del proyecto con Docker

El proyecto ha sido desarrollado con **CodeIgniter** dentro de contenedores **Docker**, y su ejecución se gestiona mediante **Docker Compose**.

### Pasos para la ejecución:

1. Instala y abre Docker Desktop.

2. *(Opcional)* Modifica los puertos de los contenedores en el archivo `.env` según tu configuración (Se recomienda dejar los definidos por defecto a no ser que alguno de ellos esté en uso).

3. En la terminal, muévete a la carpeta raíz del proyecto `pwii-lspoty-environment`.

4. Construye las imágenes de Docker:
   ```bash
   docker compose build app
5. Inicia los contenedores:
   ```bash
    docker compose up -d
6. Instala las dependencias del proyecto (CodeIgniter / Composer):
    ```bash
    docker compose exec app composer install
7.  Abre el proyecto en tu navegador:
    ```bash
    http://localhost:4080/
    (O desde Docker Desktop, abriendo el contenedor nginx.)

