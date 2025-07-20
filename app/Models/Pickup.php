<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
 protected $fillable = [
        'pickup_id',
        'pickup_date',
        'pickup_location',
        'drop_location',
        'size_of_vehicle',
        'email',
        'contact',
        'extra_field_1',
        'extra_field_2',
        'advance_paid',
    ];
}
