# CrediHome - Sistema de Gestión de Préstamos

Sistema completo de gestión de préstamos, aportadores, clientes y operaciones financieras desarrollado con Laravel 11.

## 🚀 Características

- ✅ Gestión completa de Usuarios y Roles
- ✅ Sistema de Permisos granular
- ✅ Gestión de Clientes
- ✅ Gestión de Aportadores y Capital
- ✅ Sistema de Cotizaciones
- ✅ Gestión de Préstamos
- ✅ Control de Pagos y Distribuciones
- ✅ Sistema de Chat interno
- ✅ Reportes y Dashboard
- ✅ Gestión de Productos/Materiales
- ✅ Sistema de Recetas

## 👥 Usuarios y Roles del Sistema

### Usuarios Precargados

Después de ejecutar los seeders, tendrás acceso a los siguientes usuarios:

| Rol | Email | Contraseña | Descripción |
|-----|-------|------------|-------------|
| **Super Admin** | civernet@gmail.com | admin123 | Acceso total al sistema |
| **Administrador** | admin@credihome.com | admin123 | Gestión completa excepto roles |
| **Gerente** | gerente@credihome.com | gerente123 | Gestión de operaciones |
| **Asesor** | asesor1@credihome.com | asesor123 | Ventas y cotizaciones |
| **Asesor** | asesor2@credihome.com | asesor123 | Ventas y cotizaciones |
| **Cajero** | cajero@credihome.com | cajero123 | Pagos y consultas |

### Roles y Permisos

#### Super Admin
- ✅ Acceso total a todas las funcionalidades
- ✅ Gestión de roles y permisos
- ✅ Administración del sistema completo

#### Administrador
- ✅ Gestión de usuarios (crear, editar, eliminar, asignar roles)
- ✅ Gestión completa de clientes, aportadores, productos
- ✅ Gestión completa de cotizaciones y préstamos
- ✅ Aprobación de operaciones
- ✅ Acceso a reportes
- ✅ Configuración del sistema
- ❌ No puede gestionar roles y permisos

#### Gerente
- ✅ Gestión de usuarios (crear, editar)
- ✅ Gestión de clientes y aportadores
- ✅ Gestión de productos y recetas
- ✅ Gestión y aprobación de cotizaciones
- ✅ Gestión y aprobación de préstamos
- ✅ Registro de pagos
- ✅ Acceso a reportes
- ❌ No puede eliminar usuarios
- ❌ No puede eliminar registros críticos

#### Asesor
- ✅ Gestión de clientes (crear, editar)
- ✅ Ver productos y recetas
- ✅ Crear y editar cotizaciones
- ✅ Ver préstamos
- ✅ Registrar pagos
- ✅ Chat interno
- ❌ No puede aprobar operaciones
- ❌ No puede gestionar aportadores

#### Cajero
- ✅ Ver clientes
- ✅ Ver préstamos
- ✅ Registrar pagos
- ✅ Chat interno
- ❌ Solo funciones de caja

## 📋 Instalación

### Requisitos Previos

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js y NPM

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone [url-del-repositorio]
cd credihome
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias JavaScript**
```bash
npm install
```

4. **Configurar el archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar la base de datos**
Edita el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=credihome
DB_USERNAME=root
DB_PASSWORD=
```

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

Este comando creará:
- ✅ Todas las tablas necesarias
- ✅ 5 roles predefinidos
- ✅ 70+ permisos organizados por módulo
- ✅ 6 usuarios de ejemplo con diferentes roles

7. **Compilar assets**
```bash
npm run dev
```

8. **Iniciar el servidor**
```bash
php artisan serve
```

9. **Acceder al sistema**
Abre tu navegador en: `http://localhost:8000`

## 🔐 Sistema de Permisos

El sistema utiliza **Spatie Laravel Permission** para gestión de roles y permisos. Los permisos están organizados por módulos:

### Módulos de Permisos

- **Usuarios**: ver, crear, editar, eliminar, asignar-roles
- **Roles**: ver, crear, editar, eliminar, asignar-permisos
- **Clientes**: ver, crear, editar, eliminar
- **Aportadores**: ver, crear, editar, eliminar, agregar-capital, retirar-capital
- **Productos**: ver, crear, editar, eliminar, importar
- **Recetas**: ver, crear, editar, eliminar, clonar
- **Cotizaciones**: ver, crear, editar, eliminar, aprobar, convertir
- **Préstamos**: ver, crear, editar, eliminar, aprobar
- **Pagos**: ver, registrar, eliminar
- **Reportes**: ver, exportar
- **Chat**: ver, enviar-mensajes
- **Configuración**: ver, editar
- **Dashboard**: ver

### Uso en Código

**En Controladores:**
```php
$this->middleware('permission:ver-usuarios')->only(['index', 'show']);
$this->middleware('permission:crear-usuarios')->only(['create', 'store']);
```

**En Blade:**
```blade
@can('crear-usuarios')
    <a href="{{ route('usuarios.create') }}">Nuevo Usuario</a>
@endcan
```

**En Código PHP:**
```php
if (auth()->user()->can('eliminar-usuarios')) {
    // Lógica
}
```

## 🎨 Interfaz

El sistema utiliza:
- **Tailwind CSS** para estilos
- **Flowbite** para componentes UI
- **Laravel Jetstream** para autenticación
- Diseño responsive y modo oscuro

## 📚 Documentación Adicional

- [MANUAL_USUARIO.md](MANUAL_USUARIO.md) - Manual de usuario del sistema
- [SISTEMA_COMPLETO.md](SISTEMA_COMPLETO.md) - Documentación técnica completa
- [SISTEMA_PRESTAMOS_GT.md](SISTEMA_PRESTAMOS_GT.md) - Sistema de préstamos
- [SISTEMA_APORTADORES.md](SISTEMA_APORTADORES.md) - Sistema de aportadores
- [SISTEMA_CHAT.md](SISTEMA_CHAT.md) - Sistema de chat
- [IMPORTACION_PRODUCTOS.md](IMPORTACION_PRODUCTOS.md) - Importación de productos

## 🔧 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Regenerar base de datos
php artisan migrate:fresh --seed

# Compilar assets para producción
npm run build

# Ejecutar tests
php artisan test
```

## 📝 Notas Importantes

1. **Primera vez**: Usa el usuario Super Admin (civernet@gmail.com / admin123) para acceder
2. **Seguridad**: Cambia las contraseñas predeterminadas en producción
3. **Permisos**: Asegúrate de que el directorio `storage/` tenga permisos de escritura
4. **Backups**: Configura backups regulares de la base de datos

## 🤝 Contribuir

Este es un proyecto privado. Para contribuir, contacta al administrador del sistema.

## 📄 Licencia

Sistema propietario - Todos los derechos reservados.

---

**Desarrollado con ❤️ usando Laravel 11**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
