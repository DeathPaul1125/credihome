# Chat con Notificaciones

El sistema de chat ahora incluye notificaciones en tiempo real y sonidos cuando llegan mensajes nuevos.

## Características

- **Notificaciones del navegador**: Se solicitan permisos automáticamente para mostrar notificaciones del navegador
- **Notificaciones en pantalla**: Toast messages que aparecen en la esquina superior derecha
- **Sonido de notificación**: Audio que se reproduce cuando llega un mensaje nuevo
- **Actualización en tiempo real**: Los mensajes nuevos se cargan vía AJAX cada 3 segundos sin recargar la página

## Configuración del sonido

Para cambiar el sonido de notificación:

1. Reemplaza el archivo `public/sounds/notification.mp3` con tu archivo de audio preferido
2. El archivo debe ser en formato MP3
3. El volumen está configurado al 50% pero puedes ajustarlo en el JavaScript

## Permisos del navegador

El sistema solicita automáticamente permisos para notificaciones del navegador. Si el usuario bloquea las notificaciones, solo se mostrarán los toast messages en pantalla.

## Funcionamiento técnico

- Se verifica cada 3 segundos si hay mensajes nuevos usando AJAX
- Solo se muestran notificaciones para mensajes de otros usuarios
- Los mensajes se agregan dinámicamente a la interfaz sin recargar la página
- El scroll automático mantiene la conversación al final
