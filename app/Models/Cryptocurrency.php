<?php

namespace App\Models;

use App\Traits\FilesMorphTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property User[] $users
 */
class Cryptocurrency extends Model
{
    use FilesMorphTrait;

    const ENTITY_TYPE = 'cryptocurrencies';

    const IMAGE_FIELD_NAME = 'image';
    const IMAGE_TRANSPARENT_FIELD_NAME = 'image_transparent';

    const DEFAULT_ORDER = 0;

    function __construct(array $attributes = [])
    {
        $this->entity_type = static::ENTITY_TYPE;
        parent::__construct($attributes);
    }

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'color'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image', 'image_transparent'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assets()
    {
        return $this->belongsToMany('App\Models\Asset');
    }

    /**
     *  Get image attached to the cryptocurrency.
     *
     * @return mixed
     */
    public function getImageAttribute()
    {
        return $this->files()->where('field_name', static::IMAGE_FIELD_NAME)->first();
    }

    /**
     *  Get image transparent attached to the cryptocurrency.
     *
     * @return mixed
     */
    public function getImageTransparentAttribute()
    {
        return $this->files()->where('field_name', static::IMAGE_TRANSPARENT_FIELD_NAME)->first();
    }
}
