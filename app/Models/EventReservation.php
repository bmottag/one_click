<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventReservation extends Model
{
    protected $table = 'events_reservation';

    protected $fillable = ['user_id', 'event_id', 'date'];
}
