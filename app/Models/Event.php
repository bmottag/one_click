<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Event extends Model
{
   protected $fillable = [
        'user_id',    
        'title',
        'place',
        'description',
        'date',
        'image',
        'link',
        'instagram',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
