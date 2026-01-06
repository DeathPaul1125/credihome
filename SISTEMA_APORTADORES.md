# 💰 Sistema de Aportadores / Inversionistas - CrediHome

## 📋 Descripción General

El sistema de **Aportadores** permite que múltiples personas o entidades (inversionistas/financiadores) aporten capital para fondear los préstamos. Cuando un cliente paga sus cuotas, **el dinero se distribuye automáticamente** a cada aportador de forma proporcional a su participación.

---

## 🏗️ Arquitectura del Sistema

### Entidades Principales

```
APORTADOR → APORTACIÓN → PRÉSTAMO → PAGOS → DISTRIBUCIÓN
   (Inversionista)  (Fondeo)   (Crédito)  (Cliente paga)  (Reparto automático)
```

### 1. **Aportador** (Inversionista/Financiador)

Persona o entidad que provee capital para financiar préstamos.

**Tipos:**
- 👤 Persona física
- 🏢 Empresa
- 🏛️ Institución

**Información de Capital:**
- **Capital disponible:** Dinero que tiene listo para prestar
- **Capital invertido:** Dinero actualmente en préstamos activos
- **Capital recuperado:** Dinero que ha vuelto de préstamos pagados
- **Ganancias totales:** Total de intereses ganados

**Configuración:**
- Tasa de interés mínima que acepta
- Plazo máximo que financia
- Monto mínimo/máximo por préstamo

**Estados:**
- ✅ **Activo:** Puede aportar a nuevos préstamos
- ⏸️ **Inactivo:** Temporalmente sin aportar
- 🚫 **Suspendido:** Bloqueado del sistema

---

### 2. **Aportación** (Fondeo de Préstamo)

Relación entre un aportador y un préstamo específico.

**Información almacenada:**
- Monto aportado
- Porcentaje de participación en el préstamo
- Monto recuperado (capital)
- Intereses ganados
- Saldo pendiente

**Ejemplo:**
```
Préstamo: Q 100,000

Aportador A: Q 60,000 (60%)
Aportador B: Q 30,000 (30%)
Aportador C: Q 10,000 (10%)
```

---

### 3. **Distribución Automática de Pagos**

Cuando un cliente realiza un pago, el sistema **automáticamente**:

1. Calcula cuánto es capital y cuánto es interés en esa cuota
2. Distribuye proporcionalmente a cada aportador según su %
3. Actualiza el capital recuperado de cada aportador
4. Actualiza las ganancias por intereses
5. Devuelve el dinero al capital disponible del aportador
6. Registra la transacción en `distribucion_pagos`

---

## 💡 Ejemplo Práctico Completo

### Escenario:

**Préstamo de Q 100,000 a 12 meses, 5% interés mensual**

#### Paso 1: Registrar Aportadores

```
Aportador: Juan Pérez
- Tipo: Persona
- Capital disponible: Q 70,000
- Tasa mínima: 4%
- Estado: Activo

Aportador: Inversiones XYZ S.A.
- Tipo: Empresa
- Capital disponible: Q 150,000
- Tasa mínima: 3%
- Estado: Activo
```

#### Paso 2: Crear el Préstamo

Cliente solicita Q 100,000 a 12 meses, 5% interés
- Cuota mensual: Q 11,283
- Total a pagar: Q 135,396

#### Paso 3: Asignar Aportadores al Préstamo

```
Juan Pérez aporta:     Q 60,000  → 60% del préstamo
Inversiones XYZ aporta: Q 40,000  → 40% del préstamo
```

**Actualización automática del sistema:**
- Juan Pérez:
  - Capital disponible: Q 70,000 - Q 60,000 = Q 10,000
  - Capital invertido: Q 60,000
  
- Inversiones XYZ:
  - Capital disponible: Q 150,000 - Q 40,000 = Q 110,000
  - Capital invertido: Q 40,000

#### Paso 4: Cliente Paga Primera Cuota

Cliente paga Q 11,283 el mes 1.

**Distribución automática:**

De los Q 11,283:
- Capital: Q 6,283 (aproximado)
- Interés: Q 5,000 (aproximado)

**Juan Pérez (60%):**
- Capital recuperado: Q 6,283 × 60% = Q 3,770
- Interés ganado: Q 5,000 × 60% = Q 3,000
- Total recibe: Q 6,770

**Inversiones XYZ (40%):**
- Capital recuperado: Q 6,283 × 40% = Q 2,513
- Interés ganado: Q 5,000 × 40% = Q 2,000
- Total recibe: Q 4,513

**Actualización automática:**

Juan Pérez:
- Capital disponible: Q 10,000 + Q 6,770 = Q 16,770 ✅
- Capital invertido: Q 60,000 - Q 3,770 = Q 56,230
- Capital recuperado: Q 3,770
- Ganancias totales: Q 3,000

Inversiones XYZ:
- Capital disponible: Q 110,000 + Q 4,513 = Q 114,513 ✅
- Capital invertido: Q 40,000 - Q 2,513 = Q 37,487
- Capital recuperado: Q 2,513
- Ganancias totales: Q 2,000

