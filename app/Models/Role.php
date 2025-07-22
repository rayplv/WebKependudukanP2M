<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Roles can have multiple permissions (many-to-many)
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // [superadmin] can have one user (one-to-one)
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // [admin] can be assigned to many users (one-to-many)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
