<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
   use SoftDeletes;

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
        'google',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
