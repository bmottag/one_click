<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   protected $fillable = [
        'user_id',    
        'company_name',
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
