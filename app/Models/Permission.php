<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasUuid;
    use HasFactory;
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
