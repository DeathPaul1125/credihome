# CrediHome GT - Sistema de Préstamos para Guatemala

## 📋 Descripción General

CrediHome GT es un sistema completo de gestión de préstamos de dinero en efectivo, diseñado específicamente para el mercado guatemalteco. El sistema incluye funcionalidades para administrar clientes, préstamos, pagos y generar reportes.

## 🇬🇹 Características Específicas de Guatemala

### Moneda
- **Quetzal Guatemalteco (GTQ)**: Símbolo `Q`
- Formato: `Q 2,450,500.00`

### Documentación de Identidad
- **DPI (Documento Personal de Identificación)**
- Formato: `XXXX XXXXX XXXX` (13 dígitos divididos en grupos)
- Ejemplo: `2547 85412 0101`

### Ubicaciones
Guatemala está dividido en:
- **22 Departamentos** (equivalente a estados/provincias)
- **340 Municipios**
- Áreas urbanas y rurales

### Formato de Teléfono
- Código de país: `+502`
- Formato: `+502 XXXX-XXXX` (8 dígitos)
- Ejemplo: `+502 5547-8965`

## 🎯 Funcionalidades del Sistema

### 1. Dashboard Principal
**Ubicación**: `resources/views/dashboard-prestamos.blade.php`

Métricas principales:
- ✅ **Préstamos Activos**: Total de préstamos en curso
- 💰 **Capital Prestado**: Monto total en Quetzales
- 📊 **Tasa de Recuperación**: Porcentaje de recuperación
- ⚠️ **Préstamos Vencidos**: Cantidad de préstamos atrasados

Gráficos:
- **Préstamos Desembolsados por Mes**: Visualización del flujo de préstamos mensuales
- **Estado de Préstamos**: Distribución por estado (Activos, Pagados, En Mora, Vencidos)
- **Tabla de Próximos Pagos**: Lista de pagos pendientes de la semana

### 2. Módulo de Clientes
Gestión completa de prestatarios:
- Registro con DPI guatemalteco
- Datos de contacto (teléfono, dirección)
- Historial de préstamos
- Evaluación crediticia
- Referencias personales

Campos importantes:
```php
- nombre_completo
- dpi (formato: XXXX XXXXX XXXX)
- telefono (formato: +502 XXXX-XXXX)
- direccion_completa
- departamento
- municipio
- fecha_nacimiento
- estado_civil
- profesion
- lugar_trabajo
```

### 3. Módulo de Préstamos
Funcionalidades:
- Crear nuevo préstamo
- Calcular intereses
- Establecer calendario de pagos
- Tipos de interés (simple o compuesto)
- Plazos flexibles (semanal, quincenal, mensual)
- Generación automática de contratos

Campos del préstamo:
```php
- cliente_id
- monto_prestado (en Quetzales)
- tasa_interes (porcentaje)
- plazo (cantidad de cuotas)
- frecuencia_pago (semanal/quincenal/mensual)
- fecha_desembolso
- fecha_primer_pago
- monto_cuota
- garantia (opcional)
- estado (activo/pagado/vencido/en_mora)
```

### 4. Módulo de Pagos y Cobros
Gestión de pagos:
- Registro de pagos parciales o totales
- Historial de transacciones
- Aplicación de intereses moratorios
- Recibos automáticos
- Notificaciones de pagos pendientes

Tipos de pago:
- ✅ Pago puntual
- ⏰ Pago atrasado
- 💸 Pago anticipado
- 📝 Pago parcial

### 5. Módulo de Reportes
Reportes disponibles:
- **Cartera activa**: Préstamos vigentes
- **Cartera vencida**: Préstamos en mora
- **Flujo de caja**: Entradas y salidas
- **Rentabilidad**: Análisis de ganancias
- **Historial de cliente**: Comportamiento de pago
- **Proyección de ingresos**: Pagos esperados

Formatos de exportación:
- PDF
- Excel
- CSV

## 🔧 Configuración del Sistema

### Tasas de Interés Recomendadas para Guatemala

Según el mercado guatemalteco de microfinanzas:

```php
// config/prestamos.php (crear este archivo)
return [
    'tasa_interes_minima' => 3.0,  // 3% mensual
    'tasa_interes_maxima' => 6.0,  // 6% mensual
    'tasa_interes_mora' => 2.0,    // 2% sobre saldo vencido
    'plazo_minimo_dias' => 30,
    'plazo_maximo_meses' => 36,
    'monto_minimo' => 500,          // Q 500
    'monto_maximo' => 50000,        // Q 50,000
];
```

