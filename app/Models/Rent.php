<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'rent_title',
        'description',
        'contact_number',
        'due_date',
        'images',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
