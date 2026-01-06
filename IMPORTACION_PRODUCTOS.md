# 📦 Importación Masiva de Productos - CrediHome

## 📋 Descripción
Esta funcionalidad permite importar productos de forma masiva mediante archivos CSV para crear o actualizar registros rápidamente.

## 🚀 Cómo usar

### Opción 1: Desde la interfaz web

1. **Accede al módulo de Productos**
   - Ve a `Productos / Materiales` en el menú lateral
   
2. **Haz clic en "Importar CSV"**
   - Verás el botón verde en la esquina superior derecha
   
3. **Descarga la plantilla**
   - En la página de importación, haz clic en "Descargar plantilla_productos.csv"
   - O usa el archivo de ejemplo: `public/plantilla_productos_ejemplo.csv`

4. **Completa los datos**
   - Abre el archivo CSV con Excel, Google Sheets o LibreOffice
   - Llena los datos de tus productos siguiendo los ejemplos
   
5. **Guarda el archivo**
   - **Importante:** Guarda como **CSV (separado por comas)**, NO como Excel (.xlsx)
   - Asegúrate de que esté codificado en **UTF-8**
   
6. **Sube el archivo**
   - Selecciona el modo de importación:
     - **Ambas:** Crea nuevos productos y actualiza los existentes (recomendado)
     - **Solo crear:** Solo agrega productos nuevos, ignora códigos existentes
     - **Solo actualizar:** Solo modifica productos existentes, ignora códigos nuevos
   - Sube tu archivo CSV
   - Haz clic en "Importar Productos"

### Opción 2: Usando la plantilla de ejemplo

Hemos incluido un archivo de ejemplo listo para usar:

📁 **Ubicación:** `public/plantilla_productos_ejemplo.csv`

Este archivo ya contiene 10 productos de ejemplo que puedes importar directamente o modificar según tus necesidades.

## 📊 Estructura del archivo CSV

### Columnas REQUERIDAS (obligatorias)

| Columna          | Descripción                                    | Ejemplo                           |
|------------------|------------------------------------------------|-----------------------------------|
| codigo           | Código único del producto                      | CEM-001                           |
| nombre           | Nombre descriptivo del producto                | Cemento Portland Gris 50kg        |
| categoria        | Categoría del producto                         | Cemento                           |
| unidad_medida    | Unidad de medida                               | Bolsa, Unidad, Metro Cúbico       |
| precio_unitario  | Precio en quetzales (usar punto para decimales)| 95.50                             |

### Columnas OPCIONALES

| Columna          | Descripción                                    | Valor por defecto |
|------------------|------------------------------------------------|-------------------|
| stock_actual     | Cantidad disponible en inventario              | 0                 |
| stock_minimo     | Stock mínimo antes de alerta                   | 0                 |
| marca            | Marca o fabricante                             | (vacío)           |
| descripcion      | Descripción detallada                          | (vacío)           |
| estado           | Activo o Inactivo                              | Activo            |

## ✅ Categorías disponibles

- Cemento
- Hierro
- Blocks
- Agregados
- Tubería
- Láminas
- Madera
- Pintura
- Eléctricos
- Plomería
- Herramientas
- Otros

## 📝 Ejemplos de datos válidos

### Ejemplo 1: Producto básico (solo campos requeridos)
```csv
CEM-001,Cemento Portland Gris 50kg,Cemento,Bolsa,95.50,,,,,Activo
```

### Ejemplo 2: Producto completo (todos los campos)
```csv
HIE-002,Varilla Corrugada 3/8" x 6m,Hierro,Unidad,45.00,500,50,SIDEGUA,Varilla de acero corrugada grado 40,Activo
```

### Ejemplo 3: Producto sin marca
```csv
ARE-004,Arena de Rio m³,Agregados,Metro Cúbico,150.00,50,10,,Arena lavada para construcción,Activo
```

## ⚠️ Notas importantes

### Formato del archivo
- ✅ Usa **CSV separado por comas** (,)
- ✅ Codificación **UTF-8** (para caracteres especiales como ñ, á, é)
- ✅ La primera fila DEBE contener los nombres de las columnas
- ❌ NO uses Excel (.xlsx) - convierte a CSV primero
- ❌ NO uses punto y coma (;) como separador

### Validaciones
- Los **códigos deben ser únicos** (no puede haber dos productos con el mismo código)
- Los **números decimales usan punto** (.) no coma (,)
  - ✅ Correcto: `95.50`
  - ❌ Incorrecto: `95,50`
- Los **campos requeridos no pueden estar vacíos**
- El **precio_unitario** debe ser mayor o igual a 0
- El **stock** debe ser mayor o igual a 0
- El **estado** solo acepta: `Activo` o `Inactivo`

### Comportamiento según modo de importación

#### Modo "Ambas" (recomendado)
- Si el código existe: **ACTUALIZA** el producto
- Si el código no existe: **CREA** un nuevo producto

#### Modo "Solo crear"
- Si el código existe: **IGNORA** (muestra error)
- Si el código no existe: **CREA** un nuevo producto

#### Modo "Solo actualizar"
- Si el código existe: **ACTUALIZA** el producto
- Si el código no existe: **IGNORA** (muestra error)

## 🔧 Solución de problemas

### Error: "Faltan columnas requeridas"
**Solución:** Verifica que tu archivo CSV tenga todas las columnas obligatorias en la primera fila.

### Error: "Producto con código XXX ya existe"
**Solución:** 
- Cambia el modo de importación a "Ambas" o "Solo actualizar"
- O modifica los códigos duplicados en tu archivo

### Error: "Invalid datetime format"
**Solución:** No incluyas columnas de fecha (created_at, updated_at) - se crean automáticamente.

### Los caracteres especiales (ñ, á, é) no se ven bien
**Solución:** 
- Guarda el archivo como **CSV UTF-8** en Excel
- En LibreOffice: Archivo → Guardar como → CSV → Character Set: Unicode (UTF-8)

### Excel cambia los números decimales
**Solución:** 
- Configura Excel para usar punto como separador decimal
- O edita el CSV en un editor de texto (Notepad++, VS Code)

## 📈 Consejos y mejores prácticas

1. **Haz una prueba primero**
   - Importa solo 2-3 productos de prueba antes de importar todo el catálogo
   
2. **Mantén un respaldo**
   - Guarda una copia del CSV antes de importar
   
3. **Usa códigos consistentes**
   - Ejemplo: `CEM-001`, `CEM-002` para cementos
   - Ejemplo: `HIE-001`, `HIE-002` para hierros
   
4. **Revisa los errores**
   - Si hay errores, se mostrarán en pantalla
   - Corrige y vuelve a importar
   
5. **Actualización masiva**
   - Para cambiar precios de muchos productos:
     1. Exporta (o crea CSV con códigos existentes)
     2. Modifica los precios
     3. Importa en modo "Solo actualizar"

## 📞 Soporte

Si tienes problemas con la importación:
1. Verifica que el archivo cumpla con el formato requerido
2. Revisa los mensajes de error en pantalla
3. Usa el archivo de ejemplo como referencia
4. Asegúrate de que el archivo esté en UTF-8

## 📦 Archivos incluidos

- **Plantilla en blanco:** Generada dinámicamente al hacer clic en "Descargar plantilla"
- **Plantilla con ejemplos:** `public/plantilla_productos_ejemplo.csv` (10 productos de muestra)
- **Vista de importación:** `resources/views/productos/import.blade.php`
- **Controlador:** `app/Http/Controllers/ProductoController.php` (métodos: `importForm`, `import`, `downloadTemplate`)

---

**🎉 ¡Listo! Ya puedes importar tus productos masivamente.**