#### Paso 5: Después de 12 meses

Cliente termina de pagar todas las cuotas.

**Resultado final:**

Juan Pérez:
- Capital invertido: Q 0 (todo recuperado)
- Capital recuperado total: Q 60,000
- Ganancias totales: Q 21,237 (60% de Q 35,396 intereses)
- **ROI: 35.4%** en 12 meses

Inversiones XYZ:
- Capital invertido: Q 0 (todo recuperado)
- Capital recuperado total: Q 40,000
- Ganancias totales: Q 14,159 (40% de Q 35,396 intereses)
- **ROI: 35.4%** en 12 meses

---

## 🔧 Funcionalidades del Sistema

### Módulo Aportadores

#### Crear Aportador
1. **Aportadores** → **"+ Nuevo Aportador"**
2. Completa:
   - Información personal (nombre, DPI, contacto)
   - Tipo (Persona/Empresa/Institución)
   - Capital inicial disponible
   - Preferencias de inversión (tasa mínima, plazo máximo)
3. Guardar

#### Ver Dashboard de Aportador
- Capital disponible vs invertido
- Lista de préstamos fondeados
- Ganancias acumuladas
- ROI (Return on Investment)
- Historial de distribuciones recibidas

#### Agregar Capital
El aportador puede depositar más dinero para prestar:
- Aumenta su capital disponible
- No afecta inversiones activas

#### Retirar Capital
Solo puede retirar del **capital disponible** (no invertido):
- Disminuye capital disponible
- Solo si no tiene compromisos pendientes

---

### Asignar Aportadores a Préstamos

#### Opción 1: Al Crear el Préstamo

Cuando creas un préstamo:
1. Define el monto del crédito
2. El sistema muestra aportadores disponibles
3. Selecciona aportadores y montos:
   ```
   Aportador A: Q 50,000
   Aportador B: Q 30,000
   Aportador C: Q 20,000
   Total: Q 100,000 ✅
   ```
4. El sistema calcula % automáticamente

#### Opción 2: Fondeo Colaborativo

Varios aportadores se "apuntan" al préstamo:
1. Préstamo se crea como "Pendiente de Fondeo"
2. Aportadores ofertan montos
3. Cuando se completa el monto, se aprueba automáticamente

#### Validaciones Automáticas:
- ✅ Aportador tiene suficiente capital disponible
- ✅ Tasa de interés cumple mínimo del aportador
- ✅ Plazo no excede máximo del aportador
- ✅ Monto dentro de límites del aportador
- ✅ Aportador está en estado Activo

---

### Distribución Automática (Backend)

**Se ejecuta automáticamente** cuando:
1. Se registra un pago en el sistema
2. Evento `Pago::created()` se dispara
3. Método `distribuirAAportadores()` se ejecuta

**Proceso:**
```php
// Pseudocódigo
foreach (Aportador del Préstamo) {
    // Calcular porcentaje del pago
    $montoPorAportador = $montoPago × (% de participación)
    
    // Separar capital e interés
    $capital = calcularCapital($montoPorAportador)
    $interes = calcularInteres($montoPorAportador)
    
    // Registrar distribución
    DistribucionPago::create([
        capital: $capital,
        interes: $interes,
        aportador_id: ...
    ])
    
    // Actualizar aportador
    aportador.capital_disponible += $montoPorAportador
    aportador.capital_invertido -= $capital
    aportador.capital_recuperado += $capital
    aportador.ganancias_totales += $interes
    
    // Actualizar aportación
    aportacion.monto_recuperado += $capital
    aportacion.intereses_ganados += $interes
    aportacion.saldo_pendiente -= $capital
}
```

**Registro en Base de Datos:**

Tabla `distribucion_pagos`:
```
| pago_id | aportador_id | monto_capital | monto_interes | monto_total |
|---------|--------------|---------------|---------------|-------------|
| 1       | 1            | 3,770         | 3,000         | 6,770       |
| 1       | 2            | 2,513         | 2,000         | 4,513       |
```

---

## 📊 Reportes y Análisis

### Dashboard de Aportador Individual

**Métricas:**
- 💰 Capital total invertido
- 📈 Capital recuperado
- 💵 Ganancias por intereses
- 📊 ROI promedio
- 📉 ROI por préstamo

**Gráficos:**
- Evolución del capital en el tiempo
- Préstamos activos vs pagados
- Distribución de ganancias mensual
- Performance por tipo de préstamo

### Reporte Global de Aportadores

**Vista para administrador:**
- Ranking de aportadores por capital invertido
- Top aportadores por ROI
- Total de capital en el sistema
- Ganancias distribuidas (histórico)
- Préstamos fondeados vs pendientes

---

## 🔐 Seguridad y Validaciones

### Protecciones Implementadas:

