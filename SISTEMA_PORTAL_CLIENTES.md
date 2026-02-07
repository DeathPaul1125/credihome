# Portal de Clientes - Sistema de Comprobantes de Pago

## Descripción General

El portal de clientes permite a los usuarios finales (clientes con préstamos activos) acceder a una plataforma donde pueden:

1. Ver el estado de sus préstamos
2. Consultar la tabla de amortización
3. Subir comprobantes de pago
4. Hacer seguimiento del estado de sus comprobantes

Los administradores pueden validar estos comprobantes, aprobarlos (registrando el pago automáticamente) o rechazarlos.

---

## 🏗️ Estructura del Sistema

### Tablas de Base de Datos

#### `comprobantes_pago`
Almacena los comprobantes subidos por los clientes.

**Campos principales:**
- `numero_comprobante`: Código único auto-generado (COMP-2026-000001)
- `prestamo_id`: Préstamo al que aplica el pago
- `cliente_id`: Cliente que sube el comprobante
- `monto_pagado`: Monto que dice haber pagado
- `fecha_pago`: Fecha en que realizó el pago
- `metodo_pago`: Transferencia, Depósito, Efectivo, Cheque
- `referencia_pago`: Número de boleta o referencia
- `archivo_comprobante`: Ruta al archivo (JPG, PNG, PDF)
- `estado`: pendiente | aprobado | rechazado
- `validado_por`: ID del usuario admin que validó
- `fecha_validacion`: Cuándo se validó
- `pago_id`: ID del pago registrado (si fue aprobado)
- `motivo_rechazo`: Razón del rechazo (si fue rechazado)
- `notas`: Notas del cliente
- `notas_validacion`: Notas del validador

#### Adición a tabla `clientes`
- `portal_user_id`: Relación con la tabla `users` (usuario del portal)
- `portal_activo`: Boolean, permite habilitar/deshabilitar acceso al portal

---

## 🎯 Funcionalidades

### Para Clientes (Portal)

#### 1. Dashboard (`/portal/dashboard`)
- Tarjetas con estadísticas: Total de préstamos, Activos, Total adeudado, Comprobantes pendientes
- Tabla de préstamos activos con botón "Subir Comprobante"
- Lista de comprobantes recientes

#### 2. Ver Detalle de Préstamo (`/portal/prestamo/{id}`)
- Información completa del préstamo
- Barra de progreso visual
- Tabla de amortización con todas las cuotas
- Historial de comprobantes para ese préstamo
- Botón para subir nuevo comprobante

#### 3. Subir Comprobante (`/portal/prestamo/{id}/subir-comprobante`)
Formulario con:
- Monto pagado
- Fecha de pago
- Método de pago (Transferencia, Depósito, Efectivo, Cheque)
- Número de referencia/boleta
- Archivo del comprobante (máx 5MB, JPG/PNG/PDF)
- Notas adicionales

**Validaciones:**
- Usuario debe ser el propietario del préstamo
- Préstamo debe estar activo o en mora
- Archivo obligatorio (max 5MB)
- Formatos permitidos: jpg, jpeg, png, pdf

#### 4. Mis Comprobantes (`/portal/mis-comprobantes`)
- Listado de todos los comprobantes subidos
- Filtrado por estado
- Acceso al detalle de cada comprobante

#### 5. Ver Comprobante (`/portal/comprobante/{id}`)
- Información detallada del comprobante
- Vista previa del archivo subido
- Estado actual (Pendiente, Aprobado, Rechazado)
- Si fue rechazado: muestra el motivo
- Si fue aprobado: muestra la fecha de aprobación

---

### Para Administradores

#### 1. Lista de Comprobantes (`/admin/comprobantes`)
- Tabla con todos los comprobantes
- Filtro por estado (Pendiente por defecto)
- Información: Número, Cliente, Préstamo, Monto, Fecha, Estado
- Botón para ver detalle

#### 2. Validar Comprobante (`/admin/comprobantes/{id}`)

**Vista dividida en 3 secciones:**

1. **Información del Comprobante**
   - Datos del cliente y préstamo
   - Monto y método de pago
   - Referencia y notas del cliente

2. **Vista Previa**
   - Muestra la imagen o PDF subido
   - Botón de descarga

3. **Acciones de Validación** (solo si está pendiente)
   
   **a) Aprobar Comprobante:**
   - Puede ajustar el monto si es necesario
   - Puede ajustar la fecha de pago
   - Campo para notas de validación
   - Al aprobar:
     * Se crea un registro en la tabla `pagos`
     * Se actualiza el `saldo_pendiente` del préstamo
     * Si el saldo llega a 0, el préstamo pasa a estado "pagado"
     * El comprobante se marca como "aprobado"

   **b) Rechazar Comprobante:**
   - Campo obligatorio: Motivo de rechazo
   - Este motivo se muestra al cliente
   - El comprobante se marca como "rechazado"

---

## 🔗 Relaciones del Sistema

```
User (Portal)
  └─> Cliente (portal_user_id)
        ├─> Prestamos
        │     ├─> ComprobantePago
        │     └─> Pagos (creados desde comprobantes aprobados)
        └─> ComprobantePago
```

---

## 📂 Archivos Creados/Modificados

### Modelos
- ✅ `app/Models/ComprobantePago.php` - Modelo principal con auto-numeración
- ✅ `app/Models/Cliente.php` - Añadidas relaciones portal_user_id y comprobantes

