<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'profiles';

    protected $guarded = ['deleted_at'];

    protected $dates = ['deleted_at'];

    public function profileable()
    {
        return $this->morphTo();
    }
}
