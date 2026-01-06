<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatConversation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'type',
        'created_by',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_conversation_user', 'conversation_id', 'user_id')
            ->withPivot('last_read_at', 'unread_count', 'is_muted')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latest();
    }

    public function unreadCountFor($userId)
    {
        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function markAsReadFor($userId)
    {
        $this->messages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $this->users()->updateExistingPivot($userId, [
            'last_read_at' => now(),
            'unread_count' => 0,
        ]);
    }

    public static function getOrCreatePrivate($user1Id, $user2Id)
    {
        $conversation = self::where('type', 'private')
            ->whereHas('users', function ($query) use ($user1Id) {
                $query->where('user_id', $user1Id);
            })
            ->whereHas('users', function ($query) use ($user2Id) {
                $query->where('user_id', $user2Id);
            })
            ->first();

        if (!$conversation) {
            $conversation = self::create([
                'type' => 'private',
                'created_by' => $user1Id,
            ]);
            $conversation->users()->attach([$user1Id, $user2Id]);
        }

        return $conversation;
    }
}
