<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property Dashboard[] $dashboards
 */
class Widget extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dashboards()
    {
        return $this->belongsToMany('App\Models\Dashboard', 'widget_dashboard');
    }
}
