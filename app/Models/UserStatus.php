<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $table = 'user_status';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'is_online',
        'last_seen'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}