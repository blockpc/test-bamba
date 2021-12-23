<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Blockpc\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function getRoleIdAttribute()
    {
        return $this->roles()->first()->id;
    }

    public function getCargoAttribute()
    {
        return $this->roles()->first()->display_name;
    }

    public function scopeAllowed($query)
    {
        $all_roles_except_sudo = Role::whereNotIn('name', ['sudo'])->get();
        if( current_user()->hasRole('sudo') ) {
            return $query;
        } else {
            return $query->role($all_roles_except_sudo);
        }
    }
}
