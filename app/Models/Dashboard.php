<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property User $user
 * @property Widget[] $widgets
 */
class Dashboard extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dashboards';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function widgets()
    {
        return $this->belongsToMany('App\Models\Widget', 'widget_dashboard');
    }
}
