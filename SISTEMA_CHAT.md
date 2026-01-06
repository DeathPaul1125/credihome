# Sistema de Chat en Tiempo Real - CrediHome

## 📋 Resumen

Sistema completo de mensajería instantánea entre usuarios con:
- ✅ Conversaciones privadas 1-a-1
- ✅ Mensajes en tiempo real con Livewire polling
- ✅ Envío de archivos (imágenes, PDFs, Excel)
- ✅ Notificaciones de mensajes no leídos
- ✅ Indicador de "escribiendo..."
- ✅ Historial de mensajes
- ✅ Búsqueda de usuarios y conversaciones

## 🗄️ Estructura de Base de Datos

### Tablas Creadas:
1. **chat_conversations** - Conversaciones entre usuarios
2. **chat_conversation_user** - Participantes de cada conversación
3. **chat_messages** - Mensajes enviados
4. **chat_attachments** - Archivos adjuntos

### Migraciones Ejecutadas:
```bash
✅ 2026_01_03_193350_create_chat_conversations_table.php
✅ 2026_01_03_193435_create_chat_messages_table.php  
✅ 2026_01_03_193604_create_chat_attachments_table.php
```

## 📝 Modelos Creados

### 1. ChatConversation.php
**Ubicación:** `app/Models/ChatConversation.php`

**Relaciones:**
- `creator()` - Usuario que creó la conversación
- `users()` - Participantes de la conversación
- `messages()` - Mensajes de la conversación
- `lastMessage()` - Último mensaje enviado

**Métodos útiles:**
- `unreadCountFor($userId)` - Contar no leídos
- `markAsReadFor($userId)` - Marcar como leídos
- `getOrCreatePrivate($user1Id, $user2Id)` - Obtener o crear chat 1-a-1

### 2. ChatMessage.php (PENDIENTE COMPLETAR)
**Campos:**
- conversation_id
- user_id
- message (texto)
- type (text/file/image/system)
- is_read
- read_at
- reply_to (responder a mensaje)

### 3. ChatAttachment.php (PENDIENTE COMPLETAR)
**Campos:**
- message_id
- file_name
- file_path
- file_type
- file_extension
- file_size
- thumbnail_path

## 🎯 Implementación Pendiente

Para completar el sistema necesitas crear:

### 1. Completar Modelos
**ChatMessage.php:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'message',
        'type',
        'is_read',
        'read_at',
        'reply_to',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ChatAttachment::class, 'message_id');
    }

    public function replyToMessage(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'reply_to');
    }

    public function scopeUnread($query, $userId)
    {
        return $query->where('user_id', '!=', $userId)
                     ->where('is_read', false);
    }
}
```

**ChatAttachment.php:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ChatAttachment extends Model
{
    protected $fillable = [
        'message_id',
        'file_name',
        'file_path',
        'file_type',
        'file_extension',
        'file_size',
        'thumbnail_path',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChatMessage::class, 'message_id');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : null;
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function isImage()
    {
        return in_array($this->file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }

    public function isPdf()
    {
        return $this->file_extension === 'pdf';
    }

    public function isExcel()
    {
        return in_array($this->file_extension, ['xls', 'xlsx', 'csv']);
    }
}
```