1. **No se puede eliminar aportador con inversiones activas**
2. **Capital disponible no puede ser negativo**
3. **Solo se distribuye a aportaciones activas**
4. **Transacciones atómicas** (rollback si falla distribución)
5. **Registro completo de auditoría** (quién, cuándo, cuánto)
6. **Validación de montos** (suma de aportaciones = monto préstamo)

### Log de Auditoría:

Todas las distribuciones quedan registradas:
- Fecha y hora exacta
- Pago origen
- Aportador receptor
- Montos (capital + interés)
- Estado de la aportación antes/después

---

## 🚀 Ventajas del Sistema

### Para el Negocio:
✅ Permite fondear préstamos grandes sin tener todo el capital  
✅ Diversifica el riesgo entre múltiples aportadores  
✅ Atrae inversionistas externos  
✅ Escalabilidad del negocio  

### Para los Aportadores:
✅ Inversión pasiva con retorno fijo  
✅ Diversificación de cartera (varios préstamos)  
✅ Transparencia total (ven su dinero trabajando)  
✅ Recuperación gradual del capital  
✅ Reinversión automática disponible  

### Para los Clientes:
✅ Más capital disponible para préstamos  
✅ Mejores tasas (competencia entre aportadores)  
✅ Proceso transparente  

---

## 📝 Tablas de Base de Datos

### `aportadores`
```sql
- id
- nombre, dpi, email, telefono, direccion
- tipo (Persona/Empresa/Institución)
- empresa, nit
- capital_disponible, capital_invertido, capital_recuperado, ganancias_totales
- tasa_interes_minima, plazo_maximo
- monto_minimo_prestamo, monto_maximo_prestamo
- estado (Activo/Inactivo/Suspendido)
- notas
- usuario_id
- created_at, updated_at, deleted_at
```

### `aportaciones`
```sql
- id
- aportador_id (FK)
- prestamo_id (FK)
- monto_aportado
- porcentaje_participacion
- monto_recuperado
- intereses_ganados
- saldo_pendiente
- fecha_aportacion
- fecha_recuperacion_completa
- estado (Activo/Recuperado/Mora)
- notas
- created_at, updated_at
```

### `distribucion_pagos`
```sql
- id
- pago_id (FK)
- aportacion_id (FK)
- aportador_id (FK)
- monto_capital
- monto_interes
- monto_total
- porcentaje_aplicado
- fecha_distribucion
- created_at, updated_at
```

---

## 🔄 Ciclo de Vida Completo

```
1. APORTADOR SE REGISTRA
   └→ Capital disponible: Q 100,000

2. CREAR PRÉSTAMO
   └→ Cliente solicita Q 100,000

3. ASIGNAR APORTADORES
   └→ Aportador A: Q 60,000 (60%)
   └→ Aportador B: Q 40,000 (40%)
   └→ Capital disponible A: Q 40,000
   └→ Capital invertido A: Q 60,000

4. APROBAR PRÉSTAMO
   └→ Cliente retira materiales

5. CLIENTE PAGA CUOTA 1
   └→ Sistema distribuye automáticamente:
      ├→ Aportador A: Q 6,770 (60%)
      └→ Aportador B: Q 4,513 (40%)
   └→ Capital disponible A: Q 46,770 ✅

6. ... CUOTAS 2-12 ...
   └→ Distribución automática cada mes

7. PRÉSTAMO PAGADO COMPLETAMENTE
   └→ Aportador A recuperó: Q 60,000 + Q 21,237 intereses
   └→ Aportador B recuperó: Q 40,000 + Q 14,159 intereses
   └→ Aportaciones marcadas como "Recuperado"
   └→ Capital disponible para reinvertir ♻️
```

---

## 🎯 Próximos Pasos

Para usar el sistema:

1. **Registrar tus primeros aportadores**
   - Ir a "Aportadores" (nuevo módulo en menú)
   - Agregar datos y capital inicial

2. **Al crear préstamo, asignar aportadores**
   - En formulario de préstamo, sección "Fondeo"
   - Seleccionar aportadores y montos

3. **Verificar distribución automática**
   - Registrar un pago de prueba
   - Ver en detalles del aportador que recibió su parte

4. **Monitorear reportes**
   - Dashboard de cada aportador
   - Reporte consolidado del sistema

---

## ⚠️ Consideraciones Importantes

1. **La distribución es automática** - No requiere intervención manual
2. **Los porcentajes se calculan automáticamente** según montos aportados
3. **El capital se devuelve gradualmente** con cada pago del cliente
4. **Los intereses se distribuyen proporcionalmente** igual que el capital
5. **Si un préstamo entra en mora**, las aportaciones también se marcan
6. **El ROI depende de la tasa de interés** del préstamo

---

## 📞 Soporte

Este es un módulo crítico del sistema. Si tienes preguntas:
- Revisar los cálculos en `Pago::distribuirAAportadores()`
- Ver logs en tabla `distribucion_pagos`
- Verificar actualización de `capital_disponible` en aportadores

---

**✅ Sistema de Aportadores completamente funcional y automático.**

Las distribuciones ocurren en segundo plano cada vez que un cliente paga.
