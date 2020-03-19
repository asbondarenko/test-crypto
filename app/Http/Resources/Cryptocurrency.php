<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\File as FileResource;
use App\Http\Resources\Asset as AssetResource;

class Cryptocurrency extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $imageFileResource = new FileResource($this->image);
        $imageTransparentFileResource = new FileResource($this->image_transparent);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'abbreviation' => $this->abbreviation,
            'image' => $imageFileResource->toArray($request),
            'image_transparent' => $imageTransparentFileResource->toArray($request),
            'assets' => AssetResource::collection($this->assets)->toArray($request)
        ];
    }
}
