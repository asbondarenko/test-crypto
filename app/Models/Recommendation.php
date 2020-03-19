<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'hear_about_us',
        'user_id',
        'author_id',
    ];

    /**
     * Get a user for whom the recommendation is created.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get author of the recommendation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get assessments of the recommendation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'recommendation_id');
    }

    /**
     * Get count likes.
     *
     * @return int
     */
    public function getCountLikesAttribute()
    {
        $count = $this->assessments()->where('state', Assessment::LIKE)->count();
        return $count;
    }

    /**
     * Get count dislikes.
     *
     * @return int
     */
    public function getCountDislikesAttribute()
    {
        $count = $this->assessments()->where('state', Assessment::DISLIKE)->count();
        return $count;
    }
}
