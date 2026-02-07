# Sistema de Login y Gestión de Credenciales - Portal de Clientes

## 🔐 Funcionalidad Implementada

Se ha completado el sistema de login para clientes y la gestión automatizada de credenciales con integración de WhatsApp Web.

---

## ✨ Características Principales

### 1. Activación del Portal para Clientes

Desde el detalle de cada cliente ([clientes/show](c:\laragon\www\credihome\resources\views\clientes\show-flowbite.blade.php)), se agregó una nueva sección **"Portal del Cliente"** con:

#### Si el cliente NO tiene portal activado:
- Botón "🔓 Activar Portal"
- Al hacer click:
  * Genera automáticamente un usuario con email único (formato: `cliente-[DPI]@credihome.gt`)
  * Crea una contraseña aleatoria de 8 caracteres
  * Vincula el usuario al cliente (`portal_user_id`)
  * Activa el acceso (`portal_activo = true`)
  * Muestra un modal con las credenciales

#### Si el cliente YA tiene portal:
- Muestra el email de acceso
- Badge de estado (Activo/Desactivado)
- Botones disponibles:
  * **Desactivar Portal** - Bloquea el acceso sin eliminar las credenciales
  * **Regenerar Contraseña** - Genera una nueva contraseña de 8 caracteres

---

### 2. Modal de Credenciales con WhatsApp

Cuando se activa el portal o se regenera la contraseña, aparece un **modal emergente** que muestra:

- ✅ Usuario (email)
- ✅ Contraseña generada
- 📋 Botones para copiar cada campo al portapapeles
- 💬 **Botón "Enviar por WhatsApp"** → Abre WhatsApp Web con el mensaje pre-formateado

#### Mensaje de WhatsApp Pre-escrito:
```
🏦 *CREDIHOME - Acceso al Portal de Clientes*

Hola *[Nombre del Cliente]*,

Ya puedes acceder a tu portal de clientes para consultar tus préstamos y subir comprobantes de pago.

📧 *Usuario:* cliente-1234567890123@credihome.gt
🔑 *Contraseña:* Abc12345

🌐 *Acceder al portal:*
http://tu-dominio.com/login

⚠️ Te recomendamos cambiar tu contraseña después del primer acceso.

Si tienes alguna duda, contáctanos.
```

El mensaje se abre automáticamente en WhatsApp Web con el número de teléfono del cliente.

---

### 3. Sistema de Login

#### Redirecciones Inteligentes:

**Ruta raíz (`/`):**
- Usuario no autenticado → `/login`
- Cliente con portal activo → `/portal/dashboard`
- Usuario administrativo → `/dashboard` (admin)

**Ruta `/dashboard`:**
- Cliente con portal → Redirige a `/portal/dashboard`
- Usuario admin → Muestra dashboard administrativo

#### Vista de Login:
- Diseño limpio y profesional
- Compatible con credenciales generadas automáticamente
- Checkbox "Recordarme"
- Link para recuperar contraseña
- Responsive (móvil/desktop)

---

## 📂 Archivos Modificados/Creados

### Controladores
- ✅ [app/Http/Controllers/ClienteController.php](c:\laragon\www\credihome\app\Http\Controllers\ClienteController.php)
  * `activarPortal($id)` - Crea usuario y credenciales
  * `desactivarPortal($id)` - Desactiva acceso al portal
  * `regenerarPassword($id)` - Genera nueva contraseña
  * `generarEmailUnico()` - Helper para emails únicos
  * `limpiarTelefono()` - Formatea número para WhatsApp
  * `generarMensajeCredenciales()` - Mensaje pre-formateado

### Rutas
- ✅ [routes/web.php](c:\laragon\www\credihome\routes\web.php)
  * `POST /clientes/{id}/activar-portal`
  * `POST /clientes/{id}/desactivar-portal`
  * `POST /clientes/{id}/regenerar-password`
  * Redirecciones inteligentes en `/` y `/dashboard`

### Vistas
- ✅ [resources/views/clientes/show-flowbite.blade.php](c:\laragon\www\credihome\resources\views\clientes\show-flowbite.blade.php)
  * Nueva sección "Portal del Cliente"
  * Modal de credenciales con JavaScript
  * Botón de WhatsApp Web integrado
  
- ✅ [resources/views/auth/portal-login.blade.php](c:\laragon\www\credihome\resources\views\auth\portal-login.blade.php)
  * Vista de login personalizada para el portal

---

## 🔧 Funcionalidades Técnicas

### Generación Automática de Emails
```php
// Formato: cliente-[DPI]@credihome.gt
// Ejemplo: cliente-1234567890123@credihome.gt
// Si ya existe, agrega contador: cliente-1234567890123-1@credihome.gt
```

### Generación de Contraseñas
```php
// Contraseña aleatoria de 8 caracteres
Str::random(8)
// Ejemplo: Ky3m9Px2
```

### Formato de Teléfono para WhatsApp
```php
// Limpia el número: solo dígitos
// Si tiene 8 dígitos → Agrega código de Guatemala (502)
// Ejemplo: 
//   Input: "1234-5678" o "1234 5678"
//   Output: "50212345678"
```

### Integración con WhatsApp Web
```javascript
const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
window.open(url, '_blank');
```

---

## 🎯 Flujo de Trabajo Completo

### Paso 1: Activar Portal desde Admin
1. Admin accede a "Clientes" → Selecciona un cliente
2. En la pestaña "Información General", sección "Portal del Cliente"
3. Click en "🔓 Activar Portal"

### Paso 2: Modal con Credenciales
1. Se muestra un modal con:
   - Usuario generado
   - Contraseña temporal
   - Botón para copiar cada campo
