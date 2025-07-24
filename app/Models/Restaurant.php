<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Restaurant extends Model
{
   protected $fillable = [
        'user_id',    
        'restaurant_name',
        'description',
        'contact_number',
        'address',
        'email',
        'image',
        'link',
        'facebook',
        'instagram',
        'youtube',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
