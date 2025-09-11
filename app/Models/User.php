<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Event;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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
        'image',
        'role',
        'stripe_id'
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
        if ($this->role !== 'administrator') {
            return false;
        }

        $subscription = $this->latestSubscription;

        return $subscription 
            && $subscription->ends_at 
            && Carbon::parse($subscription->ends_at)->isFuture();
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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function latestSubscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany(); 
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

    public function getAvatarAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('template/assets/media/avatars/blank.png');
    }

    public function getRoleLabel($short = false)
    {
        return match ($this->role) {
            'registered_user' => $short ? 'Registered' : 'Registered User',
            'administrator'   => $short ? 'Admin' : 'Administrator',
            'super_admin'     => 'Super Admin',
            default           => 'N/A',
        };
    }

    public function getRoleBadge($short = false)
    {
        $classes = match ($this->role) {
            'registered_user' => 'badge-light-primary',
            'administrator'   => 'badge-light-danger',
            'super_admin'     => 'badge-light-warning',
            default           => 'badge-light-secondary',
        };

        return sprintf(
            '<span class="badge py-3 px-4 fs-8 ms-2 %s">%s</span>',
            $classes,
            $this->getRoleLabel($short)
        );
    }


}
