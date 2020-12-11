<?php

namespace App\Models;


class AuthProvider
{
    protected $fillable = ['provider', 'provider_id', 'user_id', 'avatar'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