### Controladores
- ✅ `app/Http/Controllers/PortalClienteController.php` - Controlador del portal (6 métodos)
- ✅ `app/Http/Controllers/Admin/ComprobantePagoController.php` - Validación admin (4 métodos)

### Rutas
- ✅ `routes/web.php` - Rutas del portal y rutas de administración

### Migraciones
- ✅ `database/migrations/2026_02_07_223140_create_comprobantes_pago_table.php`
- ✅ `database/migrations/2026_02_07_223203_add_portal_fields_to_clientes_table.php`

### Vistas - Portal del Cliente
- ✅ `resources/views/portal-cliente/dashboard.blade.php`
- ✅ `resources/views/portal-cliente/prestamo-detalle.blade.php`
- ✅ `resources/views/portal-cliente/subir-comprobante.blade.php`
- ✅ `resources/views/portal-cliente/mis-comprobantes.blade.php`
- ✅ `resources/views/portal-cliente/comprobante-detalle.blade.php`

### Vistas - Administración
- ✅ `resources/views/admin/comprobantes/index.blade.php`
- ✅ `resources/views/admin/comprobantes/show.blade.php`

---

## 🚀 Cómo Habilitar el Portal para un Cliente

### Opción 1: Manualmente en la Base de Datos
```sql
-- 1. Crear un usuario en la tabla users si no existe
INSERT INTO users (name, email, password, ...) VALUES (...);

-- 2. Vincular el cliente con el usuario del portal
UPDATE clientes 
SET portal_user_id = [ID_DEL_USUARIO], 
    portal_activo = 1 
WHERE id = [ID_DEL_CLIENTE];
```

### Opción 2: Desde la Interfaz de Administración (Próximamente)
Se puede agregar una sección en el formulario de edición de clientes para:
- Crear usuario del portal
- Asignar credenciales
- Activar/desactivar acceso

---

## 🔐 Seguridad

### Autenticación
- Usa el middleware `auth:sanctum` de Laravel Jetstream
- Verificación de email requerida

### Autorización
- Cada método verifica que el cliente sea propietario del recurso
- Se utiliza `portal_user_id` para relacionar usuarios con clientes
- Campo `portal_activo` permite deshabilitar acceso sin borrar credenciales

### Validación de Archivos
- Máximo 5MB
- Solo imágenes (jpg, jpeg, png) y PDF
- Los archivos se almacenan en `storage/app/public/comprobantes/`

---

## 📊 Flujo de Trabajo Típico

1. **Cliente sube comprobante:**
   - Accede al portal (`/portal/dashboard`)
   - Selecciona su préstamo
   - Sube foto/PDF del comprobante con datos del pago
   - Estado: **Pendiente**

2. **Administrador recibe notificación** (próximamente)
   - Accede a `/admin/comprobantes`
   - Ve el comprobante en estado **Pendiente**

3. **Administrador valida:**
   - Revisa el archivo
   - Verifica monto y fecha
   
   **Si es válido:**
   - Click en "Aprobar"
   - Se crea automáticamente el pago
   - Se actualiza el saldo del préstamo
   - Estado: **Aprobado** ✅
   
   **Si no es válido:**
   - Click en "Rechazar"
   - Escribe motivo (ej: "Comprobante ilegible")
   - Estado: **Rechazado** ❌

4. **Cliente ve resultado:**
   - Estado actualizado en "Mis Comprobantes"
   - Si fue rechazado, puede subir uno nuevo

---

## ⚙️ Configuración del Sistema

### Almacenamiento de Archivos
Los comprobantes se guardan en:
```
storage/app/public/comprobantes/
```

Para que sean accesibles públicamente, ejecuta:
```bash
php artisan storage:link
```

### Permisos de Carpetas
```bash
# Windows (PowerShell como administrador)
icacls "storage" /grant Users:F /T
icacls "bootstrap/cache" /grant Users:F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
```

---

## 🔄 Próximas Mejoras Sugeridas

### Notificaciones
- [ ] Enviar email al admin cuando se suba un comprobante
- [ ] Enviar email al cliente cuando se apruebe/rechace
- [ ] Notificaciones en tiempo real con Pusher/Laravel Echo

### Dashboard de Admin
- [ ] Widget "Comprobantes Pendientes" en el dashboard principal
- [ ] Contador de notificaciones sin leer

### Gestión de Clientes
- [ ] Sección en el CRUD de clientes para crear usuarios del portal
- [ ] Botón "Enviar credenciales por email"
- [ ] Reseteo de contraseña desde admin

### Mejoras del Portal
- [ ] Historial de pagos aprobados
- [ ] Cálculo de próxima cuota a pagar
- [ ] Recordatorios de fechas de pago

### Auditoría
- [ ] Log de todas las validaciones (quién, cuándo, qué decidió)
- [ ] Historial de cambios en los comprobantes

---

## 🐛 Solución de Problemas

### "No se encontró el archivo"
- Verifica que `php artisan storage:link` haya sido ejecutado
- Revisa que la carpeta `storage/app/public/comprobantes` exista y tenga permisos

### "Unauthorized" en el portal
- Verifica que el cliente tenga `portal_user_id` asignado
- Verifica que `portal_activo = 1`

### "Archivo demasiado grande"
- Aumenta el límite en `php.ini`:
  ```ini
  upload_max_filesize = 10M
  post_max_size = 10M
  ```
- Reinicia el servidor web

---

## 📞 Soporte

Para ayuda adicional o reportar bugs, contacta al equipo de desarrollo.
