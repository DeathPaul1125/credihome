# Gestión de Usuarios - CrediHome

Esta guía explica en detalle el sistema de gestión de usuarios, roles y permisos implementado en CrediHome.

## 📋 Tabla de Contenidos

1. [Usuarios Predefinidos](#usuarios-predefinidos)
2. [Roles del Sistema](#roles-del-sistema)
3. [Permisos Disponibles](#permisos-disponibles)
4. [Gestión de Usuarios](#gestión-de-usuarios)
5. [Gestión de Roles](#gestión-de-roles)
6. [Casos de Uso](#casos-de-uso)

## 👤 Usuarios Predefinidos

El sistema viene con 6 usuarios de ejemplo creados automáticamente:

### Super Admin
- **Email:** civernet@gmail.com
- **Contraseña:** admin123
- **Descripción:** Acceso total al sistema, incluida la gestión de roles y permisos
- **Uso:** Administración completa del sistema

### Administrador
- **Email:** admin@credihome.com
- **Contraseña:** admin123
- **Descripción:** Gestión operativa completa excepto roles
- **Uso:** Operaciones diarias y administración de usuarios

### Gerente
- **Email:** gerente@credihome.com
- **Contraseña:** gerente123
- **Descripción:** Supervisión de operaciones y aprobaciones
- **Uso:** Aprobación de préstamos y supervisión general

### Asesor 1
- **Email:** asesor1@credihome.com
- **Contraseña:** asesor123
- **Descripción:** Ventas y atención al cliente
- **Uso:** Creación de cotizaciones y gestión de clientes

### Asesor 2
- **Email:** asesor2@credihome.com
- **Contraseña:** asesor123
- **Descripción:** Ventas y atención al cliente
- **Uso:** Creación de cotizaciones y gestión de clientes

### Cajero
- **Email:** cajero@credihome.com
- **Contraseña:** cajero123
- **Descripción:** Operaciones de caja
- **Uso:** Registro de pagos y consultas

## 🎭 Roles del Sistema

### 1. Super Admin

**Permisos:** Todos los permisos del sistema (70+)

**Capacidades:**
- ✅ Gestión completa de usuarios
- ✅ Gestión de roles y permisos
- ✅ Gestión de clientes y aportadores
- ✅ Gestión de productos y recetas
- ✅ Gestión de cotizaciones y préstamos
- ✅ Aprobaciones y conversiones
- ✅ Gestión de pagos
- ✅ Acceso a reportes
- ✅ Configuración del sistema
- ✅ Chat interno

**Restricciones:** Ninguna

### 2. Administrador

**Permisos:** 60+ permisos (todos excepto gestión de roles)

**Capacidades:**
- ✅ Gestión completa de usuarios (crear, editar, eliminar, asignar roles)
- ✅ Gestión completa de clientes y aportadores
- ✅ Gestión completa de productos, recetas, cotizaciones y préstamos
- ✅ Aprobar operaciones
- ✅ Gestión de pagos
- ✅ Acceso a reportes y exportaciones
- ✅ Configuración del sistema
- ✅ Chat interno

**Restricciones:**
- ❌ No puede crear, editar o eliminar roles
- ❌ No puede asignar permisos a roles

### 3. Gerente

**Permisos:** 40+ permisos (gestión operativa)

**Capacidades:**
- ✅ Crear y editar usuarios (no eliminar)
- ✅ Crear y editar clientes
- ✅ Agregar y retirar capital de aportadores
- ✅ Gestión de productos y recetas
- ✅ Gestión completa de cotizaciones
- ✅ Gestión completa de préstamos
- ✅ Aprobar cotizaciones y préstamos
- ✅ Convertir cotizaciones a préstamos
- ✅ Registrar pagos
- ✅ Acceso a reportes
- ✅ Chat interno

**Restricciones:**
- ❌ No puede eliminar usuarios
- ❌ No puede eliminar clientes, aportadores
- ❌ No puede eliminar productos o recetas
- ❌ No puede eliminar cotizaciones o préstamos
- ❌ No puede eliminar pagos
- ❌ No puede modificar configuración del sistema

### 4. Asesor

**Permisos:** 15+ permisos (ventas y atención)

**Capacidades:**
- ✅ Crear y editar clientes
- ✅ Ver productos disponibles
- ✅ Ver recetas
- ✅ Crear y editar cotizaciones propias
- ✅ Ver préstamos
- ✅ Registrar pagos
- ✅ Chat interno
- ✅ Ver dashboard

**Restricciones:**
- ❌ No puede gestionar usuarios
- ❌ No puede gestionar aportadores
- ❌ No puede aprobar cotizaciones
- ❌ No puede convertir cotizaciones a préstamos
- ❌ No puede aprobar préstamos
- ❌ No puede eliminar registros
- ❌ No puede acceder a reportes avanzados

### 5. Cajero

**Permisos:** 8 permisos (operaciones de caja)

**Capacidades:**
- ✅ Ver clientes
- ✅ Ver préstamos
- ✅ Registrar pagos
- ✅ Chat interno
- ✅ Ver dashboard básico

**Restricciones:**
- ❌ No puede crear o editar clientes
- ❌ No puede gestionar usuarios
- ❌ No puede crear cotizaciones o préstamos
- ❌ No puede aprobar operaciones
- ❌ Solo consulta y registro de pagos

## 🔐 Permisos Disponibles

### Usuarios (5 permisos)
- `ver-usuarios` - Ver listado de usuarios
- `crear-usuarios` - Crear nuevos usuarios
- `editar-usuarios` - Editar usuarios existentes
- `eliminar-usuarios` - Eliminar usuarios
- `asignar-roles` - Asignar roles a usuarios

### Roles (5 permisos)
- `ver-roles` - Ver listado de roles
- `crear-roles` - Crear nuevos roles
- `editar-roles` - Editar roles existentes
- `eliminar-roles` - Eliminar roles
- `asignar-permisos` - Asignar permisos a roles

### Clientes (4 permisos)
- `ver-clientes`
- `crear-clientes`
- `editar-clientes`
- `eliminar-clientes`

### Aportadores (6 permisos)
- `ver-aportadores`
- `crear-aportadores`
- `editar-aportadores`
- `eliminar-aportadores`
- `agregar-capital-aportadores`
- `retirar-capital-aportadores`

### Productos (5 permisos)
- `ver-productos`
- `crear-productos`
- `editar-productos`
- `eliminar-productos`
- `importar-productos`

### Recetas (5 permisos)
- `ver-recetas`
- `crear-recetas`
- `editar-recetas`
- `eliminar-recetas`
- `clonar-recetas`

### Cotizaciones (6 permisos)
- `ver-cotizaciones`
- `crear-cotizaciones`
- `editar-cotizaciones`
- `eliminar-cotizaciones`
- `aprobar-cotizaciones`
- `convertir-cotizaciones`

### Préstamos (5 permisos)
- `ver-prestamos`
- `crear-prestamos`
- `editar-prestamos`
- `eliminar-prestamos`
- `aprobar-prestamos`

### Pagos (3 permisos)
- `ver-pagos`
- `registrar-pagos`
- `eliminar-pagos`

### Reportes (2 permisos)
- `ver-reportes`
- `exportar-reportes`

### Chat (2 permisos)
- `ver-chat`
- `enviar-mensajes`

### Configuración (2 permisos)
- `ver-configuracion`
- `editar-configuracion`

### Dashboard (1 permiso)
- `ver-dashboard`

## 👥 Gestión de Usuarios

### Crear Usuario

1. Acceder a **Usuarios** en el menú principal
2. Click en **Nuevo Usuario**
3. Completar el formulario:
   - Nombre completo
   - Email (único en el sistema)
   - Contraseña (mínimo 8 caracteres)
   - Confirmar contraseña
   - Seleccionar rol
4. Click en **Crear Usuario**

### Editar Usuario

1. En el listado de usuarios, click en **Editar**
2. Modificar los datos necesarios:
   - Nombre
   - Email
   - Contraseña (opcional, dejar en blanco para no cambiar)
3. Click en **Actualizar Usuario**

### Cambiar Rol de Usuario

1. En el listado de usuarios, click en **Cambiar Rol**
2. Seleccionar el nuevo rol en el modal
3. Click en **Guardar**

### Eliminar Usuario

1. En el listado de usuarios, click en **Eliminar**
2. Confirmar la eliminación

**Restricciones:**
- No puedes eliminar tu propio usuario
- No puedes eliminar el último Super Admin

### Ver Detalles de Usuario

1. En el listado de usuarios, click en **Ver**
2. Se muestra:
   - Información del usuario
   - Rol asignado
   - Permisos del rol

### Filtrar Usuarios

En el listado de usuarios puedes:
- Buscar por nombre o email
- Filtrar por rol
- Ver foto de perfil
- Ver fecha de registro

## 🎭 Gestión de Roles

### Crear Rol

1. Acceder a **Roles** en el menú
2. Click en **Nuevo Rol**
3. Ingresar nombre del rol
4. Seleccionar permisos organizados por módulo:
   - Usuarios
   - Roles
   - Clientes
   - Aportadores
   - Productos
   - Recetas
   - Cotizaciones
   - Préstamos
   - Pagos
   - Reportes
   - Chat
   - Configuración
   - Dashboard
5. Click en **Crear Rol**

### Editar Rol

1. En el listado de roles, click en **Editar**
2. Modificar nombre si es necesario
3. Actualizar permisos
4. Click en **Actualizar Rol**

### Eliminar Rol

1. En el listado de roles, click en **Eliminar**
2. Confirmar eliminación

**Restricción:**
- No se puede eliminar un rol que tiene usuarios asignados

### Ver Detalles de Rol

1. En el listado de roles, click en **Ver**
2. Se muestra:
   - Nombre del rol
   - Cantidad de usuarios asignados
   - Lista de permisos
   - Lista de usuarios con este rol

## 💡 Casos de Uso

### Caso 1: Nuevo Empleado Asesor

**Escenario:** Contratar un nuevo asesor de ventas

**Pasos:**
1. Super Admin o Administrador accede a Usuarios
2. Click en Nuevo Usuario
3. Ingresar datos:
   ```
   Nombre: Roberto Ventas
   Email: roberto.ventas@credihome.com
   Contraseña: temporal123
   Rol: Asesor
   ```
4. Click en Crear Usuario
5. El nuevo asesor podrá:
   - Gestionar clientes
   - Crear cotizaciones
   - Registrar pagos
   - Usar el chat

### Caso 2: Promoción de Asesor a Gerente

**Escenario:** Un asesor es promovido a gerente

**Pasos:**
1. Administrador accede a Usuarios
2. Localiza al usuario asesor
3. Click en Cambiar Rol
4. Selecciona "Gerente"
5. Click en Guardar
6. El usuario ahora tiene permisos de gerente

### Caso 3: Crear Rol Personalizado

**Escenario:** Necesitas un rol "Supervisor de Pagos"

**Pasos:**
1. Super Admin accede a Roles
2. Click en Nuevo Rol
3. Nombre: "Supervisor de Pagos"
4. Seleccionar permisos:
   - ✅ ver-clientes
   - ✅ ver-prestamos
   - ✅ ver-pagos
   - ✅ registrar-pagos
   - ✅ eliminar-pagos
   - ✅ ver-reportes
   - ✅ exportar-reportes
   - ✅ ver-chat
   - ✅ enviar-mensajes
   - ✅ ver-dashboard
5. Click en Crear Rol
6. Asignar usuarios a este rol

### Caso 4: Auditar Permisos de Usuario

**Escenario:** Verificar qué puede hacer un usuario

**Pasos:**
1. Acceder a Usuarios
2. Click en Ver del usuario
3. Revisar sección "Permisos del Rol"
4. Se muestran todos los permisos activos

### Caso 5: Usuario Sale de la Empresa

**Escenario:** Un empleado termina su contrato

**Pasos:**
1. Administrador accede a Usuarios
2. Localiza al usuario
3. Click en Eliminar
4. Confirmar eliminación
5. El usuario ya no podrá acceder al sistema

**Nota:** Los registros creados por el usuario se mantienen en el sistema.

## 🔒 Seguridad

### Mejores Prácticas

1. **Contraseñas:**
   - Mínimo 8 caracteres
   - Cambiar contraseñas predeterminadas
   - Usar contraseñas fuertes en producción

2. **Roles:**
   - Asignar el rol con menos privilegios necesario
   - Revisar periódicamente los permisos de roles
   - No dar permisos innecesarios

3. **Usuarios:**
   - Eliminar usuarios inactivos
   - Revisar accesos periódicamente
   - Mantener actualizada la información de contacto

4. **Auditoría:**
   - Revisar logs de acceso
   - Monitorear cambios en roles
   - Verificar asignaciones de permisos

## 🛠️ Comandos Útiles

### Regenerar Usuarios y Roles

```bash
# Recrear toda la base de datos con usuarios de ejemplo
php artisan migrate:fresh --seed
```

### Limpiar Caché de Permisos

```bash
# Limpiar caché después de cambios en permisos
php artisan cache:forget spatie.permission.cache
```

### Verificar Permisos en Tinker

```bash
php artisan tinker

# Ver todos los roles
Role::with('permissions')->get();

# Ver permisos de un usuario
User::find(1)->permissions;

# Ver roles de un usuario
User::find(1)->roles;

# Verificar si un usuario tiene un permiso
User::find(1)->can('crear-usuarios');

# Verificar si un usuario tiene un rol
User::find(1)->hasRole('Super Admin');
```

## 📊 Estadísticas del Sistema

**Total de Roles:** 5 predefinidos + personalizados
**Total de Permisos:** 70+
**Total de Usuarios Ejemplo:** 6

## 🆘 Problemas Comunes

### No puedo acceder después de los seeders

**Solución:** Usa civernet@gmail.com / admin123

### No veo el botón para crear usuarios

**Solución:** Verifica que tu rol tenga el permiso `crear-usuarios`

### Error al asignar rol

**Solución:** Verifica que el rol exista en la tabla roles

### No puedo eliminar un rol

**Solución:** Primero reasigna los usuarios de ese rol a otro rol

### Cambié permisos pero no se reflejan

**Solución:** Cierra sesión y vuelve a iniciar, o limpia la caché

## 📞 Soporte

Para problemas con la gestión de usuarios, contacta al Super Admin del sistema.

---

**Sistema CrediHome** - Gestión Integral de Préstamos
**Versión:** 1.0
**Fecha:** Enero 2026
