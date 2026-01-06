<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\ChatAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function startConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $conversation = ChatConversation::getOrCreatePrivate(Auth::id(), $request->user_id);
        
        return redirect()->route('chat.show', $conversation);
    }

    public function sendMessage(Request $request, ChatConversation $conversation)
    {
        $request->validate([
            'message' => 'required_without:files|nullable|string',
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

    public function storeAttachment(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:chat_messages,id',
            'file' => 'required|file|max:10240',
        ]);

        $message = ChatMessage::findOrFail($request->message_id);
        $file = $request->file('file');

        $this->saveAttachment($message, $file);

        return response()->json(['success' => true]);
    }

    protected function saveAttachment($message, $file)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $path = $file->store('chat/attachments', 'public');
        
        $thumbnailPath = null;
        
        // Generar miniatura para imágenes si Intervention Image está disponible
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            // Por ahora sin thumbnail, se puede agregar después con Intervention Image
            $thumbnailPath = null;
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
