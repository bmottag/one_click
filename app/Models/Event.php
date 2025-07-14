<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
    protected $fillable = ['title', 'place', 'description', 'date', 'user_id', 'link', 'instagram'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
