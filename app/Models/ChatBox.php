<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    protected $table = 'chatboxes';

    protected $fillable = [
        'user_id',
        'total_tokens',
        'messages',
    ];
}
