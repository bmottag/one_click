<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
   use SoftDeletes;

   protected $fillable = [
        'user_id',    
        'restaurant_name',
        'description',
        'contact_number',
        'address',
        'email',
        'images',
        'link',
        'facebook',
        'instagram',
        'youtube',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
