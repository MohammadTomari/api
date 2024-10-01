<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'user_id',
        'post_id',
        'reply_to',
    ];

    public function user_id(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post_id(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
