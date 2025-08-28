<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

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
        'image' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
