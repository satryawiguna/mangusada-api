<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'cars';

    protected $guarded = ['deleted_at'];

    protected $dates = ['deleted_at'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
