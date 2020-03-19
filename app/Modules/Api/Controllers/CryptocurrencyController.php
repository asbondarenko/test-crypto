<?php

namespace App\Modules\Api\Controllers;


use App\Models\Cryptocurrency;
use App\Http\Resources\Cryptocurrency as CryptocurrencyResource;

class CryptocurrencyController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cryptocurrencies = Cryptocurrency::orderBy('order', 'asc')->get();

        return CryptocurrencyResource::collection($cryptocurrencies);
    }

    /**
     * Display the specified resource.
     * @param Cryptocurrency $cryptocurrency
     * @return CryptocurrencyResource
     */
    public function show(Cryptocurrency $cryptocurrency)
    {
        return new CryptocurrencyResource($cryptocurrency);
    }

}