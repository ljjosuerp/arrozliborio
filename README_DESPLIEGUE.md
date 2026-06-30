# Guía de despliegue — arrozliborio.com

Esta guía explica cómo **publicar el sitio** para que lo vea el público, con todo
funcionando. Está escrita para alguien sin experiencia técnica; seguí los pasos en orden.

---

## 0. ¿Qué es este proyecto?

Una aplicación web hecha con **Laravel (PHP) + Vue/Inertia + Filament** (el panel
admin). No es un HTML suelto: necesita un servidor con PHP para funcionar.

- **Sitio público:** páginas de productos, recetas, mapa de tiendas, contacto, empleo.
- **Panel admin** (`/admin`): para administrar todo el contenido.
- Todo el contenido se reconstruye solo desde `database/data/*.json` (productos,
  recetas, puntos de venta, etc.), así que el sitio queda idéntico en cualquier servidor.

---

## 1. Correrlo en tu Mac (desarrollo)

```bash
cd ~/Desktop/Claude/arrozliborio
npm run dev          # terminal 1 (compila el frontend)
php artisan serve    # terminal 2 → http://127.0.0.1:8000
```

Esto es solo para vos. Para el público, seguí con el despliegue.

---

## 2. Antes de publicar: poné el código en GitHub

Es el respaldo del proyecto y la base del despliegue.

1. Creá una cuenta en https://github.com (gratis) y un repositorio **privado**
   (ej. `arrozliborio`).
2. En tu Mac:
   ```bash
   cd ~/Desktop/Claude/arrozliborio
   git add .
   git commit -m "Sitio listo para producción"
   git branch -M main
   git remote add origin https://github.com/TU-USUARIO/arrozliborio.git
   git push -u origin main
   ```
   > El proyecto ya está inicializado en Git y el `.gitignore` excluye lo que no debe
   > subirse (`.env`, `vendor/`, `node_modules/`, la base de datos local).

---

## 3. Elegí dónde alojarlo (hosting)

| Opción | Para quién | Costo aprox. |
|--------|-----------|--------------|
| **Laravel Cloud** (recomendado) | Lo más fácil. Conectás GitHub y despliega solo. | ~$0–20/mes |
| **Laravel Forge + VPS** | Más control. Forge configura un servidor (DigitalOcean/Hetzner). | ~$12 + $6/mes |

### Opción A — Laravel Cloud (la más simple)

1. Entrá a https://cloud.laravel.com y registrate.
2. Conectá tu cuenta de GitHub y elegí el repo `arrozliborio`.
3. Cuando pida la base de datos, elegí **MySQL** (administrada) o dejá SQLite.
4. En **Environment / Variables**, configurá las variables de la sección 4.
5. En el **deploy command**, asegurate de que incluya:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci && npm run build
   php artisan migrate --force
   php artisan db:seed --class=Database\\Seeders\\LiborioSeeder --force   # solo la 1ª vez
   php artisan storage:link
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
6. Deploy. Te da una URL de prueba (ej. `arrozliborio.laravel.cloud`).

### Opción B — Laravel Forge + VPS

1. Cuenta en https://forge.laravel.com + una cuenta en DigitalOcean/Hetzner.
2. Forge crea el servidor; conectás el repo de GitHub.
3. Configurás las variables (sección 4), activás SSL (Let's Encrypt, gratis) y desplegás.
4. En el "Deploy Script" usá los mismos comandos de arriba.

---

## 4. Variables de entorno para producción (`.env`)

Tomá `.env.example` como base. Lo crítico:

```env
APP_NAME="Arrocera Liborio"
APP_ENV=production
APP_DEBUG=false                 # ¡importante! nunca true en producción
APP_URL=https://tudominio.com
APP_KEY=                        # generar: php artisan key:generate

# Correo real (para que el formulario de contacto envíe de verdad)
MAIL_MAILER=smtp
MAIL_HOST=smtp.tu-proveedor.com
MAIL_PORT=587
MAIL_USERNAME=tu-usuario
MAIL_PASSWORD=tu-clave
MAIL_FROM_ADDRESS="info@arrozliborio.com"

# Archivos subidos desde el admin (fotos, CV):
# - En un VPS normal: FILESYSTEM_DISK=local funciona.
# - En hosts "efímeros" (se borra el disco al actualizar): usar s3 + completar AWS_*
FILESYSTEM_DISK=local
```

> **Correo:** podés usar el SMTP de tu dominio, o un servicio como Resend, Mailgun o
> Postmark (tienen planes gratis para empezar).

---

## 5. Primer despliegue: cargar el contenido

La **primera vez** hay que crear las tablas y cargar el contenido:

```bash
php artisan migrate --force
php artisan db:seed --class=Database\Seeders\LiborioSeeder --force
php artisan storage:link
```

Esto deja el sitio con sus 8 productos, 12 recetas, 80 puntos de venta, etc.
**En despliegues siguientes NO repitas el `db:seed`** (borraría lo que edites en el admin).

---

## 6. Entrar al admin (y seguridad)

- URL: `https://tudominio.com/admin`
- Usuario inicial: **admin@arrozliborio.com** / **liborio2026**
- 🔒 **Cambiá esa contraseña apenas entres** (Perfil → contraseña).
- Solo los usuarios marcados como **administrador** (`is_admin`) pueden entrar al panel.
  Para crear otro admin:
  ```bash
  php artisan make:filament-user
  # luego marcalo como admin en la base, o pedímelo y te dejo el comando
  ```

---

## 7. El dominio (¡importante con arrozliborio.com!)

El dominio `arrozliborio.com` **ya tiene el sitio actual en vivo**. Como esto es un
**rebuild**, el plan correcto es:

1. Publicá primero en la **URL de prueba** que te da el hosting.
2. Revisá todo con calma (vos y el equipo).
3. Cuando esté aprobado, **apuntá el dominio** al nuevo hosting (cambiar los registros
   DNS). Ese es el "cambio" (cutover) y conviene hacerlo coordinado, no improvisado.

> Si querés, te puedo armar un checklist específico para ese día de cambio.

---

## 8. Mantenimiento

- **Actualizar el sitio:** hacés cambios → `git push` → el hosting redepliega solo.
- **Respaldos:** activá los backups automáticos de la base de datos en tu hosting.
- **Imágenes:** las fotos de producto pesan ~1 MB; cuando puedas, conviene comprimirlas
  (WebP) para que el sitio cargue más rápido. (Te lo puedo automatizar.)

---

## 9. Qué hago yo / qué es tuyo

- **Yo (puedo):** dejar el proyecto listo, ajustar configuración, automatizar el deploy,
  y guiarte en cada paso.
- **Vos (solo tú podés):** contratar el hosting y el dominio, y poner los datos de pago.
  Por seguridad nunca manejo tus tarjetas ni contraseñas.

¿Dudas en algún paso? Decime en cuál estás y te acompaño. 🌾
```
