<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $guarded = ['deleted_at'];

    protected $dates = ['deleted_at'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class);
    }
}
