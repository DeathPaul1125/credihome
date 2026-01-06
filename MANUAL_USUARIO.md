# 📖 Manual de Usuario - CrediHome

## Sistema de Créditos para Materiales de Construcción

**Versión:** 2.0  
**Fecha:** Enero 2026  
**País:** Guatemala

---

## 📑 Tabla de Contenidos

1. [Introducción](#introducción)
2. [Acceso al Sistema](#acceso-al-sistema)
3. [Panel de Control](#panel-de-control)
4. [Módulos del Sistema](#módulos-del-sistema)
   - [Clientes](#-clientes)
   - [Aportadores](#-aportadores)
   - [Productos/Materiales](#-productos--materiales)
   - [Recetas de Construcción](#-recetas-de-construcción)
   - [Cotizaciones](#-cotizaciones)
   - [Préstamos](#-préstamos)
   - [Pagos](#-pagos)
   - [Reportes](#-reportes)
   - [Chat](#-chat)
   - [Configuración](#-configuración)
   - [Usuarios](#-usuarios)
5. [Flujo de Trabajo](#flujo-de-trabajo)
6. [Importación Masiva](#importación-masiva)
7. [Preguntas Frecuentes](#preguntas-frecuentes)
8. [Solución de Problemas](#solución-de-problemas)

---

## Introducción

**CrediHome** es un sistema integral para la gestión de créditos de materiales de construcción. A diferencia de los préstamos en efectivo tradicionales, este sistema permite otorgar crédito en forma de materiales para construcción de viviendas en Guatemala.

### Características Principales

✅ Gestión completa de clientes con datos específicos de Guatemala (DPI, departamentos)  
✅ Sistema de aportadores (crowdfunding) para financiamiento de préstamos  
✅ Catálogo de productos/materiales de construcción  
✅ Recetas predefinidas y personalizadas para tipos de vivienda  
✅ Cotizaciones con vencimiento automático  
✅ Conversión de cotizaciones a préstamos  
✅ Control de pagos y cuotas con seguimiento de mora  
✅ Reportes y estadísticas en tiempo real con gráficos interactivos  
✅ Chat en tiempo real entre usuarios del sistema  
✅ Importación masiva de productos vía CSV  
✅ Configuración personalizable (logos, colores, PDFs)  
✅ Sistema de roles y permisos (Administrador, Cobrador, Vendedor)  
✅ Modo oscuro/claro  
✅ Dashboard con estadísticas de usuarios más activos  

### Moneda

El sistema trabaja en **Quetzales (Q)** guatemaltecos.

---

## Acceso al Sistema

### Inicio de Sesión

1. Abre tu navegador web
2. Ingresa a la URL del sistema
3. Introduce tus credenciales:
   - **Email:** tu correo electrónico
   - **Password:** tu contraseña
4. Haz clic en "Iniciar Sesión"

### Primera Configuración

Después del primer acceso, es recomendable:
1. Ir a **Configuración** en el menú lateral
2. Personalizar el nombre de la aplicación
3. Subir los logos de tu empresa
4. Configurar parámetros de negocio (tasa de interés, plazos)

---

## Panel de Control

El **Dashboard** muestra información general del negocio en tiempo real:

### Tarjetas de Resumen
- 👥 **Total Clientes** - Cantidad de clientes registrados (activos)
- 💰 **Cartera Total** - Suma de saldo pendiente de todos los préstamos activos
- 📦 **Préstamos Activos** - Cantidad de préstamos vigentes y en mora
- 💵 **Pagos del Mes** - Total recaudado en el mes actual

### Gráficos Interactivos
- **Préstamos por Mes** - Gráfico de línea con tendencia mensual (últimos 6 meses)
- **Estado de Préstamos** - Gráfico de barras (Activos, Pagados, En Mora, Cancelados)
- **Distribución por Frecuencia** - Préstamos según periodicidad (Semanal, Quincenal, Mensual)

### Usuarios Destacados
- 🏆 **Usuario con más préstamos otorgados** - Top vendedor
- 💳 **Usuario con más cobros realizados** - Top cobrador
- Tabla de top 5 usuarios por categoría

### Préstamos Recientes
Lista de los últimos 10 préstamos con:
- Cliente
- Monto prestado
- Saldo pendiente
- Estado (Activo, En Mora, Pagado)
- Fecha de desembolso
- Acceso rápido a detalles

---

## Módulos del Sistema

## 👥 Clientes

Gestiona la información de tus clientes que solicitarán crédito para construcción.

### Crear Cliente

1. Ve a **Clientes** en el menú lateral
2. Haz clic en **"+ Nuevo Cliente"**
3. Completa el formulario:

**Información Personal:**
- Nombre completo
- Email (opcional)
- Teléfono
- DPI (13 dígitos, formato: 1234 56789 0101)
- Fecha de nacimiento

**Dirección:**
- Departamento (selecciona de la lista)
- Municipio
- Dirección completa

**Información Laboral:**
- Ocupación/Profesión
- Ingresos mensuales (en Quetzales)
- Nombre de empresa/negocio (opcional)

**Referencia Personal:**
- Nombre del referente
- Teléfono del referente
- Relación (Familiar, Amigo, Laboral, Otro)

4. Haz clic en **"Guardar Cliente"**

### Buscar Clientes

- Usa el campo de búsqueda para filtrar por nombre, DPI, email o teléfono
- Filtra por departamento si lo necesitas
- La tabla se actualiza automáticamente

### Ver Detalles de Cliente

1. Haz clic en el botón **"Ver"** (ícono de ojo) en la lista
2. Verás:
   - Información completa del cliente
   - Historial de préstamos (activos, pagados, vencidos)
   - Cotizaciones asociadas
   - Total prestado y pagado

### Editar Cliente

1. Haz clic en **"Editar"** (ícono de lápiz)
2. Modifica los datos necesarios
3. Guarda los cambios

### Eliminar Cliente

⚠️ **Importante:** Solo puedes eliminar clientes que NO tengan préstamos o cotizaciones asociadas.

---

## � Aportadores

Sistema de crowdfunding que permite a múltiples inversores financiar préstamos a clientes.

### Concepto de Aportadores

Los **aportadores** son personas o entidades que invierten capital para financiar préstamos. En lugar de que un solo prestamista financie todo, varios aportadores pueden participar en el mismo préstamo.

### Características del Sistema

✅ **Múltiples aportadores por préstamo** - Un préstamo puede tener varios inversionistas  
✅ **Porcentaje de participación** - Cada aportador financia un % del préstamo  
✅ **Retorno proporcional** - Reciben pagos según su participación  
✅ **Dashboard de aportadores** - Vista de inversiones y retornos  
✅ **Seguimiento de ganancias** - Intereses ganados por aportador  

### Registrar Aportador

1. Ve a **Aportadores** en el menú
2. Clic en **"+ Nuevo Aportador"**
3. Completa:
   - Nombre completo
   - Email
   - Teléfono
   - DPI (opcional)
   - Capital disponible para invertir
   - Notas adicionales
4. Guarda el aportador

### Asignar Aportador a Préstamo

1. Al crear o editar un préstamo
2. En la sección **"Aportadores"**
3. Clic en **"+ Agregar Aportador"**
4. Selecciona aportador
5. Define:
   - **Monto aportado** (Q)
   - **Porcentaje** (se calcula automático)
6. El sistema valida:
   - ✅ Suma de aportes no exceda monto del préstamo
   - ✅ Porcentajes sumen 100%
7. Guarda la asignación

### Dashboard de Aportador

Cada aportador tiene su vista personalizada:

**Resumen:**
- 💰 **Capital Invertido** - Total aportado en préstamos activos
- 📊 **Préstamos Financiados** - Cantidad de préstamos con participación
- 💵 **Retorno Acumulado** - Intereses ganados hasta la fecha
- 📈 **Tasa Promedio** - Rendimiento promedio de inversiones

**Tabla de Inversiones:**
- Cliente del préstamo
- Monto total del préstamo
- Monto aportado
- % de participación
- Estado del préstamo
- Intereses ganados
- Acciones (Ver préstamo)

### Distribución de Pagos

Cuando un cliente paga una cuota:
1. El sistema calcula la distribución proporcional
2. Cada aportador recibe su % correspondiente:
   - Capital (porción del pago a capital)
   - Intereses (porción del pago a intereses)
3. Se registra automáticamente en el historial

**Ejemplo:**
- Préstamo: Q 10,000
- Aportador A: Q 6,000 (60%)
- Aportador B: Q 4,000 (40%)
- Pago del cliente: Q 1,000
  - Q 600 → Aportador A
  - Q 400 → Aportador B

### Reportes de Aportadores

Disponibles en el módulo de reportes:
- Ranking de aportadores por capital invertido
- Aportadores con mejor retorno
- Histórico de inversiones por aportador
- Préstamos con múltiples aportadores

---

## �📦 Productos / Materiales

Catálogo de materiales de construcción disponibles para venta a crédito.

### Crear Producto

1. Ve a **Productos** en el menú
2. Clic en **"+ Nuevo Producto"**
3. Completa:

**Información Básica:**
- Código (único, ej: CEM-001)
- Nombre (ej: Cemento Portland Gris 50kg)
- Categoría:
  - Cemento
  - Hierro
  - Blocks
  - Agregados (arena, piedrín)
  - Tubería
  - Láminas
  - Madera
  - Pintura
  - Eléctricos
  - Plomería
  - Herramientas
  - Otros

**Detalles:**
- Unidad de medida (Bolsa, Unidad, Metro Cúbico, etc.)
- Precio unitario (Q)
- Marca (opcional)
- Descripción

**Inventario:**
- Stock actual
- Stock mínimo (para alertas)
- Estado (Activo/Inactivo)

4. Guarda el producto

### Importación Masiva de Productos

Para agregar muchos productos a la vez:

1. Clic en **"Importar CSV"** (botón verde)
2. Descarga la plantilla CSV
3. Llena tus productos en Excel/LibreOffice
4. Guarda como CSV (separado por comas)
5. Selecciona el modo:
   - **Ambas:** Crea y actualiza
   - **Solo crear:** Solo nuevos
   - **Solo actualizar:** Solo existentes
6. Sube el archivo

📄 Ver [IMPORTACION_PRODUCTOS.md](IMPORTACION_PRODUCTOS.md) para detalles completos.

### Buscar Productos

- Búsqueda por nombre o código
- Filtros por categoría
- Filtros por estado (Activo/Inactivo)

### Ver Detalles

- Stock actual
- Precio
- Productos usados en recetas
- Productos vendidos en cotizaciones

---

## 🏗️ Recetas de Construcción

Las recetas son **plantillas** de construcción que definen qué materiales se necesitan para construir un tipo específico de vivienda.

### Tipos de Recetas

1. **Plantillas (Predefinidas):**
   - Creadas por ti para reutilizar
   - Ej: "Casa básica 6x6m", "Casa 2 niveles 8x10m"
   - Se pueden clonar y personalizar

2. **Personalizadas (Por Cliente):**
   - Creadas específicamente para un cliente
   - Modificadas según necesidades particulares
   - Basadas en plantillas o desde cero

### Crear Receta Plantilla

1. Ve a **Recetas** → **"+ Nueva Receta"**
2. Completa:
   - Nombre (ej: "Casa Básica 6x6m")
   - Tipo de vivienda (ej: "Unifamiliar", "Duplex")
   - Área de construcción (m²)
   - Marcar como **"Es Plantilla"** ✅
3. Agrega productos:
   - Busca o selecciona producto
   - Cantidad necesaria
   - El precio se calcula automáticamente
4. El **costo total** se suma automáticamente
5. Guarda la receta

### Crear Receta Personalizada para Cliente

1. **Opción A - Desde cero:**
   - Nueva Receta
   - Selecciona el cliente
   - NO marcar "Es Plantilla"
   - Agrega productos específicos

2. **Opción B - Clonar plantilla:**
   - En la lista de recetas, encuentra una plantilla
   - Clic en **"Clonar"**
   - Selecciona el cliente
   - Modifica productos/cantidades según necesidad
   - Guarda

### Items de Receta

Cada producto en la receta contiene:
- Producto (material)
- Cantidad
- Precio unitario (al momento de agregar)
- Subtotal (cantidad × precio)

### Ver Detalles de Receta

- Lista de todos los materiales
- Cantidades requeridas
- Costo total de construcción
- Cliente asociado (si es personalizada)
- Cotizaciones generadas de esta receta

---

## 💼 Cotizaciones

Una cotización es un presupuesto formal que convierte una receta en una propuesta de crédito para el cliente.

### Flujo de Cotización

```
Receta → Cotización → Aprobación → Préstamo
```

### Crear Cotización

1. Ve a **Cotizaciones** → **"+ Nueva Cotización"**
2. Selecciona:
   - **Cliente**
   - **Receta** (se cargará lista de recetas del cliente o plantillas)
3. El sistema genera automáticamente:
   - Número de cotización (COT-YYYYMMDD-XXXX)
   - Fecha de emisión (hoy)
   - Fecha de vencimiento (configurable, default: 30 días)
   - Lista de productos de la receta
4. Puedes modificar:
   - Cantidades de productos
   - Agregar descuento (Q o %)
5. El sistema calcula:
   - Subtotal
   - Descuento
   - **Total final**
6. Guarda la cotización

### Estados de Cotización

🟡 **Pendiente** - Esperando respuesta del cliente  
🟢 **Aprobada** - Cliente aceptó, lista para convertir a préstamo  
🔴 **Rechazada** - Cliente no aceptó  
⏱️ **Vencida** - Expiró antes de aprobarse  

### Aprobar Cotización

1. En la lista, haz clic en **"Aprobar"**
2. O en los detalles, botón **"Aprobar Cotización"**
3. El estado cambia a "Aprobada"

### Convertir Cotización a Préstamo

⚠️ Solo cotizaciones **Aprobadas** se pueden convertir

1. En detalles de cotización aprobada
2. Clic en **"Convertir a Préstamo"**
3. El sistema crea automáticamente:
   - Un préstamo con el monto de la cotización
   - Vincula la cotización al préstamo
   - Genera el calendario de pagos
4. Te redirige al préstamo creado

### Vencimiento de Cotizaciones

- Las cotizaciones tienen fecha de vencimiento
- El sistema cambia automáticamente el estado a "Vencida" si no se aprueban a tiempo
- Días de vencimiento configurables en **Configuración**

---

## 💰 Préstamos

Los préstamos son el crédito formal otorgado al cliente para adquirir los materiales.

### Crear Préstamo

**Método 1: Desde Cotización (Recomendado)**
- Convierte una cotización aprobada a préstamo
- Los datos se copian automáticamente

**Método 2: Manual**
1. **Préstamos** → **"+ Nuevo Préstamo"**
2. Completa:
   - Cliente
   - Monto del crédito (Q)
   - Tasa de interés (% mensual)
   - Plazo (meses)
   - Fecha de inicio
   - Cotización asociada (opcional)
3. El sistema calcula:
   - Cuota mensual
   - Total con intereses
   - Calendario de pagos

### Cálculo de Cuotas

El sistema usa el método de **cuotas fijas**:

```
Cuota Mensual = [Monto × (Tasa/100) × (1 + Tasa/100)^Plazo] / [(1 + Tasa/100)^Plazo - 1]
```

**Ejemplo:**
- Monto: Q 10,000
- Tasa: 5% mensual
- Plazo: 12 meses
- Cuota: Q 1,128.25/mes
- Total a pagar: Q 13,539.00

### Estados de Préstamo

🟡 **Pendiente** - Creado pero no aprobado  
🟢 **Aprobado** - Activo, cliente puede retirar materiales  
🔵 **En Pago** - Cliente está pagando cuotas  
✅ **Pagado** - Completamente liquidado  
🔴 **Vencido** - Tiene cuotas atrasadas  

### Aprobar Préstamo

1. En lista de préstamos, clic en **"Aprobar"**
2. O en detalles del préstamo
3. El estado cambia a "Aprobado"
4. Se activa el calendario de pagos

### Calendario de Pagos

Al crear un préstamo se genera automáticamente:
- Una cuota por cada mes del plazo
- Fecha de vencimiento mensual
- Monto de la cuota
- Estado: Pendiente → Pagado

### Ver Detalles del Préstamo

- Información del cliente
- Monto prestado
- Tasa de interés
- Cuota mensual
- Total con intereses
- **Tabla de pagos:**
  - Número de cuota
  - Fecha de vencimiento
  - Monto
  - Estado
  - Fecha de pago real
- Historial de pagos realizados
- Cotización asociada (si existe)

---

## 💵 Pagos

Registro de los pagos realizados por los clientes para liquidar sus cuotas.

### Registrar Pago

1. **Método A - Desde Préstamos:**
   - En detalles del préstamo
   - Tabla de cuotas pendientes
   - Clic en **"Pagar"** en la cuota correspondiente

2. **Método B - Desde módulo Pagos:**
   - **Pagos** → **"+ Registrar Pago"**
   - Selecciona cliente
   - Selecciona préstamo (solo activos)
   - Selecciona cuota pendiente

3. Completa:
   - Monto pagado (Q)
   - Fecha de pago (default: hoy)
   - Método de pago:
     - Efectivo
     - Transferencia bancaria
     - Cheque
     - Tarjeta
   - Comprobante/Referencia (opcional)
   - Notas (opcional)

4. Guarda el pago

### Validaciones

- ✅ Solo puedes pagar cuotas pendientes
- ✅ El monto debe ser mayor a 0
- ✅ El sistema actualiza automáticamente el estado del préstamo
- ✅ Si todas las cuotas están pagadas → Préstamo pasa a "Pagado"

### Ver Historial de Pagos

En el módulo **Pagos** verás:
- Todos los pagos registrados
- Filtros por cliente, préstamo, fecha
- Cliente y préstamo asociado
- Cuota número
- Monto
- Método de pago
- Fecha

---

## � Chat

Sistema de mensajería interna en tiempo real entre usuarios del sistema (administradores, cobradores, vendedores).

### Características del Chat

✅ **Conversaciones privadas 1-on-1** entre usuarios  
✅ **Notificaciones en tiempo real** sin necesidad de recargar  
✅ **Envío de archivos adjuntos** (imágenes, PDFs, Excel)  
✅ **Contador de mensajes no leídos** en el menú  
✅ **Historial completo** de conversaciones  
✅ **Búsqueda de mensajes** dentro de conversaciones  

### Iniciar Conversación

1. Ve a **Chat** en el menú lateral
2. Verás tu lista de conversaciones existentes
3. Clic en **"+ Nueva Conversación"**
4. Selecciona el usuario con quien chatear
5. La conversación se crea automáticamente

### Enviar Mensajes

1. Abre una conversación existente
2. Escribe tu mensaje en el campo inferior
3. Presiona Enter o clic en **"Enviar"**
4. El mensaje aparece instantáneamente

### Enviar Archivos

1. Dentro de una conversación
2. Clic en el botón de **clip/adjuntar** 📎
3. Selecciona archivo:
   - **Imágenes:** JPG, PNG, GIF, WEBP
   - **Documentos:** PDF, DOC, DOCX
   - **Hojas de cálculo:** XLS, XLSX, CSV
4. Tamaño máximo: 10 MB por archivo
5. El archivo se sube y aparece en el chat

### Ver Archivos Adjuntos

- **Imágenes:** Vista previa automática en el chat
- **PDFs/Excel:** Clic en el archivo para descargar
- Ícono diferente según tipo de archivo
- Información del archivo (nombre, tamaño)

### Notificaciones

- **Badge rojo** en el menú Chat muestra mensajes no leídos
- Contador actualizado en tiempo real
- Al abrir conversación, se marca como leída
- Notificación visual del último mensaje

### Lista de Conversaciones

Muestra:
- Avatar del usuario
- Nombre del contacto
- Último mensaje enviado
- Hora del último mensaje
- **Badge con contador** de mensajes no leídos
- Ordenadas por actividad reciente

### Buscar en Conversación

1. Abre la conversación
2. Usa el campo de búsqueda superior
3. Busca por texto del mensaje
4. Resultados resaltados

### Eliminar Mensajes

⚠️ Los mensajes eliminados se ocultan pero se conservan en la base de datos (soft delete) para auditoría.

### Permisos

- Todos los usuarios autenticados pueden usar el chat
- Solo conversaciones 1-on-1 (no grupos por ahora)
- No se puede enviar mensaje a uno mismo

---

## 📊 Reportes

Módulo de análisis financiero y estadísticas avanzadas del sistema.

### Tipos de Reportes

1. **Reporte General** - Vista completa de la operación
2. **Reporte de Cartera** - Análisis de préstamos activos
3. **Reporte de Cobranza** - Seguimiento de pagos y mora
4. **Reporte de Clientes** - Análisis por cliente

### Filtros Disponibles

- **Rango de fechas** - Desde/Hasta
- **Estado de préstamos** - Activo, Pagado, En Mora
- **Cliente específico** - Buscar por nombre/DPI
- **Usuario que gestiona** - Filtrar por vendedor/cobrador

### Reporte General

**Métricas principales:**
- 💰 **Total Prestado** en el período
- 📊 **Cantidad de Préstamos** otorgados
- 💵 **Total Cobrado** en pagos
- 📈 **Cantidad de Pagos** recibidos
- ⚠️ **Saldo Pendiente** de cartera activa
- 🏠 **Préstamos Activos** vigentes
- 🔴 **Mora Acumulada** en retrasos
- 📉 **Cantidad en Mora** préstamos vencidos
- 📊 **Tasa de Morosidad** porcentual

**Gráficos:**
- Gráfico de pagos mensuales (últimos 6 meses)
- Distribución de préstamos por estado (donut)
- Tendencia de otorgamiento vs cobranza

### Reporte de Cartera

Análisis detallado de préstamos:
- Cartera total vigente
- Distribución por:
  - Estado (Activo, En Mora, Pagado)
  - Frecuencia de pago (Semanal, Quincenal, Mensual)
  - Tipo de interés (Fijo, Variable)
- **Top 10 deudores** con mayor saldo pendiente
- Préstamos próximos a vencer

### Reporte de Cobranza

Seguimiento de recuperación:
- Total cobrado en el período
- Promedio de pago por cliente
- Pagos puntuales vs tardíos
- Mora acumulada
- **Top cobradores** (usuarios con más cobros)
- Análisis de efectividad de cobro

### Exportar Reportes

1. Genera el reporte con los filtros deseados
2. Clic en **"Exportar PDF"** o **"Exportar Excel"**
3. El archivo se descarga automáticamente
4. Contiene:
   - Encabezado con logo de empresa
   - Filtros aplicados
   - Todas las tablas y gráficos
   - Fecha de generación

---

## ⚙️ Configuración

Personalización y parámetros del sistema.

### Información de la Empresa

1. Ve a **Configuración** en el menú
2. Edita:
   - **Nombre de la aplicación**
   - **Logo principal** (aparece en menú y PDFs)
   - **Logo secundario** (opcional)
   - **Dirección**
   - **Teléfono**
   - **Email de contacto**
   - **Sitio web**

### Parámetros de Préstamos

- **Tasa de interés predeterminada** (% mensual)
- **Plazo máximo** (meses)
- **Plazo mínimo** (meses)
- **Monto mínimo de préstamo** (Q)
- **Monto máximo de préstamo** (Q)

### Parámetros de Cotizaciones

- **Días de validez** (default: 30 días)
- **Descuento máximo permitido** (%)
- **Requiere aprobación automática**

### Configuración de Pagos

- **Días de gracia** antes de marcar mora
- **Multa por mora** (Q o %)
- **Métodos de pago disponibles**

### Personalización de PDFs

- **Color primario** del encabezado
- **Incluir logo** en documentos
- **Pie de página** personalizado
- **Términos y condiciones** predeterminados

### Notificaciones

- ✅ Email al crear préstamo
- ✅ Email al vencer cotización
- ✅ Email recordatorio de pago
- ✅ Email de mora

### Seguridad

- **Requiere verificación de email**
- **Duración de sesión** (minutos)
- **Intentos máximos de login**

---

## 👤 Usuarios

Gestión de usuarios del sistema con roles y permisos (Solo Administradores).

### Roles Disponibles

1. **👑 Administrador**
   - Acceso completo al sistema
   - Gestión de usuarios y permisos
   - Configuración del sistema
   - Todos los módulos

2. **💼 Vendedor**
   - Gestión de clientes
   - Crear cotizaciones
   - Crear recetas
   - Crear préstamos
   - Ver reportes limitados

3. **💳 Cobrador**
   - Ver préstamos activos
   - Registrar pagos
   - Ver historial de pagos
   - Seguimiento de mora
   - Reportes de cobranza

4. **👁️ Visualizador**
   - Solo lectura
   - Ver clientes, préstamos, pagos
   - Sin permisos de edición

### Crear Usuario

1. Ve a **Usuarios** (solo si eres Administrador)
2. Clic en **"+ Nuevo Usuario"**
3. Completa:
   - Nombre completo
   - Email (será su username)
   - Password (mínimo 8 caracteres)
   - Confirmar password
4. **Asigna Rol:**
   - Selecciona uno o más roles
   - Los permisos se asignan automáticamente
5. Guarda el usuario

### Permisos por Rol

**Administrador:**
- ✅ Ver, crear, editar, eliminar todo
- ✅ Gestionar usuarios
- ✅ Configuración del sistema
- ✅ Todos los reportes

**Vendedor:**
- ✅ Ver/crear/editar clientes
- ✅ Ver/crear/editar productos
- ✅ Ver/crear/editar recetas
- ✅ Ver/crear/editar cotizaciones
- ✅ Ver/crear préstamos
- ❌ Aprobar préstamos
- ❌ Registrar pagos
- ❌ Gestionar usuarios

**Cobrador:**
- ✅ Ver clientes (solo lectura)
- ✅ Ver préstamos activos
- ✅ Registrar pagos
- ✅ Ver historial de pagos
- ✅ Reportes de cobranza
- ❌ Crear/editar clientes
- ❌ Crear préstamos
- ❌ Configuración

**Visualizador:**
- ✅ Ver todo
- ❌ Crear/editar/eliminar nada

### Editar Usuario

1. En lista de usuarios, clic en **"Editar"**
2. Modifica:
   - Nombre
   - Email
   - Rol (cambiar permisos)
   - Estado (Activo/Inactivo)
3. **Cambiar contraseña:**
   - Deja en blanco si no quieres cambiarla
   - Si ingresas nueva, confirma
4. Guarda cambios

### Cambiar Rol de Usuario

1. En lista de usuarios, clic en **"Cambiar Rol"**
2. Selecciona nuevo rol
3. Los permisos se actualizan automáticamente
4. El usuario verá cambios al iniciar sesión nuevamente

### Desactivar Usuario

⚠️ No elimines usuarios con actividad registrada. Mejor desactívalos:

1. Edita el usuario
2. Cambia estado a **"Inactivo"**
3. El usuario no podrá iniciar sesión
4. Su historial se conserva

### Ver Actividad de Usuario

- Préstamos creados
- Pagos registrados
- Clientes gestionados
- Última sesión

---

## 🔄 Flujo de Trabajo

**Métricas Generales:**
- Total de clientes registrados
- Total de productos en catálogo
- Total de préstamos (desglosado por estado)
- Monto total prestado
- Monto total cobrado
- Saldo pendiente

**Gráficos:**
- Estado de préstamos (circular)
- Tendencia mensual de préstamos (barras)
- Productos más vendidos
- Clientes con más créditos

### Filtros de Reporte

- Por rango de fechas
- Por estado de préstamo
- Por cliente específico
- Por categoría de producto

### Exportar Reportes

(Función en desarrollo)
- PDF
- Excel
- CSV

---

## ⚙️ Configuración

Personaliza el sistema según tu negocio.

### Acceso

**Configuración** → en el menú lateral (ícono de engranaje)

### Pestañas de Configuración

#### 1. 📋 General

Información básica de tu empresa:
- **Nombre de la aplicación** (aparece en navbar y login)
- **Slogan** (frase descriptiva)
- **Teléfono** de contacto
- **Email** corporativo
- **Dirección** física del negocio

#### 2. 🖼️ Imágenes

Personaliza la identidad visual:

- **Logo para Login:** Aparece en la pantalla de inicio de sesión
- **Logo para Sidebar:** Logo en el menú lateral
- **Logo para Reportes/PDFs:** Se imprime en documentos
- **Favicon:** Ícono del navegador (pestaña)

**Formatos aceptados:** PNG, JPG, JPEG, ICO  
**Tamaño máximo:** 2MB (favicon: 1MB)

#### 3. 📄 PDFs

Configuración de documentos impresos:

**Orientación:**
- Vertical (Portrait)
- Horizontal (Landscape)

**Tamaño de papel:**
- Carta (Letter)
- Oficio (Legal)
- A4

**Elementos a mostrar:**
- ☑️ Mostrar logo
- ☑️ Mostrar fecha de generación
- ☑️ Mostrar usuario que generó

**Textos personalizados:**
- Pie de página (puede usar variables: {PAGE_NUM}, {PAGE_COUNT})
- Términos y condiciones (para contratos de préstamo)

#### 4. 🎨 Tema

Personaliza los colores del sistema:
- **Color primario** (botones, enlaces, acentos)
- **Color secundario** (elementos secundarios)

Usa los selectores de color para elegir.

⚠️ **Nota:** Los cambios de color requieren recompilar assets de Tailwind para aplicarse completamente.

#### 5. 💼 Negocios

Parámetros operativos por defecto:

**Moneda:**
- Símbolo (Q)
- Nombre (Quetzales)

**Valores por defecto:**
- **Tasa de interés** (% mensual) - Se usa al crear préstamos
- **Plazo** (meses) - Plazo sugerido
- **Días de vencimiento de cotizaciones** - Cuánto tiempo son válidas

#### 6. 🔔 Notificaciones

Activa/desactiva alertas del sistema:
- ☑️ **Notificar stock bajo** - Cuando un producto alcanza stock mínimo
- ☑️ **Notificar pagos pendientes** - Recordatorios de cuotas por vencer
- ☑️ **Notificar cotizaciones vencidas** - Alertas de cotizaciones expiradas

### Guardar Configuración

Haz clic en **"Guardar Configuración"** al final del formulario.

Los cambios se aplican inmediatamente.

---

## Flujo de Trabajo

### Proceso Completo de Crédito

```
1. Registrar Cliente
   ↓
2. Crear/Seleccionar Receta de Construcción
   ↓
3. Generar Cotización
   ↓
4. Cliente revisa cotización
   ↓
5. Aprobar Cotización
   ↓
6. Convertir a Préstamo
   ↓
7. Aprobar Préstamo
   ↓
8. Cliente retira materiales
   ↓
9. Registrar Pagos mensuales
   ↓
10. Completar pago → Préstamo liquidado
```

### Ejemplo Práctico

**Caso:** Juan Pérez quiere construir una casa básica de 6x6m

1. **Día 1:** Registras a Juan como cliente
2. **Día 1:** Usas la plantilla "Casa Básica 6x6m" (o creas una personalizada)
3. **Día 1:** Generas cotización COT-20260103-0001 por Q 45,000
4. **Día 3:** Juan acepta → Apruebas la cotización
5. **Día 3:** Conviertes a préstamo de Q 45,000 a 12 meses, 5% interés
6. **Día 4:** Apruebas el préstamo → Cuota mensual: Q 5,077
7. **Día 4:** Juan retira los materiales
8. **Cada mes:** Juan paga su cuota, tú registras el pago
9. **Mes 12:** Último pago → Préstamo completado ✅

---

## Importación Masiva

### Productos desde CSV

Para cargar tu catálogo completo de productos:

1. Ve a **Productos** → **"Importar CSV"**
2. Descarga la plantilla de ejemplo
3. Completa en Excel/LibreOffice:
   - Código único por producto
   - Nombre, categoría, unidad
   - Precio unitario
   - Stock (opcional)
4. Guarda como **CSV (separado por comas)**
5. Sube el archivo

**Columnas requeridas:**
- codigo
- nombre
- categoria
- unidad_medida
- precio_unitario

**Columnas opcionales:**
- stock_actual
- stock_minimo
- marca
- descripcion
- estado

📄 Consulta [IMPORTACION_PRODUCTOS.md](IMPORTACION_PRODUCTOS.md) para detalles completos.

### Archivo de Ejemplo Incluido

Ya hay un archivo de ejemplo en:
`public/plantilla_productos_ejemplo.csv`

Contiene 10 productos reales de construcción que puedes importar directamente.

---

## Preguntas Frecuentes

### ¿Qué pasa si borro un cliente por error?

⚠️ No puedes borrar clientes con préstamos o cotizaciones. Si necesitas desactivarlos, contacta al administrador del sistema.

### ¿Puedo modificar una receta después de crear una cotización?

Sí, pero no afectará a cotizaciones ya creadas. Las cotizaciones guardan una copia de los productos al momento de crearlas.

### ¿Cómo cambio masivamente precios de productos?

1. Exporta tu catálogo (o crea CSV con códigos existentes)
2. Modifica los precios en el CSV
3. Importa en modo "Solo actualizar"
4. Los precios se actualizan masivamente

### ¿Qué pasa si un cliente paga más de una cuota a la vez?

Registra cada cuota por separado. El sistema actualizará el estado de cada una.

### ¿Puedo crear un préstamo sin cotización?

Sí, pero se recomienda siempre hacer cotización primero para documentación formal.

### ¿Los intereses son simples o compuestos?

El sistema usa interés compuesto con cuotas fijas (método francés).

### ¿Cómo aplico un descuento?

Los descuentos se aplican en la cotización antes de convertir a préstamo. Puedes usar monto fijo (Q) o porcentaje (%).

### ¿Qué pasa si el cliente no paga una cuota?

El préstamo cambiará automáticamente a estado "Vencido". Puedes ver cuotas atrasadas en los detalles del préstamo.

### ¿Puedo tener más de una cotización activa por cliente?

Sí, un cliente puede tener múltiples cotizaciones pendientes.

### ¿Se puede devolver un material?

(Función en desarrollo)

---

## Solución de Problemas

### No puedo iniciar sesión

✅ Verifica que tu email y contraseña sean correctos  
✅ Contacta al administrador para resetear tu contraseña

### Los precios no se muestran correctamente

✅ Verifica la configuración de moneda en **Configuración**  
✅ Asegúrate de que los precios estén en formato numérico (123.45)

### Error al subir imágenes

✅ Verifica que el archivo sea PNG, JPG o JPEG  
✅ Tamaño máximo: 2MB (favicon: 1MB)  
✅ Asegúrate de tener permisos de escritura en `storage/`

### El CSV no se importa

✅ Verifica que sea CSV (separado por comas), no Excel  
✅ Asegúrate de tener todas las columnas requeridas  
✅ Codificación UTF-8  
✅ Primera fila debe tener los nombres de columnas  
✅ Los números decimales usan punto (.) no coma (,)

### Los caracteres especiales (ñ, á) no se ven bien

✅ Guarda el CSV como **UTF-8**  
✅ En Excel: Guardar como → CSV UTF-8  
✅ En LibreOffice: Character Set → Unicode (UTF-8)

### No aparece el botón "Convertir a Préstamo"

✅ La cotización debe estar en estado "Aprobada"  
✅ Primero aprueba la cotización, luego podrás convertirla

### El dashboard no muestra datos

✅ Espera unos segundos a que cargue  
✅ Verifica que tengas datos en el sistema (clientes, préstamos)  
✅ Refresca la página (F5)

### Los colores del tema no cambian

⚠️ Los cambios de color requieren recompilar los assets de Tailwind CSS. Contacta al administrador técnico.

---

## Glosario de Términos

**Cliente:** Persona que solicita crédito para materiales de construcción

**Producto/Material:** Artículo del catálogo (cemento, hierro, blocks, etc.)

**Aportador:** Inversionista que financia préstamos con su capital

**Receta:** Plantilla que define qué materiales se necesitan para construir un tipo de vivienda

**Plantilla:** Receta reutilizable no asociada a un cliente específico

**Cotización:** Presupuesto formal de crédito basado en una receta

**Préstamo:** Crédito formal otorgado al cliente para adquirir materiales

**Cuota:** Pago mensual fijo que el cliente debe realizar

**Pago:** Registro de un abono del cliente a una cuota específica

**DPI:** Documento Personal de Identificación (Guatemala, 13 dígitos)

**Stock:** Cantidad disponible de un producto en inventario

**Stock mínimo:** Nivel de alerta para reorden de producto

**Tasa de interés:** Porcentaje mensual aplicado al préstamo

**Plazo:** Cantidad de meses para pagar el préstamo

**Mora:** Recargo por pago tardío de cuota

**Cartera:** Conjunto de préstamos activos

**Saldo pendiente:** Monto que falta por pagar de un préstamo

**Crowdfunding:** Sistema de múltiples aportadores financiando un préstamo

---

## Información de Contacto

**Desarrollado para:** Empresas de materiales de construcción en Guatemala

**Soporte Técnico:** [Contactar administrador del sistema]

**Versión del Sistema:** 2.0

**Última actualización:** Enero 2026

---

## Notas Finales

Este sistema fue diseñado específicamente para el modelo de negocio guatemalteco de créditos en materiales de construcción. 

**Características únicas:**
- ✅ Adaptado a Guatemala (DPI, departamentos, Quetzales)
- ✅ Crédito en materiales, no en efectivo
- ✅ Recetas de construcción personalizables
- ✅ Sistema de aportadores (crowdfunding)
- ✅ Chat interno en tiempo real
- ✅ Sistema de roles y permisos
- ✅ Dashboard con estadísticas de usuarios
- ✅ Reportes avanzados con gráficos interactivos
- ✅ Flujo completo: Receta → Cotización → Préstamo → Pagos

**Módulos Principales:**
1. 👥 Clientes - Gestión de clientes con datos guatemaltecos
2. 💼 Aportadores - Sistema de crowdfunding para financiamiento
3. 📦 Productos - Catálogo de materiales de construcción
4. 🏗️ Recetas - Plantillas de construcción reutilizables
5. 💼 Cotizaciones - Presupuestos formales con vencimiento
6. 💰 Préstamos - Créditos formales con calendario de pagos
7. 💵 Pagos - Registro de cobros con seguimiento de mora
8. 📊 Reportes - Análisis financiero y estadísticas avanzadas
9. 💬 Chat - Mensajería interna en tiempo real con archivos
10. ⚙️ Configuración - Personalización completa del sistema
11. 👤 Usuarios - Gestión de roles y permisos

**Seguridad:**
- 🔐 Autenticación con Laravel Jetstream
- 🔑 Roles: Administrador, Vendedor, Cobrador, Visualizador
- 🛡️ Permisos granulares con Spatie Permission
- 📧 Verificación de email opcional
- ⏱️ Control de sesiones

**Tecnología:**
- Laravel 11.x
- Livewire 3.7 (tiempo real)
- Flowbite 2.x (UI moderna)
- MySQL
- ApexCharts (gráficos interactivos)

---

📖 **¡Gracias por usar CrediHome!**

*Sistema integral para gestión de créditos de materiales de construcción en Guatemala*
