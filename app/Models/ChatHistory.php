<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $fillable = ['user_id', 'message', 'sender'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
