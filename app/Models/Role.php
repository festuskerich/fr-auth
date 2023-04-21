<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $fillable = [
        'name', 'label'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function allowTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstorFail();
        }
        return $this->permissions()->sync($permission, false);
    }
}
