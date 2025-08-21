<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Event;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_status',
        'contact_number',
        'password',
        'state_id',
        'city_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function isAdmin()
    {
        return $this->role === 'administrator';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getUserStatusLabelAttribute()
    {
        return match ($this->user_status) {
            'canadian_citizen'   => 'Canadian Citizen',
            'permanent_resident' => 'Permanent Resident',
            'temporary_resident' => 'Temporary Resident',
            'refugee'            => 'Refugee / Protected Person',
            'other'              => 'Other',
            default              => 'N/A',
        };
    }

    public function getRoleBadgeAttribute()
    {
        return match ($this->role) {
            'registered_user' => '<span class="badge py-3 px-4 fs-7 badge-light-primary">Registered User</span>',
            'administrator'   => '<span class="badge py-3 px-4 fs-7 badge-light-danger">Administrator</span>',
            'super_admin'     => '<span class="badge py-3 px-4 fs-7 badge-light-warning">Super Admin</span>',
            default           => '<span class="badge py-3 px-4 fs-7 badge-light-secondary">N/A</span>',
        };
    }


}