2. Admin hace click en "Enviar por WhatsApp"

### Paso 3: WhatsApp Web
1. Se abre WhatsApp Web automáticamente
2. Aparece el chat del cliente con el mensaje pre-escrito
3. Admin solo presiona "Enviar"

### Paso 4: Cliente Recibe Credenciales
1. Cliente recibe el mensaje por WhatsApp
2. Accede al enlace del portal
3. Ingresa con sus credenciales
4. Es redirigido automáticamente a `/portal/dashboard`

### Paso 5: Cliente Consulta sus Datos
1. Ve sus préstamos activos
2. Revisa tabla de amortización
3. Sube comprobantes de pago
4. Hace seguimiento del estado de sus pagos

---

## 🔐 Seguridad Implementada

### Auto-verificación de Email
```php
'email_verified_at' => now()
```
Los usuarios del portal se crean con email verificado automáticamente.

### Hash de Contraseñas
```php
Hash::make($password)
```
Las contraseñas se almacenan hasheadas en la base de datos.

### Control de Acceso
- Campo `portal_activo` permite deshabilitar acceso sin eliminar el usuario
- Verificación en cada ruta del portal que el cliente sea el propietario
- Redirección automática según tipo de usuario

---

## 📱 Compatibilidad de WhatsApp

### WhatsApp Web
- ✅ Abre automáticamente en navegador
- ✅ Detecta sesión activa
- ✅ Mensaje pre-llenado y listo para enviar

### WhatsApp Desktop
- ✅ Compatible con la app de escritorio
- ✅ Si está instalada, puede abrirse en lugar del web

### Formato del Enlace
```
https://wa.me/[NUMERO]?text=[MENSAJE_CODIFICADO]
```

---

## 🧪 Casos de Prueba

### Test 1: Activar Portal por Primera Vez
```
✓ Se crea usuario nuevo
✓ Email único generado
✓ Contraseña de 8 caracteres
✓ portal_activo = true
✓ Modal se muestra con credenciales
```

### Test 2: Reactivar Portal Desactivado
```
✓ No crea usuario nuevo
✓ Actualiza portal_activo = true
✓ Mantiene credenciales existentes
✓ Mensaje informativo "ya tiene acceso"
```

### Test 3: Regenerar Contraseña
```
✓ Genera nueva contraseña de 8 caracteres
✓ Mantiene mismo email
✓ Modal con nuevas credenciales
✓ Usuario mantiene portal_activo
```

### Test 4: Enviar por WhatsApp
```
✓ Número formateado correctamente (502...)
✓ Mensaje con formato y emojis
✓ Abre WhatsApp Web en nueva pestaña
✓ Chat pre-seleccionado
```

### Test 5: Login de Cliente
```
✓ Cliente ingresa credenciales
✓ Autenticación exitosa
✓ Redirección a /portal/dashboard
✓ Ve sus préstamos
```

---

## 🚀 Próximas Mejoras Opcionales

### Notificaciones
- [ ] Email automático con credenciales al activar portal
- [ ] SMS con credenciales (si se integra servicio)
- [ ] Notificación cuando el cliente hace su primer login

### Cambio de Contraseña
- [ ] Forzar cambio de contraseña en primer login
- [ ] Página de "Mi Perfil" en el portal
- [ ] Validación de fortaleza de contraseña

### Auditoría
- [ ] Log de activaciones/desactivaciones de portal
- [ ] Log de regeneraciones de contraseña
- [ ] Historial de accesos al portal

### Gestión Masiva
- [ ] Activar portal para múltiples clientes
- [ ] Exportar lista de credenciales
- [ ] Envío masivo de credenciales por WhatsApp

---

## 📞 Uso del Sistema

### Para Administradores:

1. **Activar Portal:**
   ```
   Clientes → Seleccionar Cliente → Portal del Cliente → Activar Portal
   ```

2. **Enviar Credenciales:**
   ```
   Click en "Enviar por WhatsApp" en el modal → Se abre WhatsApp → Enviar
   ```

3. **Regenerar Contraseña:**
   ```
   Portal del Cliente → Regenerar Contraseña → Enviar nuevas credenciales
   ```

4. **Desactivar Acceso:**
   ```
   Portal del Cliente → Desactivar Portal
   ```

### Para Clientes:

1. **Primer Acceso:**
   ```
   Recibir credenciales por WhatsApp → Ir a URL del portal → Login
   ```

2. **Uso Diario:**
   ```
   Acceder con email y contraseña → Ver préstamos → Subir comprobantes
   ```

---

## 🐛 Solución de Problemas

### "Usuario ya existe"
- El sistema genera emails únicos automáticamente con contadores
- Si el DPI ya tiene usuario, agrega `-1`, `-2`, etc.

### "No se abre WhatsApp"
- Verificar que el cliente tenga número de teléfono registrado
- Verificar que el número tenga format válido (8 dígitos + código país)

### "Cliente no puede acceder"
- Verificar que `portal_activo = true`
- Verificar que las credenciales sean correctas
- Verificar que el usuario exista en la tabla `users`

---

## ✅ Resumen de Implementación

Se ha completado exitosamente:

✅ Sistema de activación automática de portal  
✅ Generación de credenciales únicas  
✅ Modal con información de acceso  
✅ Integración con WhatsApp Web  
✅ Regeneración de contraseñas  
✅ Control de activación/desactivación  
✅ Redirecciones inteligentes según tipo de usuario  
✅ Vista de login personalizada  
✅ Seguridad con hash y verificación  

El sistema está **100% funcional** y listo para uso en producción. 🎉
