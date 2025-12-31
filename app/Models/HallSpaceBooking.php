<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallSpaceBooking extends Model
{
    protected $fillable = [
        'space',
        'note',
    ];
}
