<?php

namespace App\Models;

use App\Traits\UserRoleTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\HasApiTokens;
use App\Traits\FilesMorphTrait;

class User extends Authenticatable
{
    use HasApiTokens, Authorizable, UserRoleTrait, Notifiable, FilesMorphTrait;

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const WEB_NOTIFICATIONS_DISABLED = 0;
    const WEB_NOTIFICATIONS_ENABLED = 1;

    const TERMS_AND_CONDITIONS_NOT_ACCEPTED = 0;
    const TERMS_AND_CONDITIONS_ACCEPTED = 1;

    const AVATAR_FIELD_NAME = 'avatar';
    const LANDSCAPE_FIELD_NAME = 'landscape';

    const ENTITY_TYPE = 'users';

    function __construct(array $attributes = [])
    {
        $this->entity_type = static::ENTITY_TYPE;
        parent::__construct($attributes);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'web_notifications', 'terms_and_conditions', 'hear_about_us', 'motto', 'about_me', 'email_alerts', 'sms_alerts'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar', 'landscape'
    ];

    /**
     *  User avatar
     *
     * @return mixed
     */
    public function getAvatarAttribute()
    {
        return $this->files()->where('field_name', User::AVATAR_FIELD_NAME)->first();
    }

    /**
     *  User landscape
     *
     * @return mixed
     */
    public function getLandscapeAttribute()
    {
        return $this->files()->where('field_name', User::LANDSCAPE_FIELD_NAME)->first();
    }

    /**
     * User cryptocurrencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cryptocurrencies()
    {
        return $this->belongsToMany('App\Models\CryptoCurrency');
    }

    /**
     * Get user recommendations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'user_id');
    }

    /**
     * Get assessment's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'user_id');
    }
}
