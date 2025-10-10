<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'reserve_date',
        'service',
        'no_rue_depart',
        'ville_depart',
        'code_postal_depart',
        'etage_depart',
        'pieces_depart',
        'no_rue_destination',
        'ville_destination',
        'code_postal_destination',
        'etage_destination',
        'installation_type',
        'equipe',
        'event_description',
        'status',
        'stripe_session_id',
        'stripe_payment_intent',
        'amount_paid',
        'currency'
    ];
}
