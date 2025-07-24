<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'user_id',
        'rent_title',
        'description',
        'contact_number',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
