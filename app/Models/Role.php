<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';

    protected $guarded = ['deleted_at', 'request_by'];

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
