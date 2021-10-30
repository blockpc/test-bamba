<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'firstname', 'lastname', 'user_id', 'phone'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullname'];

    /**
     * Get the fullname attribute for user or username by defult.
     *
     * @return bool
     */
    public function getFullnameAttribute()
    {
        return ($this->attributes['firstname'] || $this->attributes['firstname']) ? trim("{$this->attributes['firstname']} {$this->attributes['lastname']}") : null;
    }

    // one profile belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get image User. Polimorph Relation
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
