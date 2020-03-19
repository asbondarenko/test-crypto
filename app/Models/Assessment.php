<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    const LIKE = 1;
    const DISLIKE = 0;
    const VOID = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recommendation_id',
        'state',
    ];

    public $timestamps = false;

    /**
     * Get assessment's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get recommendation by assessment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'recommendation_id');
    }
}
