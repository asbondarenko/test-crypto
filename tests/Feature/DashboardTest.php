<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Dashboard;
use App\Models\Widget;
use App\Http\Resources\Dashboard as DashboardResource;
use App\Http\Resources\Widget as WidgetResource;

class DashboardTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test, whether dashboards are being listed correctly.
     */
    public function testDashboardsAreListedCorrectly()
    {
        $user = $this->createUser();
        $dashboards = factory(Dashboard::class, 3)->create(['user_id' => $user->id]);
        foreach ($dashboards as $dashboard) {
            $widget = factory(Widget::class)->create();

            $dashboard->widgets()->attach($widget->id);
        }
        $assertJson = DashboardResource::collection($dashboards);

        $response = $this->authorizedJson('GET', '/api/dashboards', [], [], $user);

        $response->assertStatus(200)
            ->assertJson(['data' => $assertJson->toArray(null)]);
    }

    /**
     * Test, whether dashboard is being created correctly.
     */
    public function testDinnerPlacesAreCreatedCorrectly()
    {
        $user = $this->createUser();
        $dashboard = factory(Dashboard::class)->make(['user_id' => $user->id]);
        $widget = factory(Widget::class)->create();
        $payload = [
            'name' => $dashboard->name,
            'widgets' => [$widget->id]
        ];

        $assertJson = [
            'name' => $dashboard->name,
            'widgets' => WidgetResource::collection([$widget])->toArray(null)
        ];

        $response = $this->authorizedJson('POST', '/api/dashboards', $payload, [], $user);
        $response->assertStatus(201)
            ->assertJson($assertJson);
    }
}
