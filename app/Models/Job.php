<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    // Indica el nombre real de la tabla
    protected $table = 'employments';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'job_title',
        'company',
        'job_description',
        'contact_number',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relaciones (ejemplo con User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
