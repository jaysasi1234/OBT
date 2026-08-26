<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $table = 'chat_groups';

    protected $fillable = [
        'batch_id',
        'name',
        'description',
        'avatar',
        'created_by',
    ];

    public function batch()
    {
        return $this->belongsTo(
            Batch::class,
            'batch_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function members()
    {
        return $this->hasMany(
            ChatGroupMember::class,
            'chat_group_id'
        );
    }

    public function messages()
    {
        return $this->hasMany(
            Message::class,
            'chat_group_id'
        );
    }
}