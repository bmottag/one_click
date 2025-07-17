<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // Indica el nombre real de la tabla
    protected $table = 'employments';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'job_title',
        'job_description',
        'contact_number',
        'due_date',
    ];

    // Relaciones (ejemplo con User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
