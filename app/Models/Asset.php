<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Cryptocurrency[] $cryptocurrencies
 */
class Asset extends Model
{

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cryptocurrencies()
    {
        return $this->belongsToMany('App\Models\Cryptocurrency');
    }
}
