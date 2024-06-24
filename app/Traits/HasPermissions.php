<?php

namespace App\Traits;

use Illuminate\Support\Str;


trait HasPermissions
{
    /**
     * Determine if the model may perform the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function hasPermissionTo(string $permission): bool
    {
        return  $this->permissions()->where('name', $permission)->exists();
    }
}
