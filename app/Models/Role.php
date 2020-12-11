<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    const ENTITY = 'Roles';
    const SlUG = 'roles';

    const GUEST = 'guest';
    const SUBSCRIBER = 'subscriber';
    const USER = 'user';
    const MEMBER = 'member';
    const AUTHOR = 'author';
    const MODERATOR = 'moderator';
    const ADMIN = 'admin';
}
