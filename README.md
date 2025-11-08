# 🧵 CYABordados

Bienvenido a **CYABordados**, un sistema ERP desarrollado en **Laravel** para la gestión integral de una empresa de bordados.  
Esta aplicación permite administrar de forma moderna y organizada los procesos de **materiales, ingreso de órdenes, control de producción, ventas e inventarios**.

---

## 🚀 Tecnologías utilizadas

-   ⚙️ [**Laravel 10**](https://laravel.com/) — Framework PHP moderno y potente
-   🎨 [**Bootstrap 5**](https://getbootstrap.com/) — Diseño responsivo y componentes UI
-   🖼️ [**FontAwesome**](https://fontawesome.com/) — Iconografía profesional
-   ✨ [**AOS (Animate On Scroll)**](https://michalsnik.github.io/aos/) — Animaciones en scroll
-   💾 [**MySQL**](https://www.mysql.com/) — Base de datos relacional

---

## ⚙️ Instalación y Configuración

Sigue los pasos para ejecutar el proyecto en tu entorno local:

```bash
# 1️⃣ Clonar el repositorio
git clone https://github.com/HorasSocialesEsit/CYABordados.git

# 2️⃣ Entrar al directorio del proyecto
cd CYABordados

# 3️⃣ Instalar dependencias de Laravel
composer install
composer require barryvdh/laravel-dompdf



# 4️⃣ Copiar archivo de entorno
cp .env.example .env

# 5️⃣ Generar la clave de la aplicación
php artisan key:generate

# 6️⃣ Configurar la base de datos en el archivo .env
# (Editar los valores DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 7️⃣ Ejecutar migraciones
php artisan migrate

# 8️⃣ (Opcional) Cargar datos iniciales
php artisan db:seed

# 9️⃣ Crear el enlace simbólico para almacenamiento (imágenes, archivos, etc.)
php artisan storage:link

# 🔟 Levantar el servidor local
php artisan serve

# 1️⃣ Clonar el repositorio
git clone https://github.com/HorasSocialesEsit/CYABordados.git
cd CYABordados

# 2️⃣ Crear tu rama de desarrollo personal (desde main)
# Solo una vez por persona
git checkout -b dev-moises   # Para Moises
git checkout -b dev-luis     # Para Luis

# 3️⃣ Hacer tus cambios de código
# (editar archivos, crear controladores, vistas, etc.)

# 4️⃣ Agregar tus cambios al área de commit
git add .

# 5️⃣ Confirmar los cambios con un mensaje claro
git commit -m "Agregado campo municipio en tabla clientes"

# 6️⃣ Subir tu rama al repositorio remoto
git push origin dev-moises
# o si eres Luis
git push origin dev-luis

# 7️⃣ Crear un Pull Request (PR)
# Ir a GitHub → pestaña "Pull Requests" → "New Pull Request"
# Seleccionar:
#   base: main
#   compare: tu_rama (ej: dev-moises)
# Luego crear el PR para revisión antes del merge.

# 🔁 (Opcional) Si hay nuevos cambios en main y quieres mantener tu rama actualizada:
git checkout dev-moises
git fetch origin
git merge origin/main   # Integra los últimos cambios sin borrar tu trabajo

# 👁 Ver en qué rama estás
git branch

# 🔄 Cambiar de rama
git checkout main

# 🔄 Actualizar la rama principal localmente
git pull origin main

```
