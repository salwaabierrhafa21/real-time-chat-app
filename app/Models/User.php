<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function status()
    {
        return $this->hasOne(UserStatus::class);
    }
}