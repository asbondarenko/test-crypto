<?php

namespace App\Modules\Api\Controllers;

use App\Models\Dashboard;
use App\Models\Widget;
use App\Http\Resources\Dashboard as DashboardResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $dashboards = Dashboard::where('user_id', $user->id)->get();

        return DashboardResource::collection($dashboards);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        $this->authorize('view', $dashboard);

        return new DashboardResource($dashboard);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = array_merge($request->all(), ['user_id' => $user->id]);

        $dashboard = Dashboard::create($data);

        $widgets = $request->get('widgets');
        if (is_array($widgets)) {
            foreach ($widgets as $id) {
                $widget = Widget::findOrFail($id);
            }

            $dashboard->widgets()->sync($widgets);
        }

        return response()->json(new DashboardResource($dashboard), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Dashboard $dashboard
     * @return DasboardResource
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        $user = Auth::user();

        $data = array_merge($request->all(), ['user_id' => $user->id]);

        $widgets = $request->get('widgets');
        if (is_array($widgets)) {
            foreach ($widgets as $id) {
                $widget = Widget::findOrFail($id);
            }

            $dashboard->widgets()->sync($widgets);
        }

        $dashboard->update($data);

        return new DashboardResource($dashboard);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        $this->authorize('delete', $dashboard);

        $dashboard->delete();

        return response()->json(null, 204);
    }

}