<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesPermissions extends Model
{
    protected $table = 'roles_permissions';
    public $timestamps = true;
    protected $fillable = [
        'role_id', 'permissions'
    ];
    use HasFactory;
}