### Regulaciones Importantes

1. **Ley contra el Lavado de Dinero**
   - Verificación de identidad obligatoria
   - Registro de transacciones mayores a Q10,000
   - Reporte de actividades sospechosas

2. **Protección al Consumidor**
   - Transparencia en tasas de interés
   - Contratos claros y firmados
   - Derecho a pago anticipado sin penalización

3. **GDPR/Protección de Datos**
   - Consentimiento para uso de datos personales
   - Derecho al olvido
   - Seguridad de información

## 📊 Cálculo de Intereses

### Interés Simple
```php
Interés = Capital × Tasa × Tiempo
Monto Total = Capital + Interés
```

Ejemplo:
- Capital: Q 10,000
- Tasa: 4% mensual
- Plazo: 12 meses
- Interés: Q 10,000 × 0.04 × 12 = Q 4,800
- Total a pagar: Q 14,800
- Cuota mensual: Q 14,800 / 12 = Q 1,233.33

### Sistema de Amortización Francés (más común)
```php
Cuota = Capital × [i(1+i)^n] / [(1+i)^n - 1]
donde:
- i = tasa de interés por periodo
- n = número de periodos
```

## 🎨 Interfaz de Usuario

### Esquema de Colores
- **Primary (Brand)**: `#465FFF` - Azul principal
- **Success**: `#10b981` - Verde para estados positivos
- **Warning**: `#facc15` - Amarillo para alertas
- **Danger**: `#ef4444` - Rojo para vencidos/errores

### Iconografía
Se utilizan SVG personalizados para:
- 💼 Clientes
- 💰 Préstamos
- 💳 Pagos
- 📊 Reportes
- ⚙️ Configuración

## 🔐 Seguridad

### Mejores Prácticas Implementadas
1. **Autenticación**: Laravel Jetstream con 2FA
2. **Autorización**: Control de acceso por roles
3. **Encriptación**: Datos sensibles encriptados
4. **Auditoría**: Log de todas las transacciones
5. **Backup**: Respaldos automáticos diarios

### Roles de Usuario Recomendados
- **Administrador**: Acceso total
- **Gerente**: Aprobar préstamos grandes
- **Cajero**: Registrar pagos
- **Cobrador**: Ver pagos pendientes
- **Auditor**: Solo lectura de reportes

## 📱 Responsive Design

El sistema está optimizado para:
- 💻 Desktop (1920px+)
- 💻 Laptop (1366px - 1920px)
- 📱 Tablet (768px - 1366px)
- 📱 Mobile (< 768px)

## 🚀 Próximos Pasos Recomendados

### Fase 1: Funcionalidades Básicas
- [ ] CRUD completo de clientes
- [ ] CRUD completo de préstamos
- [ ] Sistema de registro de pagos
- [ ] Generación de recibos en PDF

### Fase 2: Características Avanzadas
- [ ] Notificaciones por SMS/WhatsApp
- [ ] Calculadora de préstamos
- [ ] Firma digital de contratos
- [ ] Geolocalización de clientes

### Fase 3: Análisis y Reportes
- [ ] Dashboard con KPIs en tiempo real
- [ ] Reportes avanzados con filtros
- [ ] Análisis predictivo de mora
- [ ] Exportación masiva de datos

### Fase 4: Integraciones
- [ ] Integración con bancos guatemaltecos
- [ ] Pasarela de pagos (Visanet GT)
- [ ] Verificación de DPI automática
- [ ] WhatsApp Business API

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 11.x
- **Frontend**: Blade + Alpine.js
- **CSS**: Tailwind CSS 3.4
- **Charts**: ApexCharts
- **Autenticación**: Laravel Jetstream
- **Base de Datos**: MySQL/PostgreSQL

## 📞 Soporte

Para dudas o soporte técnico:
- Documentación completa en `/docs`
- Issues en GitHub
- Email de soporte

## 📄 Licencia

Este sistema es propiedad de CrediHome GT. Todos los derechos reservados.

---

**Versión**: 1.0.0  
**Última actualización**: Enero 2026  
**Desarrollado para**: Mercado guatemalteco de microfinanzas
