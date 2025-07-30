<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // Permissions can be associated with multiple roles (many-to-many)
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
