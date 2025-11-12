# Proyectos Web 2 -  LSPoty
### Grupo 08

**Miembros:**
- Nil Bagaria Nofre
- Álvaro Bello Garrido

---

## Introducción
LSPoty es una aplicación web para buscar y reproducir canciones, descubrir artistas y/o álbumes, y crear o encontrar nuevas playlists.  
Se integra con la API de Jamendo para obtener las distintas canciones, álbumes y artistas, e incluye autenticación de usuarios, gestión de perfil y funcionalidades básicas para el control de múscia y de playlists.

---

## Funcionamiento

1. **Inicio**
    - Accede al landing-page (`/`).
    - Acceder a la ventana de registro (2 opciones):
      - Botón `Registro` (parte inferior de la página).
      - Botón `Registro` en el menú (parte superior derecha)
    - Regístrate con tu correo y contraseña respetando los requisitos.
    - Inicia sesión en `/sign-in` (2 opciones):
      - Acceder des del landing-page `Iniciar Sesión` (botón parte inferior de la página).
      - Acceder des del menú `Iniciar Sesión`(parte superior derecha).

2. **Home**
    - Al entrar verás un listado con 10 canciones populares aleatorias.
    - Puedes **reproducir** cualquiera pulsando el icono  `Play`️. El audio se reproduce en el reproductor global de la parte inferior de la página.
    - Pulsa `+` para añadir una canción a una playlist (debes haber creado al menos una playlist previamente).
   

3. **Home - Búsqueda**
    - Utiliza la barra de búsqueda para filtrar por nombre. Se buscará contenido que contenga la palabra o frase introducida.
    - Puedes realizar la búsqueda para distintos resultados:
   
        - **Canciones**, **Álbumes**, **Artistas** o **Playlists**.
    
      - Todas las canciones, álbumes, artistas o playlist que aparecen en `/home` son interactivos, es decir:
        
        - Si pulsas el `nombre del artista` -> Accedes al apartado de `Detalles del artista` con su información y álbumes publicados. (Artist-Details).
        - Si pulsas el `nombre del álbum` -> Accedes al apartado de `Detalles del álbum` con la información del álbum y el listado de canciones. (Album-Details).
        - Si pulsas el `nombre de la canción` -> Accedes al álbum al cual pertenece de esa canción.
        - Si pulsas el `nombre de la playlist` -> Accedes a la Playlist y puedes visualizar su información y canciones. (PLaylist - Details).

         
***Nota: Dentro de los detalles del álbum, playlist, etc. Se pueden reproducir las canciones que contengan pulsando el botón `Play`.***

***Nota 2: Para volver a `/home` pulsar en `LSPoty`(arriba a la izquierda en el menú) o utilizar la flecha `<-` (atrás), o similar, del navegador.***


4. **Perfil de usuario** - `/profile`
    - Accede a tu perfil desde el menú superior seleccionando **"Perfil"**.
    - Visualiza tu **nombre**, **correo electrónico**, **edad** y **foto de perfil**.
    - Desde esta vista puedes ir a **Editar perfil** (`/profile/edit`), donde podrás actualizar tu información.
      - Cambios como imagen de perfil, email, edad y contraseña se gestionan aquí.

5. **Playlists**
   - Accede a tus playlists desde el menú en **"Mis listas de reproducción"** (`/my-playlists`).
     - Podrás:
       - Ver tus playlists.
       - Reproducir canciones dentro de cada una.
       - Eliminar o actualizar información de la playlist.
     - Desde esta vista también puedes acceder a **crear una nueva playlist** (`/create-playlist`), indicando un nombre e imagen personalizada.
     - Para añadir canciones a una playlist, usa el botón **+** desde `/home`.

6. **Menú superior**
    - **`LSPoty`** (logo parte superior izquierda) -> vuelve siempre a `/home` o `/` (si no has iniciado sesión).
    - **`Mis listas de reproducción`** -> Accede al apartado de gestión de tus playlists.
    - **`Perfil`** -> Accede al perfil para consultar y editar tu información (foto, email, edad, contraseña).
    - **`Desconectar`** -> Permite cerrar la sesión (logout) y volver al landing-page (`/`).

---
## Idiomas

La web se traduce automáticamente al **inglés** y al **castellano**.


---
## Dependencias

Para la realización del proyecto se han utilizado las siguientes dependencias:

`Guzzle` -> Para realizar las peticiones a la API Jamendo.

`Carbon` -> Para gestionar las fechas y duraciones.

---
## Ejecución programa

Nuestro programa ha sido desarrollado utilizando el framework de Code Igniter dentro de un contenedor docker, por lo
que para ejecutarlo deberemos realizar los siguientes pasos:

1. Descargar y abrir Docker Desktop.
2. (Opcional) Modificar los puertos definidos en el archivo ".env" para los contenedores.
3. Movernos a través del terminal a la carpeta "pwii-lspoty-environment" y ejecutar el siguiente comando para crear las imágenes y contenedores dentro de Docker:
   docker compose build app
4. Ejecutar el siguiente comando para iniciar los contenedores Docker:
   docker compose up -d
5. Ejecutar el siguiente comando para instalar las dependencias necesarias en /vendor:
   docker compose exec app composer install
6. Abrir el proyecto buscando el siguiente enlace en el navegador: http://localhost:4080/ (O bien entrar en Docker Desktop y abrir la dirección del contenedor nginx)