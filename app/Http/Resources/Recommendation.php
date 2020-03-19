<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Recommendation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=> $this->id,
        'user' => new UserResource($this->user),
        'author' => new UserResource($this->author),
        'body'=> $this->body,
        'hear_about_us' => $this->hear_about_us,
        'count_likes' => $this->count_likes,
        'count_dislikes' => $this->count_dislikes,
        'created_at' => $this->created_at->format("d F Y"),
        ];
    }
}