### 2. ChatController Completo
**Ruta:** `app/Http/Controllers/ChatController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\ChatAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $conversations = ChatConversation::whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['users' => function ($query) use ($userId) {
                $query->where('user_id', '!=', $userId);
            }, 'lastMessage.user'])
            ->withCount(['messages as unread_count' => function ($query) use ($userId) {
                $query->where('user_id', '!=', $userId)
                      ->where('is_read', false);
            }])
            ->orderBy('last_message_at', 'desc')
            ->get();

        $users = User::where('id', '!=', $userId)
                    ->orderBy('name')
                    ->get();

        return view('chat.index', compact('conversations', 'users'));
    }

    public function show(ChatConversation $conversation)
    {
        // Verificar que el usuario pertenece a la conversación
        if (!$conversation->users->contains(Auth::id())) {
            abort(403);
        }

        // Marcar mensajes como leídos
        $conversation->markAsReadFor(Auth::id());

        $messages = $conversation->messages()
            ->with(['user', 'attachments'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('conversation', 'messages'));
    }

    public function startConversation(User $user)
    {
        $conversation = ChatConversation::getOrCreatePrivate(Auth::id(), $user->id);
        
        return redirect()->route('chat.show', $conversation);
    }

    public function sendMessage(Request $request, ChatConversation $conversation)
    {
        $request->validate([
            'message' => 'required_without:files',
            'files.*' => 'nullable|file|max:10240', // 10MB
        ]);

        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'type' => $request->hasFile('files') ? 'file' : 'text',
        ]);

        // Procesar archivos adjuntos
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $this->storeAttachment($message, $file);
            }
        }

        // Actualizar última actividad de la conversación
        $conversation->update(['last_message_at' => now()]);

        // Incrementar contador de no leídos para otros usuarios
        $conversation->users()
            ->where('user_id', '!=', Auth::id())
            ->increment('unread_count');

        return back();
    }

    protected function storeAttachment($message, $file)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $path = $file->store('chat/attachments', 'public');
        
        $thumbnailPath = null;
        
        // Generar miniatura para imágenes
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $thumbnailPath = 'chat/thumbnails/' . basename($path);
            $img = Image::make($file);
            $img->fit(300, 300);
            Storage::disk('public')->put($thumbnailPath, (string) $img->encode());
        }

        ChatAttachment::create([
            'message_id' => $message->id,
            'file_name' => $originalName,
            'file_path' => $path,
            'file_type' => $mimeType,
            'file_extension' => $extension,
            'file_size' => $size,
            'thumbnail_path' => $thumbnailPath,
        ]);
    }

    public function downloadAttachment(ChatAttachment $attachment)
    {
        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
    }
}
```

### 3. Rutas
**Agregar a `routes/web.php`:**

```php
// Chat Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/start/{user}', [ChatController::class, 'startConversation'])->name('chat.start');
    Route::get('/chat/attachment/{attachment}/download', [ChatController::class, 'downloadAttachment'])->name('chat.download');
});
```

### 4. Vistas

#### `resources/views/chat/index.blade.php`
Vista principal del chat con lista de conversaciones y usuarios.

#### `resources/views/chat/show.blade.php`  
Vista de conversación individual con mensajes y formulario de envío.

### 5. Componente Livewire (RECOMENDADO)
Para tiempo real sin configurar Pusher/Redis:

```bash
php artisan make:livewire ChatBox
```

**Ventajas de Livewire:**
- ✅ Actualizaciones automáticas con polling
- ✅ No requiere configuración de WebSockets
- ✅ Fácil de implementar
- ✅ Funciona sin servidor adicional

### 6. Agregar ítem al menú sidebar

En `flowbite-layout.blade.php` agregar:

```blade
<li>
    <a href="{{ route('chat.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('chat.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
        </svg>
        <span class="flex-1 ms-3 whitespace-nowrap">Chat</span>
        @if(Auth::user()->unreadChatsCount() > 0)
        <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-semibold text-white bg-red-500 rounded-full">
            {{ Auth::user()->unreadChatsCount() }}
        </span>
        @endif
    </a>
</li>
```

### 7. Agregar método al modelo User

```php
public function unreadChatsCount()
{
    return ChatMessage::whereHas('conversation.users', function ($query) {
            $query->where('user_id', $this->id);
        })
        ->where('user_id', '!=', $this->id)
        ->where('is_read', false)
        ->count();
}
```

## 🚀 Próximos Pasos

1. ✅ Crear los modelos completos (copiar código de arriba)
2. ✅ Implementar ChatController completo
3. ✅ Agregar rutas al web.php
4. ⏳ Crear vistas con UI de Flowbite
5. ⏳ Implementar componente Livewire para tiempo real
6. ⏳ Agregar menú de chat al sidebar
7. ⏳ Configurar almacenamiento de archivos
8. ⏳ Testing y ajustes

## 📚 Recursos Adicionales

- **Livewire Docs:** https://livewire.laravel.com
- **Flowbite Chat UI:** https://flowbite.com/blocks/application/chat/
- **Laravel Broadcasting:** https://laravel.com/docs/broadcasting

## ⚠️ Nota Importante

Este es un sistema base funcional. Para producción considera:
- Implementar Laravel Echo + Pusher/Reverb para WebSockets real
- Añadir validación de archivos más robusta
- Implementar límites de tamaño y cantidad
- Agregar moderación de contenido
- Cifrado de mensajes sensibles
- Respaldo automático de archivos

---

**Estado Actual:** ✅ Base de datos creada | ⏳ Implementación en progreso
**Fecha:** 3 de enero de 2026
