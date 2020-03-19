<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Role;
use App\Http\Resources\Cryptocurrency as CryptocurrencyResource;

class User extends JsonResource
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
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'active' => $this->active,
            'web_notifications' => $this->web_notifications,
            'terms_and_conditions' => $this->terms_and_conditions,
            'hear_about_us' => $this->hear_about_us,
            'motto' => $this->motto,
            'about_me' => $this->about_me,
            'email_alerts' => $this->email_alerts,
            'sms_alerts' => $this->sms_alerts,
            'avatar' => $this->avatar,
            'landscape' => $this->landscape,
            'cryptocurrencies' => CryptocurrencyResource::collection($this->cryptocurrencies)->toArray($request)
        ];
    }
}
