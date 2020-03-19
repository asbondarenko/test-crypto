<?php

namespace App\Modules\Api\Controllers;

use App\Models\Asset;
use App\Http\Resources\Asset as AssetResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Modules\Api\Requests\ListAssetRequest;

class AssetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param ListAssetRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ListAssetRequest $request) {

        $assets = Asset::whereHas('cryptocurrencies', function (Builder $query) use ($request) {
            $query->where('id', $request->query('cryptocurrency_id'));
        })
        ->get();

        return AssetResource::collection($assets);

    }

}