<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tourism extends Model
{
   use SoftDeletes;

   protected $fillable = [
        'user_id',    
        'company_name',
        'description',
        'contact_number',
        'address',
        'email',
        'images',
        'link',
        'facebook',
        'instagram',
        'youtube',
        'google',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
